<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Profile;
use Smalot\PdfParser\Parser;

class UserProfile extends Component
{
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $linkedin_url;
    public $github_url;
    public $portfolio_url;
    public $resume_path;
    public $resume;
    public $target_roles;
    public $target_locations = '';
    public $remote_preference = 'include';
    public $max_job_age_days = 7;
    
    public $saved = false;
    public $api_token;

    public function mount()
    {
        $profile = auth()->user()->profile;
        if ($profile) {
            $this->first_name = $profile->first_name;
            $this->last_name = $profile->last_name;
            $this->email = $profile->email;
            $this->phone = $profile->phone;
            $this->linkedin_url = $profile->linkedin_url;
            $this->github_url = $profile->github_url;
            $this->portfolio_url = $profile->portfolio_url;
            $this->resume_path = $profile->resume_path;
            $this->target_roles = $profile->target_roles;
            $this->target_locations = $profile->target_locations;
            $this->remote_preference = $profile->remote_preference ?? 'include';
            $this->max_job_age_days = $profile->max_job_age_days ?? 7;
        }
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'resume' => 'nullable|file|mimes:pdf|max:2048',
            'target_roles' => 'nullable|string',
            'target_locations' => 'nullable|string',
            'remote_preference' => 'required|in:none,include,only',
            'max_job_age_days' => 'required|integer|min:1|max:30',
        ]);

        $profile = auth()->user()->profile ?? new \App\Models\Profile(['user_id' => auth()->id()]);
        
        $profile->first_name = $this->first_name;
        $profile->last_name = $this->last_name;
        $profile->email = $this->email;
        $profile->phone = $this->phone;
        $profile->linkedin_url = $this->linkedin_url;
        $profile->github_url = $this->github_url;
        $profile->portfolio_url = $this->portfolio_url;
        $profile->target_roles = $this->target_roles;
        $profile->target_locations = $this->target_locations;
        $profile->remote_preference = $this->remote_preference;
        $profile->max_job_age_days = $this->max_job_age_days;

        if ($this->resume) {
            $path = $this->resume->store('resumes', 'public');
            $profile->resume_path = $path;

            // Extract text for AI Matcher
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile(storage_path('app/public/' . $path));
                $text = $pdf->getText();
                $profile->resume_text = $text;
            } catch (\Exception $e) {
                // Ignore parsing errors for now
            }
        }

        $profile->save();
        $this->saved = true;
    }

    public function authenticatePlatform($platform)
    {
        $userId = auth()->id();
        $sessionDir = storage_path("app/bot-sessions/{$userId}/" . strtolower($platform));
        
        $scriptPath = base_path('bot/authenticate.js');
        $inputData = json_encode([
            'platform' => strtoupper($platform),
            'session_dir' => $sessionDir
        ]);

        // We run this process asynchronously or just wait for it.
        // For a seamless UI, we might dispatch a job, but since it requires a visible browser 
        // on the user's local machine, running it synchronously (with a long timeout) 
        // or starting it in the background is needed.
        
        // Let's run it in the background so the UI doesn't freeze.
        // On Windows, we can use `start` or just run it via symfony process in background.
        $process = new \Symfony\Component\Process\Process(['node', $scriptPath, $inputData]);
        $process->setTimeout(300); // 5 minutes
        
        try {
            // Note: Since this is web-requested, running a GUI app from PHP might fail depending on the OS service context.
            // But for `php artisan serve` on local Windows, it usually works.
            $process->start();
            session()->flash('message', "Launched browser for {$platform} authentication. Please switch to the new browser window and log in.");
        } catch (\Exception $e) {
            session()->flash('error', "Failed to launch authentication window: " . $e->getMessage());
        }
    }

    public function generateApiToken()
    {
        $user = auth()->user();
        
        // Revoke older tokens with the same name if needed
        $user->tokens()->where('name', 'chrome-extension')->delete();
        
        $token = $user->createToken('chrome-extension')->plainTextToken;
        $this->api_token = $token;
        
        session()->flash('token_message', 'New API Token generated successfully. Please copy it now, it will not be shown again.');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
