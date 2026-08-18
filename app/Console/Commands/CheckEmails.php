<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Models\Application;
use App\Services\EmailParserService;
use Illuminate\Support\Str;
use App\Events\ActivityLogged;

class CheckEmails extends Command
{
    protected $signature = 'app:check-emails';
    protected $description = 'Check IMAP inbox for application updates';

    public function handle(EmailParserService $parser)
    {
        $this->info('Connecting to IMAP...');
        
        try {
            // Using a default client defined in config/imap.php
            // $client = Client::account('default');
            // $client->connect();
            // $folder = $client->getFolder('INBOX');
            // $messages = $folder->query()->unseen()->get();

            // Mocking the IMAP response for this MVP since we don't have real credentials
            $messages = [
                (object) [
                    'getSubject' => 'Update on your application at Tech Corp 42',
                    'getTextBody' => 'We unfortunately decided to move forward with other candidates.',
                    'getFrom' => [['mail' => 'recruiting@techcorp42.com']]
                ],
                (object) [
                    'getSubject' => 'Interview Request - Software Engineer',
                    'getTextBody' => 'We would love to schedule a time to chat next week!',
                    'getFrom' => [['mail' => 'hr@techcorp99.com']]
                ]
            ];

            foreach ($messages as $message) {
                $subject = $message->getSubject();
                $body = $message->getTextBody();
                
                $status = $parser->determineStatus($subject, $body);

                if ($status) {
                    // Try to match the company name from the subject or email
                    // In a real scenario we'd do a better fuzzy match or parse email domain
                    $applications = Application::all();
                    
                    foreach ($applications as $app) {
                        if (Str::contains(strtolower($subject . ' ' . $body), strtolower($app->company_name))) {
                            // Update application
                            $app->update(['status' => $status->value]);
                            
                            $msg = match($status->value) {
                                'INTERVIEW_REQUESTED' => 'Interview requested via email!',
                                'REJECTED' => 'Application rejected via email.',
                                'OFFER_RECEIVED' => 'Offer received via email!',
                                default => 'Status updated from email.'
                            };
                            
                            // If interview requested, extract more details and generate prep
                            if ($status->value === 'INTERVIEW_REQUESTED') {
                                $details = $parser->extractInterviewDetails($body);
                                if ($details) {
                                    $app->update([
                                        'interview_date' => $details['interview_date'] ?? null,
                                        'interview_link' => $details['interview_link'] ?? null,
                                    ]);
                                }

                                // Auto-trigger mock interview prep
                                try {
                                    $prepService = app(\App\Services\GeminiMockInterviewService::class);
                                    $prepNotes = $prepService->generatePrep($app->user, $app);
                                    $app->update(['interview_prep_notes' => $prepNotes]);
                                } catch (\Exception $e) {
                                    $this->warn("Failed to auto-generate interview prep: " . $e->getMessage());
                                }
                            }
                            
                            // Log event
                            $app->events()->create([
                                'event_type' => $status->value,
                                'message' => $msg,
                            ]);
                            
                            event(new ActivityLogged($app, $status->value, $msg));
                            
                            if (in_array($status->value, ['INTERVIEW_REQUESTED', 'OFFER_RECEIVED'])) {
                                $app->user->sendSlackNotification(
                                    $msg . " - " . $app->company_name,
                                    'success',
                                    'notify_on_interview'
                                );
                            } elseif ($status->value === 'REJECTED') {
                                $app->user->sendSlackNotification(
                                    $msg . " - " . $app->company_name,
                                    'error'
                                );
                            }
                            
                            $this->info("Updated {$app->company_name} to {$status->value}");
                            break; // Stop after finding the match
                        }
                    }
                }
            }

            $this->info('Finished checking emails.');

        } catch (\Exception $e) {
            $this->error('IMAP Error: ' . $e->getMessage());
        }
    }
}
