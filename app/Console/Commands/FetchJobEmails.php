<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Models\Application;
use App\Models\User;
use App\Services\EmailParserService;
use Webklex\IMAP\Facades\Client;

#[Signature('jobs:fetch-emails')]
#[Description('Fetch emails via IMAP and update job application statuses')]
class FetchJobEmails extends Command
{
    public function handle(EmailParserService $parser)
    {
        $this->info('Connecting to IMAP server...');
        
        try {
            $client = Client::account('default');
            $client->connect();
            
            // Get the INBOX folder
            $folder = $client->getFolder('INBOX');
            
            // Get all unread messages
            $messages = $folder->query()->unseen()->get();
            
            $this->info("Found {$messages->count()} new messages.");
            
            foreach ($messages as $message) {
                $subject = $message->getSubject();
                $body = $message->getTextBody() ?? $message->getHTMLBody();
                
                // Parse the status
                $status = $parser->parseStatus($subject, $body);
                
                // For a real implementation, we would try to match the email back to an Application.
                // We could do this by matching company domains from the sender, or looking for specific confirmation IDs.
                // For demonstration, let's just log it if we find a status, but we won't blindly update applications without a match.
                
                $this->info("Parsed status: {$status} from subject: {$subject}");
                
                // Mark message as read
                $message->setFlag('Seen');
            }
            
        } catch (\Exception $e) {
            $this->error('Failed to fetch emails: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
