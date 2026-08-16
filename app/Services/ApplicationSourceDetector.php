<?php

namespace App\Services;

use App\Contracts\ApplicationProviderInterface;
use App\Enums\ApplicationSource;
use Illuminate\Support\Str;

class ApplicationSourceDetector
{
    /** @var ApplicationProviderInterface[] */
    protected array $providers = [];

    public function __construct()
    {
        // We will inject providers here later, or load from config
        $this->providers = [
            app(Providers\GreenhouseApplicationProvider::class),
            app(Providers\LeverApplicationProvider::class),
            app(Providers\WorkdayApplicationProvider::class),
            app(Providers\CompanyCareerProvider::class), // Catch-all for known company career sites
        ];
    }

    public function detect(string $url): ApplicationSource
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($url)) {
                return $provider->getSource();
            }
        }
        
        // If it's an external URL but not a known ATS, it's external
        return ApplicationSource::EXTERNAL_JOB_BOARD;
    }

    public function getProvider(string $url): ?ApplicationProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($url)) {
                return $provider;
            }
        }

        return null;
    }
}
