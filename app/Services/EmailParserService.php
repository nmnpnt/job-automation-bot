<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
use Illuminate\Support\Str;

class EmailParserService
{
    /**
     * Evaluate the subject and body to determine if there's a status update.
     */
    public function determineStatus(string $subject, string $body): ?ApplicationStatus
    {
        $text = strtolower($subject . ' ' . $body);

        if (Str::contains($text, ['offer', 'extend an offer', 'pleased to offer'])) {
            return ApplicationStatus::OFFER_RECEIVED;
        }

        if (Str::contains($text, ['interview', 'chat', 'schedule a time', 'next steps'])) {
            // Be careful not to match "we will reach out if selected for an interview"
            if (!Str::contains($text, ['will reach out if', 'if selected'])) {
                return ApplicationStatus::INTERVIEW_REQUESTED;
            }
        }

        if (Str::contains($text, ['unfortunately', 'not moving forward', 'other candidates', 'not selected', 'decided to pursue'])) {
            return ApplicationStatus::REJECTED;
        }

        return null;
    }
}
