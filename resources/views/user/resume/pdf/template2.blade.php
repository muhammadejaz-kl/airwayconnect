<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
  @page { size: A4; margin: 16mm 0; }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'DejaVu Sans', sans-serif; font-size: 9.5pt; color: #1a1a1a; line-height: 1.5; margin: 0 22mm; }

  .header { border-bottom: 1.5px solid #ccc; padding-bottom: 8px; margin-bottom: 10px; }
  .name { font-size: 18pt; font-weight: bold; color: #111; }
  .exp-level { font-size: 10pt; color: #c49a06; font-weight: bold; margin-top: 3px; }
  .contact-line { font-size: 7.5pt; color: #555; margin-top: 5px; }
  .contact-line .sep { margin: 0 5px; color: #c49a06; }

  .section { margin-bottom: 12px; }
  .section-title { font-size: 12pt; font-weight: bold; color: #111; margin-bottom: 7px; text-transform: uppercase; }
  .text-body { font-size: 8.5pt; color: #333; }

  table.tl { width: 100%; border-collapse: collapse; table-layout: fixed; margin-bottom: 9px; }
  td.tl-date { width: 26%; vertical-align: top; font-size: 8pt; color: #555; padding-right: 10px; font-weight: bold; word-wrap: break-word; overflow-wrap: break-word; overflow: hidden; }
  td.tl-body { width: 74%; vertical-align: top; border-left: 2px solid #ccc; padding-left: 10px; word-wrap: break-word; overflow-wrap: break-word; overflow: hidden; }

  .tl-jobtitle { font-size: 9.5pt; font-weight: bold; color: #444; }
  .tl-employer  { font-size: 8.5pt; color: #c49a06; font-weight: bold; }
  .tl-meta      { font-size: 8pt; color: #666; font-weight: normal; }
  .tl-desc      { font-size: 8.5pt; color: #333; margin-top: 2px; }

  .edu-degree { font-size: 9.5pt; font-weight: bold; color: #222; }
  .edu-school { font-size: 8.5pt; color: #555; }
  .edu-certs  { font-size: 8pt; color: #666; }
</style>
</head>
<body>

  <div class="header">
    <div class="name">{{ ($contact->first_name ?? '') . ' ' . ($contact->surname ?? '') }}</div>
    @if(!empty($contact->experience_level))
      <div class="exp-level">{{ $contact->experience_level }}</div>
    @endif
    <div class="contact-line">
      {{ $contact->email ?? '' }}<span class="sep">•</span>
      {{ $contact->phone ?? '' }}<span class="sep">•</span>
      {{ $contact->date_of_birth ?? '' }}<span class="sep">•</span>
      {{ $contact->nationality ?? '' }}
      @if(!empty($contact->license_no))<span class="sep">•</span>{{ $contact->license_no }}@endif
      @if(!empty($contact->language))<span class="sep">•</span>{{ $contact->language }}@endif
      @if(!empty($contact->marital_status))<span class="sep">•</span>{{ $contact->marital_status }}@endif
      @if(!empty($contact->residential_address))<span class="sep">•</span>{{ $contact->residential_address }}@endif
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
    <table class="tl">
      <tr>
        <td class="tl-date">
          {{ $work->start_date }} &ndash;<br>{{ $work->currently_work ? 'Present' : $work->end_date }}
          <br><span class="tl-meta">{{ $work->location }}</span>
          <br><span class="tl-meta">{{ $work->remote == 1 ? 'Remote' : 'Full Time' }}</span>
        </td>
        <td class="tl-body">
          <div class="tl-jobtitle">{{ $work->job_title }}</div>
          <div class="tl-employer">{{ $work->employer }}</div>
          @if(!empty($work->experienced_with))
            <div class="tl-desc">{{ $work->experienced_with }}</div>
          @endif
        </td>
      </tr>
    </table>
    @endforeach
  </div>
  @endif

  @if($educations->count())
  <div class="section">
    <div class="section-title">Education</div>
    @foreach($educations as $edu)
    <table class="tl">
      <tr>
        <td class="tl-date">{{ $edu->graduation_month }} {{ $edu->graduation_year }}</td>
        <td class="tl-body">
          <div class="edu-degree">
            {{ $edu->degree }}@if(!empty($edu->field_of_study)) in {{ $edu->field_of_study }}@endif
          </div>
          <div class="edu-school">
            {{ $edu->school_name }}@if(!empty($edu->school_location)), {{ $edu->school_location }}@endif
          </div>
          @if(!empty($edu->certificates))
            <div class="edu-certs">{{ $edu->certificates }}</div>
          @endif
        </td>
      </tr>
    </table>
    @endforeach
  </div>
  @endif

</body>
</html>
