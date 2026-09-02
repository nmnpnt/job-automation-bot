<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jobs Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .apply-btn {
            display: inline-block;
            padding: 4px 8px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Job Opportunities</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Company</th>
                <th>Portal</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->job_title }}</td>
                    <td>{{ $job->company_name }}</td>
                    <td>{{ $job->application_source->value ?? 'UNKNOWN' }}</td>
                    <td>{{ $job->status->value ?? 'UNKNOWN' }}</td>
                    <td>
                        @if($job->original_job_url)
                            <a href="{{ $job->original_job_url }}" class="apply-btn">Apply Here</a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
