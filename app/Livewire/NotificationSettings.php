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

    public $channel_in_app;
    public $channel_slack;
    public $slack_webhook_url;

    public $saved = false;

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

        $this->channel_in_app = $prefs->channel_in_app;
        $this->channel_slack = $prefs->channel_slack;
        $this->slack_webhook_url = $prefs->slack_webhook_url;
    }

    public function save()
    {
        $this->validate([
            'slack_webhook_url' => 'nullable|url',
        ]);

        $prefs = NotificationPreference::where('user_id', auth()->id())->first();
        
        $prefs->update([
            'notify_on_submitted' => $this->notify_on_submitted,
            'notify_on_external' => $this->notify_on_external,
            'notify_on_company_website' => $this->notify_on_company_website,
            'notify_on_failed' => $this->notify_on_failed,
            'notify_on_manual_required' => $this->notify_on_manual_required,
            'notify_on_duplicate' => $this->notify_on_duplicate,
            'channel_in_app' => $this->channel_in_app,
            'channel_slack' => $this->channel_slack,
            'slack_webhook_url' => $this->slack_webhook_url,
        ]);

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.notification-settings');
    }
}
