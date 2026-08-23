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
    public $target_platforms = [];
    
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
            $this->target_platforms = is_array($profile->target_platforms) && count($profile->target_platforms) > 0 
                ? $profile->target_platforms 
                : ['LINKEDIN', 'INDEED', 'NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT'];
        } else {
            $this->target_platforms = ['LINKEDIN', 'INDEED', 'NAUKRI', 'UPLERS', 'UNSTOP', 'HIRIST', 'CUTSHORT'];
        }
    }

    public function save()
    {
        if ($this->max_job_age_days === '') {
            $this->max_job_age_days = null;
        }

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
            'max_job_age_days' => 'nullable|integer|min:1|max:30',
            'target_platforms' => 'array',
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
        $profile->max_job_age_days = $this->max_job_age_days === '' ? null : $this->max_job_age_days;
        $profile->target_platforms = $this->target_platforms;

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

    public $platform_cookies = [];

    public function savePlatformCookies($platform)
    {
        $this->validate([
            "platform_cookies.{$platform}" => 'required|string'
        ]);

        $cookieJsonString = $this->platform_cookies[$platform];
        
        // Ensure it's valid JSON
        $decoded = json_decode($cookieJsonString, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            session()->flash("cookie_error_{$platform}", 'Invalid JSON format. Please paste the exact JSON array exported from EditThisCookie.');
            return;
        }

        $userId = auth()->id();
        $sessionDir = storage_path("app/bot-sessions/{$userId}/" . strtolower($platform));
        if (!file_exists($sessionDir)) {
            mkdir($sessionDir, 0755, true);
        }
        
        // Save the cookies locally so Node can read them
        $cookieFile = $sessionDir . '/cookies.json';
        file_put_contents($cookieFile, $cookieJsonString);
        
        $scriptPath = base_path('bot/authenticate.py');
        $pythonPath = base_path('bot/venv/Scripts/python.exe');
        
        $inputFile = $sessionDir . '/input.json';
        file_put_contents($inputFile, json_encode([
            'platform' => strtoupper($platform),
            'session_dir' => $sessionDir,
            'cookie_file' => $cookieFile,
            'is_docker' => file_exists('/.dockerenv')
        ]));

        $env = array_merge($_SERVER, $_ENV);
        $env['SYSTEMROOT'] = $env['SYSTEMROOT'] ?? 'C:\\WINDOWS';
        $env['SYSTEMDRIVE'] = $env['SYSTEMDRIVE'] ?? 'C:';
        $env['USERPROFILE'] = $env['USERPROFILE'] ?? getenv('USERPROFILE') ?: 'C:\\Users\\Naman';
        $env['LOCALAPPDATA'] = $env['LOCALAPPDATA'] ?? getenv('LOCALAPPDATA') ?: 'C:\\Users\\Naman\\AppData\\Local';

        // Run synchronously to confirm cookie works
        $process = new \Symfony\Component\Process\Process([$pythonPath, $scriptPath, $inputFile], null, $env);
        $process->setTimeout(60); 
        
        try {
            $process->run();
            
            // Combine both stdout and stderr to parse the output
            $outputStr = $process->getOutput() . "\n" . $process->getErrorOutput();
            file_put_contents($sessionDir . '/debug_output.txt', $outputStr);
            $lines = array_filter(explode("\n", trim($outputStr)));
            
            $finalOutput = null;
            // Get the last valid JSON object from the output
            foreach (array_reverse($lines) as $line) {
                $parsed = json_decode($line, true);
                if (is_array($parsed) && isset($parsed['status'])) {
                    $finalOutput = $parsed;
                    break;
                }
            }
            
            if ($finalOutput && $finalOutput['status'] === 'success') {
                session()->flash("cookie_message_{$platform}", "{$platform} session saved and verified successfully!");
                $this->platform_cookies[$platform] = ''; // clear it
            } else {
                // if (file_exists($cookieFile)) {
                //     unlink($cookieFile);
                // }
                session()->flash("cookie_error_{$platform}", $finalOutput['message'] ?? 'Failed to verify cookie.');
            }
        } catch (\Exception $e) {
            // if (file_exists($cookieFile)) {
            //     unlink($cookieFile);
            // }
            session()->flash("cookie_error_{$platform}", 'Cookie verification failed: ' . $e->getMessage());
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
