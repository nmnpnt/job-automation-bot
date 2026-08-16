<?php

namespace App\Contracts;

use App\Enums\ApplicationSource;
use App\Models\Application;

interface ApplicationProviderInterface
{
    /**
     * Get the source type for this provider.
     */
    public function getSource(): ApplicationSource;

    /**
     * Determine if this provider supports the given URL.
     */
    public function supports(string $url): bool;

    /**
     * Execute the application submission process.
     */
    public function apply(Application $application): bool;
}
