<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Enums\ApplicationSource;
use App\Enums\ApplicationStatus;
use Illuminate\Support\Str;

class ExtensionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string',
            'title' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'url' => 'required|url',
        ]);

        // Determine Source based on Platform
        $sourceMap = [
            'LINKEDIN' => ApplicationSource::LINKEDIN,
            'NAUKRI' => ApplicationSource::NAUKRI,
            'UPLERS' => ApplicationSource::UPLERS,
            'UNSTOP' => ApplicationSource::UNSTOP,
            'HIRIST' => ApplicationSource::HIRIST,
            'CUTSHORT' => ApplicationSource::CUTSHORT,
        ];

        $source = $sourceMap[$validated['platform']] ?? ApplicationSource::EXTERNAL_WEBSITE;

        // Clean URL to prevent duplicates (already done slightly in JS, but re-checking)
        $cleanUrl = explode('?', $validated['url'])[0];

        // Check if job already exists
        $application = Application::firstOrCreate(
            ['original_job_url' => $cleanUrl],
            [
                'job_title' => $validated['title'],
                'company_name' => $validated['company'],
                'location' => $validated['location'],
                'application_source' => $source,
                'external_domain' => parse_url($cleanUrl, PHP_URL_HOST),
                'status' => ApplicationStatus::DISCOVERED,
                'can_auto_apply' => true, // Assuming extension can handle it
                'user_id' => $request->user()->id,
            ]
        );

        if ($application->wasRecentlyCreated) {
            // Log event
            $application->events()->create([
                'status' => ApplicationStatus::DISCOVERED,
                'message' => 'Job discovered via Chrome Extension while browsing.',
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Job successfully synced!',
                'data' => $application
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Job already exists in database.',
        ]);
    }
}
