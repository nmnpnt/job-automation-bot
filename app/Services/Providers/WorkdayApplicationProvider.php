<?php

namespace App\Services\Providers;

use App\Contracts\ApplicationProviderInterface;
use App\Enums\ApplicationSource;
use App\Models\Application;
use Illuminate\Support\Str;

class WorkdayApplicationProvider implements ApplicationProviderInterface
{
    public function getSource(): ApplicationSource
    {
        return ApplicationSource::WORKDAY;
    }

    public function supports(string $url): bool
    {
        return Str::contains($url, 'myworkdayjobs.com');
    }

    public function apply(Application $application): bool
    {
        sleep(1);
        return true;
    }
}
