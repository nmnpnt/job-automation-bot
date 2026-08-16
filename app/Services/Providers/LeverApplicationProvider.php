<?php

namespace App\Services\Providers;

use App\Contracts\ApplicationProviderInterface;
use App\Enums\ApplicationSource;
use App\Models\Application;
use Illuminate\Support\Str;

class LeverApplicationProvider implements ApplicationProviderInterface
{
    public function __construct(protected \App\Services\PuppeteerOrchestrator $orchestrator) {}

    public function getSource(): ApplicationSource
    {
        return ApplicationSource::LEVER;
    }

    public function supports(string $url): bool
    {
        return Str::contains($url, ['lever.co', 'jobs.lever.co']);
    }

    public function apply(Application $application): bool
    {
        return $this->orchestrator->apply($application);
    }
}
