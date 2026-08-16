<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume - {{ $profile->first_name }} {{ $profile->last_name }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        h1 {
            margin-bottom: 0;
            color: #2c3e50;
        }
        h2 {
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 5px;
            margin-top: 20px;
            color: #2c3e50;
        }
        p {
            margin-top: 5px;
        }
        .contact-info {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 20px;
        }
        .target-role {
            font-size: 1.2em;
            font-weight: bold;
            color: #2980b9;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .section-content {
            margin-top: 10px;
            white-space: pre-wrap; /* to preserve newlines in resume_text */
        }
    </style>
</head>
<body>

    <h1>{{ $profile->first_name }} {{ $profile->last_name }}</h1>
    
    <div class="contact-info">
        {{ $profile->email }} | {{ $profile->phone }} <br>
        @if($profile->linkedin_url) LinkedIn: {{ $profile->linkedin_url }} | @endif
        @if($profile->github_url) GitHub: {{ $profile->github_url }} @endif
    </div>

    <!-- Tailoring the resume to the target job -->
    <div class="target-role">
        Targeted Role: {{ $job->title }} at {{ $job->company_name }}
    </div>

    <h2>Professional Summary & Experience</h2>
    <div class="section-content">
        {{ $profile->resume_text ?? 'No resume details provided.' }}
    </div>

</body>
</html>
