<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', \App\Livewire\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('jobs', \App\Livewire\JobsList::class)
    ->middleware(['auth', 'verified'])
    ->name('jobs.index');

Route::get('/jobs/{jobId}', \App\Livewire\JobDetails::class)
    ->middleware(['auth', 'verified'])
    ->name('jobs.show');

Route::get('interviews', \App\Livewire\InterviewsList::class)
    ->middleware(['auth', 'verified'])
    ->name('interviews.index');

Route::get('queue-monitor', \App\Livewire\QueueMonitor::class)
    ->middleware(['auth', 'verified'])
    ->name('queue-monitor');

Route::get('architecture', \App\Livewire\Architecture::class)
    ->middleware(['auth', 'verified'])
    ->name('architecture');

Route::get('developer-docs', \App\Livewire\DeveloperDocs::class)
    ->middleware(['auth', 'verified'])
    ->name('developer-docs');

Route::get('automations', \App\Livewire\AutomationsHub::class)
    ->middleware(['auth', 'verified'])
    ->name('automations');

Route::get('activity', \App\Livewire\LiveActivityFeed::class)
    ->middleware(['auth', 'verified'])
    ->name('activity');

Route::get('settings', \App\Livewire\NotificationSettings::class)
    ->middleware(['auth', 'verified'])
    ->name('settings');

Route::post('/notifications/mark-all-read', function (Illuminate\Http\Request $request) {
    $request->user()->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
})->middleware(['auth'])->name('notifications.markAllRead');

Route::get('logs', \App\Livewire\LogViewer::class)
    ->middleware(['auth', 'verified'])
    ->name('logs');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/resume', function () {
    $profile = \App\Models\Profile::where('user_id', auth()->id())->first();
    if (!$profile || !$profile->resume_path) {
        abort(404, 'Resume not found.');
    }
    return response()->file(storage_path('app/public/' . $profile->resume_path));
})->middleware(['auth'])->name('resume.view');

require __DIR__.'/auth.php';
