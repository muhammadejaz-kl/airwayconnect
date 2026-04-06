<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  /* @page has NO left/right margins — body margin controls them instead.
     This is critical: in dompdf %, width is relative to the body width,
     NOT the @page content area. Setting margins here causes % overflow. */
  @page { size: A4; margin: 16mm 0; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 9pt;
    color: #1a1a1a;
    line-height: 1.5;
    margin: 0 22mm;   /* left/right margin on body → 100% children = 166mm */
  }

  /* ── HEADER ── */
  .header { text-align: center; padding-bottom: 8px; margin-bottom: 10px; border-bottom: 1.5px solid #555; }
  .name { font-size: 20pt; font-weight: bold; color: #111; }
  .exp-level { font-size: 9.5pt; color: #666; margin-top: 2px; }
  .contact-line { font-size: 7.5pt; color: #555; margin-top: 5px; }
  .contact-line .sep { margin: 0 4px; }

  /* ── SECTION ── */
  .section { margin-bottom: 10px; }
  .section-title {
    text-align: center; font-size: 11pt; font-weight: bold; color: #111;
    border-bottom: 1.5px solid #555; padding-bottom: 3px; margin-bottom: 8px;
  }
  .text-body { font-size: 8.5pt; color: #333; line-height: 1.6; }

  /* ── TWO-COLUMN float layout ──
     overflow:hidden on .entry clears floats without a clearfix div.
     Clearfix divs create phantom height in dompdf causing extra pages. */
  .entry { margin-bottom: 7px; overflow: hidden; }

  .col-l { float: left;  width: 63%; word-wrap: break-word; }
  .col-r { float: right; width: 34%; text-align: right; word-wrap: break-word; }

  /* ── EXPERIENCE ── */
  .emp-name  { font-size: 9pt;   color: #555; display: block; }
  .job-title { font-size: 9pt;   color: #111; font-weight: bold; display: block; }
  .loc-text  { font-size: 7.5pt; color: #555; display: block; }
  .date-text { font-size: 7.5pt; color: #555; display: block; }
  .exp-desc  { font-size: 8.5pt; color: #333; margin-top: 2px; margin-bottom: 6px; }

  /* ── EDUCATION ── */
  .best-match  { font-size: 8.5pt; color: #666; margin-bottom: 2px; }
  .school-name { font-size: 9pt;   color: #444; font-weight: bold; display: block; }
  .edu-degree  { font-size: 9pt;   color: #333; font-weight: bold; display: block; }
  .edu-certs   { font-size: 8pt;   color: #666; display: block; margin-top: 1px; }
</style>
</head>
<body>

  {{-- HEADER --}}
  <div class="header">
    <div class="name">{{ ($contact->first_name ?? '') . ' ' . ($contact->surname ?? '') }}</div>
    @if(!empty($contact->experience_level))
      <div class="exp-level">{{ $contact->experience_level }}</div>
    @endif
    <div class="contact-line">
      {{ $contact->email ?? '' }}<span class="sep">•</span>
      {{ $contact->linkedin ?? 'linkedin.com' }}<span class="sep">•</span>
      {{ $contact->residential_address ?? '' }}<span class="sep">•</span>
      {{ $contact->phone ?? '' }}<span class="sep">•</span>
      {{ $contact->date_of_birth ?? '' }}<span class="sep">•</span>
      {{ $contact->nationality ?? '' }}
      @if(!empty($contact->license_no))<span class="sep">•</span>{{ $contact->license_no }}@endif
      @if(!empty($contact->language))<span class="sep">•</span>{{ $contact->language }}@endif
      @if(!empty($contact->marital_status))<span class="sep">•</span>{{ $contact->marital_status }}@endif
    </div>
  </div>

  {{-- SUMMARY --}}
  @if($summary)
  <div class="section">
    <div class="section-title">Summary</div>
    <p class="text-body">{{ $summary->summary }}</p>
  </div>
  @endif

  {{-- SKILLS --}}
  @if($skills->count())
  <div class="section">
    <div class="section-title">Skills</div>
    <p class="text-body">{{ $skills->implode(', ') }}</p>
  </div>
  @endif

  {{-- EXPERIENCE --}}
  @if($works->count())
  <div class="section">
    <div class="section-title">Experience</div>
    @foreach($works as $work)
    <div class="entry">
      <div class="col-l">
        <span class="emp-name">{{ $work->employer }}</span>
        <span class="job-title">{{ $work->job_title }}</span>
      </div>
      <div class="col-r">
        <span class="loc-text">{{ $work->location }}</span>
        <span class="date-text">{{ $work->remote == 1 ? 'Remote' : 'Full Time' }}</span>
        <span class="date-text">{{ $work->start_date }} &ndash; {{ $work->currently_work ? 'Present' : $work->end_date }}</span>
      </div>
    </div>
    @if(!empty($work->experienced_with))
    <div class="exp-desc">{{ $work->experienced_with }}</div>
    @endif
    @endforeach
  </div>
  @endif

  {{-- EDUCATION --}}
  @if($educations->count())
  <div class="section">
    <div class="section-title">Education</div>
    @foreach($educations as $edu)
    @if(!empty($edu->best_match))
    <div class="best-match">{{ $edu->best_match }}</div>
    @endif
    <div class="entry">
      <div class="col-l">
        <span class="school-name">{{ $edu->school_name }}</span>
        <span class="edu-degree">{{ $edu->degree }}@if(!empty($edu->field_of_study)) in {{ $edu->field_of_study }}@endif</span>
        @if(!empty($edu->certificates))
        <span class="edu-certs">{{ $edu->certificates }}</span>
        @endif
      </div>
      <div class="col-r">
        @if(!empty($edu->school_location))
        <span class="loc-text">{{ $edu->school_location }}</span>
        @endif
        <span class="date-text">{{ $edu->graduation_month }} {{ $edu->graduation_year }}</span>
      </div>
    </div>
    @endforeach
  </div>
  @endif

</body>
</html>

  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DejaVu Sans', sans-serif; font-size: 9pt; color: #1a1a1a; line-height: 1.5; }

  /* ── HEADER ── */
  .header { text-align: center; padding-bottom: 8px; margin-bottom: 10px; border-bottom: 1.5px solid #555; }
  .name { font-size: 20pt; font-weight: bold; color: #111; }
  .exp-level { font-size: 9.5pt; color: #666; margin-top: 2px; }
  .contact-line { font-size: 7.5pt; color: #555; margin-top: 5px; }
  .contact-line .sep { margin: 0 4px; }

  /* ── SECTION ── */
  .section { margin-bottom: 10px; }
  .section-title {
    text-align: center; font-size: 11pt; font-weight: bold; color: #111;
    border-bottom: 1.5px solid #555; padding-bottom: 3px; margin-bottom: 8px;
  }
  .text-body { font-size: 8.5pt; color: #333; line-height: 1.6; }

  /* ── TWO-COLUMN ROW via floats ──
     dompdf reliably respects floats — avoids table cell overflow bug */
  .entry { margin-bottom: 7px; }
  .entry-clearfix { display: block; clear: both; height: 0; }

  /* left column: employer / school-name / job-title / degree */
  .col-l {
    float: left;
    width: 63%;
    word-wrap: break-word;
  }
  /* right column: location / date */
  .col-r {
    float: right;
    width: 35%;
    text-align: right;
    word-wrap: break-word;
  }

  /* ── EXPERIENCE ── */
  .emp-name  { font-size: 9pt;   color: #555; display: block; }
  .job-title { font-size: 9pt;   color: #111; font-weight: bold; display: block; }
  .loc-text  { font-size: 7.5pt; color: #555; display: block; }
  .date-text { font-size: 7.5pt; color: #555; display: block; }
  .exp-desc  { font-size: 8.5pt; color: #333; margin-top: 2px; margin-bottom: 6px; clear: both; }

  /* ── EDUCATION ── */
  .best-match  { font-size: 8.5pt; color: #666; margin-bottom: 1px; }
  .school-name { font-size: 9pt;   color: #444; font-weight: bold; display: block; }
  .edu-degree  { font-size: 9pt;   color: #333; font-weight: bold; display: block; }
  .edu-certs   { font-size: 8pt;   color: #666; display: block; margin-top: 1px; }
</style>
</head>
<body>

  {{-- HEADER --}}
  <div class="header">
    <div class="name">{{ ($contact->first_name ?? '') . ' ' . ($contact->surname ?? '') }}</div>
    @if(!empty($contact->experience_level))
      <div class="exp-level">{{ $contact->experience_level }}</div>
    @endif
    <div class="contact-line">
      {{ $contact->email ?? '' }}<span class="sep">•</span>
      {{ $contact->linkedin ?? 'linkedin.com' }}<span class="sep">•</span>
      {{ $contact->residential_address ?? '' }}<span class="sep">•</span>
      {{ $contact->phone ?? '' }}<span class="sep">•</span>
      {{ $contact->date_of_birth ?? '' }}<span class="sep">•</span>
      {{ $contact->nationality ?? '' }}
      @if(!empty($contact->license_no))<span class="sep">•</span>{{ $contact->license_no }}@endif
      @if(!empty($contact->language))<span class="sep">•</span>{{ $contact->language }}@endif
      @if(!empty($contact->marital_status))<span class="sep">•</span>{{ $contact->marital_status }}@endif
    </div>
  </div>

  {{-- SUMMARY --}}
  @if($summary)
  <div class="section">
    <div class="section-title">Summary</div>
    <p class="text-body">{{ $summary->summary }}</p>
  </div>
  @endif

  {{-- SKILLS --}}
  @if($skills->count())
  <div class="section">
    <div class="section-title">Skills</div>
    <p class="text-body">{{ $skills->implode(', ') }}</p>
  </div>
  @endif

  {{-- EXPERIENCE --}}
  @if($works->count())
  <div class="section">
    <div class="section-title">Experience</div>
    @foreach($works as $work)
    <div class="entry">
      {{-- Left: employer (light) then job title (bold) --}}
      <div class="col-l">
        <span class="emp-name">{{ $work->employer }}</span>
        <span class="job-title">{{ $work->job_title }}</span>
      </div>
      {{-- Right: location then type + date --}}
      <div class="col-r">
        <span class="loc-text">{{ $work->location }}</span>
        <span class="date-text">{{ $work->remote == 1 ? 'Remote' : 'Full Time' }}</span>
        <span class="date-text">{{ $work->start_date }} &ndash; {{ $work->currently_work ? 'Present' : $work->end_date }}</span>
      </div>
      <div class="entry-clearfix"></div>
    </div>
    @if(!empty($work->experienced_with))
    <div class="exp-desc">{{ $work->experienced_with }}</div>
    @endif
    @endforeach
  </div>
  @endif

  {{-- EDUCATION --}}
  @if($educations->count())
  <div class="section">
    <div class="section-title">Education</div>
    @foreach($educations as $edu)
    {{-- best_match row (full width) --}}
    @if(!empty($edu->best_match))
    <div class="best-match">{{ $edu->best_match }}</div>
    @endif
    <div class="entry">
      {{-- Left: school name (bold) then degree (bold) --}}
      <div class="col-l">
        <span class="school-name">{{ $edu->school_name }}</span>
        <span class="edu-degree">
          {{ $edu->degree }}@if(!empty($edu->field_of_study)) in {{ $edu->field_of_study }}@endif
        </span>
        @if(!empty($edu->certificates))
          <span class="edu-certs">{{ $edu->certificates }}</span>
        @endif
      </div>
      {{-- Right: location then graduation date --}}
      <div class="col-r">
        @if(!empty($edu->school_location))
          <span class="loc-text">{{ $edu->school_location }}</span>
        @endif
        <span class="date-text">{{ $edu->graduation_month }} {{ $edu->graduation_year }}</span>
      </div>
      <div class="entry-clearfix"></div>
    </div>
    @endforeach
  </div>
  @endif

</body>
</html>


  /* ── HEADER ── */
  .header { text-align: center; padding-bottom: 8px; margin-bottom: 10px; border-bottom: 1.5px solid #555; }
  .name { font-size: 20pt; font-weight: bold; color: #111; letter-spacing: 0.3px; }
  .exp-level { font-size: 9.5pt; color: #666; margin-top: 2px; }
  .contact-line { font-size: 7.5pt; color: #555; margin-top: 5px; }
  .contact-line .sep { margin: 0 4px; }

  /* ── SECTION ── */
  .section { margin-bottom: 10px; }
  .section-title {
    text-align: center;
    font-size: 11pt;
    font-weight: bold;
    color: #111;
    border-bottom: 1.5px solid #555;
    padding-bottom: 3px;
    margin-bottom: 8px;
  }
  .text-body { font-size: 8.5pt; color: #333; line-height: 1.6; }

  /* ── ENTRY TABLE (experience & education) ──
     table-layout:fixed ensures columns never exceed page width.
     overflow:hidden on right cell prevents dompdf clipping text off-page. */
  table.row {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    margin-bottom: 7px;
  }
  table.row td {
    vertical-align: top;
    word-wrap: break-word;
    overflow-wrap: break-word;
    overflow: hidden;
    padding: 0;
  }
  td.col-left  { width: 66%; }
  td.col-right { width: 34%; text-align: right; }

  /* ── EXPERIENCE ── */
  .emp-name  { font-size: 9pt; color: #555; }
  .job-title { font-size: 9pt; font-weight: bold; color: #111; }
  .loc-text  { font-size: 7.5pt; color: #555; }
  .date-text { font-size: 7.5pt; color: #555; }
  .exp-desc  { font-size: 8.5pt; color: #333; margin-top: 2px; margin-bottom: 6px; }

  /* ── EDUCATION ── */
  .school-name { font-size: 9pt; color: #444; font-weight: bold; }
  .edu-degree  { font-size: 9pt; font-weight: bold; color: #333; }
  .edu-certs   { font-size: 8pt; color: #666; margin-top: 1px; }
</style>
</head>
<body>

  {{-- HEADER --}}
  <div class="header">
    <div class="name">{{ ($contact->first_name ?? '') . ' ' . ($contact->surname ?? '') }}</div>
    @if(!empty($contact->experience_level))
      <div class="exp-level">{{ $contact->experience_level }}</div>
    @endif
    <div class="contact-line">
      {{ $contact->email ?? '' }}<span class="sep">•</span>
      {{ $contact->linkedin ?? 'linkedin.com' }}<span class="sep">•</span>
      {{ $contact->residential_address ?? '' }}<span class="sep">•</span>
      {{ $contact->phone ?? '' }}<span class="sep">•</span>
      {{ $contact->date_of_birth ?? '' }}<span class="sep">•</span>
      {{ $contact->nationality ?? '' }}
      @if(!empty($contact->license_no))<span class="sep">•</span>{{ $contact->license_no }}@endif
      @if(!empty($contact->language))<span class="sep">•</span>{{ $contact->language }}@endif
      @if(!empty($contact->marital_status))<span class="sep">•</span>{{ $contact->marital_status }}@endif
    </div>
  </div>

  {{-- SUMMARY --}}
  @if($summary)
  <div class="section">
    <div class="section-title">Summary</div>
    <p class="text-body">{{ $summary->summary }}</p>
  </div>
  @endif

  {{-- SKILLS --}}
  @if($skills->count())
  <div class="section">
    <div class="section-title">Skills</div>
    <p class="text-body">{{ $skills->implode(', ') }}</p>
  </div>
  @endif

  {{-- EXPERIENCE --}}
  @if($works->count())
  <div class="section">
    <div class="section-title">Experience</div>
    @foreach($works as $work)
    {{-- Row 1: employer (left, light)  |  location (right, gray) --}}
    <table class="row">
      <tr>
        <td class="col-left"><span class="emp-name">{{ $work->employer }}</span></td>
        <td class="col-right"><span class="loc-text">{{ $work->location }}</span></td>
      </tr>
      {{-- Row 2: job title (left, bold)  |  type + date (right, gray) --}}
      <tr>
        <td class="col-left"><span class="job-title">{{ $work->job_title }}</span></td>
        <td class="col-right">
          <span class="date-text">
            {{ $work->remote == 1 ? 'Remote' : 'Full Time' }}<br>
            {{ $work->start_date }} &ndash; {{ $work->currently_work ? 'Present' : $work->end_date }}
          </span>
        </td>
      </tr>
    </table>
    @if(!empty($work->experienced_with))
    <div class="exp-desc">{{ $work->experienced_with }}</div>
    @endif
    @endforeach
  </div>
  @endif

  {{-- EDUCATION --}}
  @if($educations->count())
  <div class="section">
    <div class="section-title">Education</div>
    @foreach($educations as $edu)
    {{-- Row 0: best_match (e.g. "Doctorate or Ph.D.") -- full width, gray --}}
    @if(!empty($edu->best_match))
    <div style="font-size:9pt; color:#666; margin-bottom:1px;">{{ $edu->best_match }}</div>
    @endif
    {{-- Row 1: school name (left, medium)  |  school location (right, gray) --}}
    <table class="row">
      <tr>
        <td class="col-left"><span class="school-name">{{ $edu->school_name }}</span></td>
        <td class="col-right"><span class="loc-text">{{ $edu->school_location ?? '' }}</span></td>
      </tr>
      {{-- Row 2: degree in field (left, bold)  |  graduation date (right, gray) --}}
      <tr>
        <td class="col-left">
          <span class="edu-degree">{{ $edu->degree }}@if(!empty($edu->field_of_study)) in {{ $edu->field_of_study }}@endif</span>
          @if(!empty($edu->certificates))
            <br><span class="edu-certs">{{ $edu->certificates }}</span>
          @endif
        </td>
        <td class="col-right">
          <span class="date-text">{{ $edu->graduation_month }} {{ $edu->graduation_year }}</span>
        </td>
      </tr>
    </table>
    @endforeach
  </div>
  @endif

</body>
</html>
