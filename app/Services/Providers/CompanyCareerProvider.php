<?php

namespace App\Services\Providers;

use App\Contracts\ApplicationProviderInterface;
use App\Enums\ApplicationSource;
use App\Models\Application;
use Illuminate\Support\Str;

class CompanyCareerProvider implements ApplicationProviderInterface
{
    public function getSource(): ApplicationSource
    {
        return ApplicationSource::COMPANY_WEBSITE;
    }

    public function supports(string $url): bool
    {
        return Str::contains($url, ['/careers', '/jobs']);
    }

    public function apply(Application $application): bool
    {
        // Company sites usually need manual action
        return false;
    }
}
