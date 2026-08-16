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
    public $target_locations;
    public $remote_only = false;
    
    public $saved = false;

    public function mount()
    {
        $profile = Profile::where('user_id', auth()->id())->first();
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
            $this->remote_only = (bool)$profile->remote_only;
        }
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'portfolio_url' => 'nullable|url',
            'resume' => 'nullable|mimes:pdf|max:5120',
            'target_roles' => 'nullable|string|max:255',
            'target_locations' => 'nullable|string|max:255',
            'remote_only' => 'boolean',
        ]);

        $profile = Profile::firstOrNew(['user_id' => auth()->id()]);
        
        $profile->first_name = $this->first_name;
        $profile->last_name = $this->last_name;
        $profile->email = $this->email;
        $profile->phone = $this->phone;
        $profile->linkedin_url = $this->linkedin_url;
        $profile->github_url = $this->github_url;
        $profile->portfolio_url = $this->portfolio_url;
        $profile->target_roles = $this->target_roles;
        $profile->target_locations = $this->target_locations;
        $profile->remote_only = $this->remote_only;

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

    public function render()
    {
        return view('livewire.user-profile');
    }
}
