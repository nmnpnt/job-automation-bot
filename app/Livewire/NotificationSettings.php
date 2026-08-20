<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NotificationPreference;

class NotificationSettings extends Component
{
    public $notify_on_submitted;
    public $notify_on_external;
    public $notify_on_company_website;
    public $notify_on_failed;
    public $notify_on_manual_required;
    public $notify_on_duplicate;
    public $notify_on_interview;
    public $daily_summary;

    public $channel_in_app;
    public $channel_slack;
    public $slack_webhook_url;

    public $channel_whatsapp;
    public $whatsapp_phone_number;
    public $whatsapp_api_key;
    public $whatsapp_provider = 'callmebot';

    public $saved = false;
    public $testSlackStatus = null;
    public $testWhatsAppStatus = null;

    public function mount()
    {
        $prefs = NotificationPreference::firstOrCreate(
            ['user_id' => auth()->id()]
        );

        $this->notify_on_submitted = $prefs->notify_on_submitted;
        $this->notify_on_external = $prefs->notify_on_external;
        $this->notify_on_company_website = $prefs->notify_on_company_website;
        $this->notify_on_failed = $prefs->notify_on_failed;
        $this->notify_on_manual_required = $prefs->notify_on_manual_required;
        $this->notify_on_duplicate = $prefs->notify_on_duplicate;
        $this->notify_on_interview = $prefs->notify_on_interview ?? true;
        $this->daily_summary = $prefs->daily_summary;

        $this->channel_in_app = $prefs->channel_in_app;
        $this->channel_slack = $prefs->channel_slack;
        $this->slack_webhook_url = $prefs->slack_webhook_url;

        $this->channel_whatsapp = $prefs->channel_whatsapp;
        $this->whatsapp_phone_number = $prefs->whatsapp_phone_number;
        $this->whatsapp_api_key = $prefs->whatsapp_api_key;
        $this->whatsapp_provider = $prefs->whatsapp_provider ?? 'callmebot';
    }

    public function save()
    {
        $this->validate([
            'slack_webhook_url' => 'nullable|url',
            'whatsapp_phone_number' => 'nullable|string',
            'whatsapp_api_key' => 'nullable|string',
        ]);

        $prefs = NotificationPreference::where('user_id', auth()->id())->first();
        
        $prefs->update([
            'notify_on_submitted' => $this->notify_on_submitted,
            'notify_on_external' => $this->notify_on_external,
            'notify_on_company_website' => $this->notify_on_company_website,
            'notify_on_failed' => $this->notify_on_failed,
            'notify_on_manual_required' => $this->notify_on_manual_required,
            'notify_on_duplicate' => $this->notify_on_duplicate,
            'notify_on_interview' => $this->notify_on_interview,
            'daily_summary' => $this->daily_summary,
            'channel_in_app' => $this->channel_in_app,
            'channel_slack' => $this->channel_slack,
            'slack_webhook_url' => $this->slack_webhook_url,
            'channel_whatsapp' => $this->channel_whatsapp,
            'whatsapp_phone_number' => $this->whatsapp_phone_number,
            'whatsapp_api_key' => $this->whatsapp_api_key,
            'whatsapp_provider' => $this->whatsapp_provider,
        ]);

        $this->saved = true;
    }

    public function testSlack()
    {
        $this->testSlackStatus = null;
        if (!$this->slack_webhook_url) {
            $this->testSlackStatus = ['success' => false, 'message' => 'Please enter a Slack webhook URL first.'];
            return;
        }

        try {
            // Force enable the channel when testing so the test actually goes through
            $this->channel_slack = true;
            $this->save();
            
            auth()->user()->sendSlackNotification("🔔 *Test Notification* from your Job Automation Bot! Slack integration is working perfectly.");
            $this->testSlackStatus = ['success' => true, 'message' => 'Test message sent to Slack! Check your channel.'];
        } catch (\Throwable $e) {
            $this->testSlackStatus = ['success' => false, 'message' => 'Slack error: ' . $e->getMessage()];
        }
    }

    public function testWhatsApp()
    {
        $this->testWhatsAppStatus = null;
        if (!$this->whatsapp_phone_number || !$this->whatsapp_api_key) {
            $this->testWhatsAppStatus = ['success' => false, 'message' => 'Please enter your phone number and API key/Webhook.'];
            return;
        }

        try {
            // Force enable the channel when testing so the test actually goes through
            $this->channel_whatsapp = true;
            $this->save();
            $sent = app(\App\Services\WhatsAppService::class)->send(
                auth()->user(),
                "🔔 Test Notification from Job Automation Bot! WhatsApp alerts are active."
            );

            if ($sent) {
                $this->testWhatsAppStatus = ['success' => true, 'message' => 'Test message sent to WhatsApp!'];
            } else {
                $this->testWhatsAppStatus = ['success' => false, 'message' => 'Failed to send. Please check your phone number and API key.'];
            }
        } catch (\Throwable $e) {
            $this->testWhatsAppStatus = ['success' => false, 'message' => 'WhatsApp error: ' . $e->getMessage()];
        }
    }

    public function render()
    {
        return view('livewire.notification-settings');
    }
}
