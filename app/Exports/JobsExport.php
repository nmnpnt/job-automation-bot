<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JobsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $jobs;

    public function __construct($jobs)
    {
        $this->jobs = $jobs;
    }

    public function collection()
    {
        return $this->jobs;
    }

    public function headings(): array
    {
        return [
            'Job Title',
            'Company',
            'Portal',
            'Status',
            'Applied At',
            'Apply Link',
        ];
    }

    public function map($job): array
    {
        // Use Excel's HYPERLINK formula to make the URL a clickable link
        $url = $job->original_job_url ?? '';
        $hyperlink = $url ? '=HYPERLINK("' . str_replace('"', '""', $url) . '", "Apply Here")' : 'N/A';

        return [
            $job->job_title,
            $job->company_name,
            $job->application_source->value ?? 'UNKNOWN',
            $job->status->value ?? 'UNKNOWN',
            $job->submitted_at ? $job->submitted_at->format('Y-m-d H:i:s') : 'N/A',
            $hyperlink,
        ];
    }
}
