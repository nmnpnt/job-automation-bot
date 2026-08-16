<?php

namespace App\Listeners;

use Illuminate\Events\Dispatcher;
use App\Services\NotificationEngine;
use App\Events\ApplicationSubmitted;
use App\Events\ExternalApplicationDetected;
use App\Events\CompanyWebsiteDetected;
use App\Events\ApplicationFailed;
use App\Events\ManualActionRequired;
use App\Events\DuplicateApplicationDetected;

class ApplicationEventSubscriber
{
    public function __construct(
        protected NotificationEngine $notificationEngine
    ) {}

    public function handleApplicationSubmitted(ApplicationSubmitted $event): void
    {
        $this->notificationEngine->send($event->application, 'ApplicationSubmitted', 'App\Notifications\ApplicationSubmittedNotification');
    }

    public function handleExternalApplicationDetected(ExternalApplicationDetected $event): void
    {
        $this->notificationEngine->send($event->application, 'ExternalApplicationDetected', 'App\Notifications\ExternalApplicationNotification');
    }

    public function handleCompanyWebsiteDetected(CompanyWebsiteDetected $event): void
    {
        $this->notificationEngine->send($event->application, 'CompanyWebsiteDetected', 'App\Notifications\CompanyWebsiteNotification');
    }

    public function handleApplicationFailed(ApplicationFailed $event): void
    {
        $this->notificationEngine->send($event->application, 'ApplicationFailed', 'App\Notifications\ApplicationFailedNotification');
    }

    public function handleManualActionRequired(ManualActionRequired $event): void
    {
        $this->notificationEngine->send($event->application, 'ManualActionRequired', 'App\Notifications\ManualActionNotification');
    }

    public function handleDuplicateApplicationDetected(DuplicateApplicationDetected $event): void
    {
        $this->notificationEngine->send($event->application, 'DuplicateApplicationDetected', 'App\Notifications\DuplicateApplicationNotification');
    }

    public function subscribe(Dispatcher $events): array
    {
        return [
            ApplicationSubmitted::class => 'handleApplicationSubmitted',
            ExternalApplicationDetected::class => 'handleExternalApplicationDetected',
            CompanyWebsiteDetected::class => 'handleCompanyWebsiteDetected',
            ApplicationFailed::class => 'handleApplicationFailed',
            ManualActionRequired::class => 'handleManualActionRequired',
            DuplicateApplicationDetected::class => 'handleDuplicateApplicationDetected',
        ];
    }
}
