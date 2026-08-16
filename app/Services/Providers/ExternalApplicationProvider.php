<?php

namespace App\Services\Providers;

use App\Contracts\ApplicationProviderInterface;
use App\Enums\ApplicationSource;
use App\Models\Application;

class ExternalApplicationProvider implements ApplicationProviderInterface
{
    public function getSource(): ApplicationSource
    {
        return ApplicationSource::EXTERNAL_JOB_BOARD;
    }

    public function supports(string $url): bool
    {
        return true; // Fallback
    }

    public function apply(Application $application): bool
    {
        return false;
    }
}
