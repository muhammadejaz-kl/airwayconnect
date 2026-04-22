<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  @page { size: A4; margin: 16mm 0; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DejaVu Sans', sans-serif; font-size: 9.5pt; color: #1a1a1a; line-height: 1.5; margin: 0 22mm; }

  .header { padding-bottom: 10px; }
  .name { font-size: 18pt; font-weight: bold; color: #111; }
  .exp-level { font-size: 10pt; color: #1f9be1; font-weight: bold; margin-top: 3px; }
  .contact-line { font-size: 7.5pt; color: #555; margin-top: 5px; }
  .contact-line .sep { margin: 0 5px; color: #1f9be1; }

  .section { margin-bottom: 10px; }
  .section-title { font-size: 11pt; font-weight: bold; color: #111; border-bottom: 3px solid #111;
                   padding-bottom: 3px; margin-bottom: 6px; text-transform: uppercase; }
  .text-body { font-size: 8.5pt; color: #333; }

  .work-title    { font-size: 10pt; font-weight: bold; color: #111; margin-top: 6px; }
  .work-employer { font-size: 8.5pt; color: #1f9be1; font-weight: bold; }
  .work-meta     { font-size: 8pt; color: #666; }
  .work-desc     { font-size: 8.5pt; color: #333; margin-top: 2px; }

  .edu-degree { font-size: 10pt; font-weight: bold; color: #111; margin-top: 6px; }
  .edu-school { font-size: 8.5pt; color: #555; }
  .edu-certs  { font-size: 8pt; color: #666; margin-top: 1px; }
</style>
</head>
<body>

  <div class="header">
    <div class="name">{{ ($contact->first_name ?? '') . ' ' . ($contact->surname ?? '') }}</div>
    @if(!empty($contact->experience_level))
      <div class="exp-level">{{ $contact->experience_level }}</div>
    @endif
    <div class="contact-line">
      {{ $contact->email ?? '' }}<span class="sep">@</span>
      {{ $contact->phone ?? '' }}<span class="sep">@</span>
      {{ $contact->date_of_birth ?? '' }}<span class="sep">@</span>
      {{ $contact->nationality ?? '' }}
      @if(!empty($contact->license_no))<span class="sep">@</span>{{ $contact->license_no }}@endif
      @if(!empty($contact->language))<span class="sep">@</span>{{ $contact->language }}@endif
      @if(!empty($contact->marital_status))<span class="sep">@</span>{{ $contact->marital_status }}@endif
      @if(!empty($contact->residential_address))<span class="sep">@</span>{{ $contact->residential_address }}@endif
    </div>
  </div>

  @if($summary)
  <div class="section">
    <div class="section-title">Summary</div>
    <p class="text-body">{{ $summary->summary }}</p>
  </div>
  @endif

  @if($skills->count())
  <div class="section">
    <div class="section-title">Skills</div>
    <p class="text-body">{{ $skills->implode(', ') }}</p>
  </div>
  @endif

  @if($works->count())
  <div class="section">
    <div class="section-title">Experience</div>
    @foreach($works as $work)
      <div class="work-title">{{ $work->job_title }}</div>
      <div class="work-employer">{{ $work->employer }}</div>
      <div class="work-meta">
        {{ $work->start_date }} &ndash; {{ $work->currently_work ? 'Present' : $work->end_date }}
        &nbsp;|&nbsp; {{ $work->location }}
        &nbsp;|&nbsp; {{ $work->remote == 1 ? 'Remote' : 'Full Time' }}
      </div>
      @if(!empty($work->experienced_with))
        <div class="work-desc"><strong>Job Description:</strong> {{ $work->experienced_with }}</div>
      @endif
    @endforeach
  </div>
  @endif

  @if($educations->count())
  <div class="section">
    <div class="section-title">Education</div>
    @foreach($educations as $edu)
      <div class="edu-degree">
        {{ $edu->degree }}@if(!empty($edu->field_of_study)) in {{ $edu->field_of_study }}@endif
      </div>
      <div class="edu-school">
        {{ $edu->school_name }}@if(!empty($edu->school_location)), {{ $edu->school_location }}@endif
        &nbsp;|&nbsp; {{ $edu->graduation_month }} {{ $edu->graduation_year }}
      </div>
      @if(!empty($edu->certificates))
        <div class="edu-certs">{{ $edu->certificates }}</div>
      @endif
    @endforeach
  </div>
  @endif

</body>
</html>
