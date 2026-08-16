<?php

namespace App\Services\Providers;

use App\Contracts\ApplicationProviderInterface;
use App\Enums\ApplicationSource;
use App\Models\Application;
use Illuminate\Support\Str;

class GreenhouseApplicationProvider implements ApplicationProviderInterface
{
    public function __construct(protected \App\Services\PuppeteerOrchestrator $orchestrator) {}

    public function getSource(): ApplicationSource
    {
        return ApplicationSource::GREENHOUSE;
    }

    public function supports(string $url): bool
    {
        return Str::contains($url, ['greenhouse.io', 'boards.greenhouse.io']);
    }

    public function apply(Application $application): bool
    {
        return $this->orchestrator->apply($application);
    }
}
