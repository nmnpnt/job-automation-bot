<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NotificationPreference;

class NotificationSettings extends Component
{
    public $preference;

    protected $rules = [
        'preference.notify_on_submitted' => 'boolean',
        'preference.notify_on_external' => 'boolean',
        'preference.notify_on_company_website' => 'boolean',
        'preference.notify_on_failed' => 'boolean',
        'preference.notify_on_manual_required' => 'boolean',
        'preference.notify_on_duplicate' => 'boolean',
        'preference.daily_summary' => 'boolean',
        'preference.channel_in_app' => 'boolean',
        'preference.channel_email' => 'boolean',
    ];

    public function mount()
    {
        // Get or create for current user (assuming user ID 1 for now, or auth()->id() if logged in)
        $userId = auth()->id() ?? 1;
        
        $this->preference = NotificationPreference::firstOrCreate(
            ['user_id' => $userId],
            [
                'notify_on_submitted' => true,
                'notify_on_external' => true,
                'notify_on_company_website' => true,
                'notify_on_failed' => true,
                'notify_on_manual_required' => true,
                'notify_on_duplicate' => false,
                'daily_summary' => true,
                'channel_in_app' => true,
                'channel_email' => true,
            ]
        );
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->preference->save();
        
        session()->flash('message', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.notification-settings');
    }
}
