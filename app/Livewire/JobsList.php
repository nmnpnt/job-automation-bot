<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Application;
use App\Enums\ApplicationSource;
use App\Exports\JobsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class JobsList extends Component
{
    use WithPagination;

    public $filterSource = '';
    public $filterStatus = '';
    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';



    public function updatingFilterSource()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleSaveJob($jobId)
    {
        $job = Application::where('user_id', auth()->id())->find($jobId);
        if ($job) {
            $job->is_saved = !$job->is_saved;
            $job->save();
        }
    }

    private function getFilteredQuery()
    {
        $userId = auth()->id();
        $query = Application::where('user_id', $userId);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('job_title', 'like', '%' . $this->search . '%')
                  ->orWhere('company_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterSource) {
            $query->where('application_source', $this->filterSource);
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $query->orderBy($this->sortField, $this->sortDirection);
        return $query;
    }

    public function exportCSV()
    {
        $jobs = $this->getFilteredQuery()->get();

        $csvHeader = ['Job Title', 'Company', 'Portal', 'Status', 'Applied At', 'URL'];
        
        $callback = function() use ($jobs, $csvHeader) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);

            foreach ($jobs as $job) {
                fputcsv($file, [
                    $job->job_title,
                    $job->company_name,
                    $job->application_source->value ?? 'UNKNOWN',
                    $job->status->value ?? 'UNKNOWN',
                    $job->submitted_at ? $job->submitted_at->format('Y-m-d H:i:s') : 'N/A',
                    $job->original_job_url
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'jobs_export_' . date('Y-md_His') . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportExcel()
    {
        $jobs = $this->getFilteredQuery()->get();
        return Excel::download(new JobsExport($jobs), 'jobs_export_' . date('Y-md_His') . '.xlsx');
    }

    public function exportPDF()
    {
        $jobs = $this->getFilteredQuery()->get();
        $pdf = Pdf::loadView('pdf.jobs', ['jobs' => $jobs]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'jobs_export_' . date('Y-md_His') . '.pdf');
    }



    // Removed duplicate filterStatus and updatingFilterStatus

    #[On('echo:activity-feed,.ActivityLogged')]
    public function refreshList()
    {
        // This method will be called when the ActivityLogged event is broadcasted on the activity-feed channel.
        // It doesn't need to do anything; simply defining it with the #[On] attribute
        // will cause Livewire to re-render the component and fetch the latest data from the database.
    }

    public function render()
    {
        $userId = auth()->id();
        $jobs = $this->getFilteredQuery()->paginate(20);

        // Define the specific job portals requested by the user
        $curatedSources = [
            \App\Enums\ApplicationSource::LINKEDIN,
            \App\Enums\ApplicationSource::INDEED,
            \App\Enums\ApplicationSource::NAUKRI,
            \App\Enums\ApplicationSource::UPLERS,
            \App\Enums\ApplicationSource::UNSTOP,
            \App\Enums\ApplicationSource::HIRIST,
            \App\Enums\ApplicationSource::CUTSHORT,
        ];

        // Optional: you can fetch available statuses too
        $availableStatusValues = Application::where('user_id', $userId)
            ->whereNotNull('status')
            ->distinct()
            ->pluck('status')
            ->toArray();

        return view('livewire.jobs-list', [
            'jobs' => $jobs,
            'sources' => $curatedSources,
            'statuses' => $availableStatusValues
        ])->layout('layouts.app');
    }
}
