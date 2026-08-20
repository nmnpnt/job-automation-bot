<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $resume->title }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11pt; color: #333; line-height: 1.5; margin: 20px; }
        h1 { font-size: 24pt; margin-bottom: 5px; color: #111; border-bottom: 2px solid #333; padding-bottom: 5px; }
        h2 { font-size: 14pt; margin-top: 20px; margin-bottom: 10px; color: #222; text-transform: uppercase; border-bottom: 1px solid #ccc; }
        .contact-info { font-size: 10pt; color: #555; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .section-title { font-weight: bold; margin-bottom: 5px; }
        .section-content { margin-bottom: 10px; }
        p { margin: 0 0 10px 0; }
    </style>
</head>
<body>
    <h1>{{ auth()->user()->profile->first_name ?? auth()->user()->name }} {{ auth()->user()->profile->last_name ?? '' }}</h1>
    
    <div class="contact-info">
        @if(auth()->user()->profile)
            {{ auth()->user()->profile->email ?? auth()->user()->email }} 
            @if(auth()->user()->profile->phone) | {{ auth()->user()->profile->phone }} @endif
            @if(auth()->user()->profile->linkedin_url) | {{ auth()->user()->profile->linkedin_url }} @endif
        @else
            {{ auth()->user()->email }}
        @endif
    </div>

    @foreach($sections as $section)
        <div class="section">
            <h2>{{ $section->title }}</h2>
            <div class="section-content">
                @if(in_array($section->type, ['SUMMARY', 'CUSTOM']) && isset($section->content['text']))
                    {!! nl2br(e($section->content['text'])) !!}
                @elseif(in_array($section->type, ['EXPERIENCE', 'PROJECTS']) && isset($section->content['company']))
                    <div style="margin-bottom: 5px;">
                        <strong>{{ $section->content['role'] ?? '' }}</strong> at <strong>{{ $section->content['company'] }}</strong>
                    </div>
                    <div style="font-size: 9pt; color: #555; margin-bottom: 10px;">
                        {{ $section->content['start_date'] ?? '' }} - {{ $section->content['end_date'] ?? '' }}
                    </div>
                    <div>{!! nl2br(e($section->content['description'] ?? '')) !!}</div>
                @elseif($section->type === 'EDUCATION' && isset($section->content['institution']))
                    <div style="margin-bottom: 5px;">
                        <strong>{{ $section->content['degree'] ?? '' }}</strong>
                    </div>
                    <div>{{ $section->content['institution'] }}</div>
                    <div style="font-size: 9pt; color: #555; margin-bottom: 10px;">
                        {{ $section->content['start_date'] ?? '' }} - {{ $section->content['end_date'] ?? '' }}
                    </div>
                    <div>{!! nl2br(e($section->content['description'] ?? '')) !!}</div>
                @elseif($section->type === 'SKILLS' && isset($section->content['skills']))
                    <p>{{ $section->content['skills'] }}</p>
                @elseif($section->type === 'CERTIFICATIONS' && isset($section->content['name']))
                    <div style="margin-bottom: 5px;"><strong>{{ $section->content['name'] }}</strong></div>
                    <div>{{ $section->content['issuer'] ?? '' }}</div>
                    <div style="font-size: 9pt; color: #555;">{{ $section->content['date'] ?? '' }}</div>
                @else
                    {{ json_encode($section->content) }}
                @endif
            </div>
        </div>
    @endforeach
</body>
</html>
