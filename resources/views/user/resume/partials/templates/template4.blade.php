<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg overflow-hidden rounded-lg"
    style="width:100%; min-height: 297mm; max-width: 100%; box-sizing: border-box;">
    <div class="px-8 py-6">
      <!-- Header -->
      <header class="text-center pb-4">
        @php
          $contact = App\Models\ResumeContactDetail::where('user_id', auth()->id())->first();
        @endphp
        <h1 class="text-3xl font-semibold">
          {{ $contact->first_name ?? 'Timothy' }} {{ $contact->surname ?? 'Duncan' }}
        </h1>
        <p class="mt-1 text-xl font-semibold tracking-wide text-gray-600">
          {{ $contact->experience_level ?? 'Aircraft Dispatcher | Operational Planning Expert' }}
        </p>
        <p class="text-xs mt-2 m-auto font-medium text-gray-600">
          {{ $contact->email ?? 'help@enhancv.com' }}
          <span class="mx-2">•</span>
          {{ $contact->linkedin ?? 'linkedin.com' }}
          <span class="mx-2">•</span>
          {{ $contact->residential_address ?? 'San Jose, CA' }}
          <span class="mx-2">•</span>
          {{ $contact->phone ?? '+01 ********' }}
          <span class="mx-2">•</span>
          {{ $contact->date_of_birth ?? 'MM-DD-YYYY' }}
          <span class="mx-2">•</span>
          {{ $contact->nationality ?? 'USA' }}
          <span class="mx-2">•</span>
          {{ $contact->license_no ?? 'License No' }}
          <span class="mx-2">•</span>
          {{ $contact->hobbies ?? 'N/A' }}
          <span class="mx-2">•</span>
          {{ $contact->language ?? 'English, French, German' }}
          <span class="mx-2">•</span>
          {{ $contact->marital_status ?? 'Single' }}
        </p>
      </header>

      <!-- Summary -->
      <section class="mt-2">
        @php $summary = App\Models\ResumeUserSummary::where('user_id', auth()->id())->first(); @endphp
        <h2 class="text-center font-semibold text-2xl text-gray-700 border-b-2 pb-3 border-gray-600">Summary</h2>
        <p class="mt-2 text-sm text-gray-700">
          {{ $summary->summary ?? 'Experienced Aircraft Dispatcher with a decade of service in the aviation industry. Proficient in flight planning, weather forecasting and operational control. Inventive problem-solver with a proven record of influencing on-time performance and schedule integrity.' }}
        </p>
      </section>

      <!-- Skills -->
      <section class="mt-6">
        @php $skills = App\Models\ResumeUserSkill::where('user_id', auth()->id())->pluck('skill'); @endphp
        <h2 class="text-center font-semibold text-2xl text-gray-700 border-b-2 pb-3 border-gray-600">Skills</h2>
        <p class="mt-2 text-sm text-gray-700">
          {{ $skills->count() ? $skills->implode(', ') : 'Flight Dispatching, Operational Control, Flight Planning, FAA Regulations, Aircraft Systems, Weather Forecasting, Communication, Negotiation, Microsoft Office, Internet Applications' }}
        </p>
      </section>

      <!-- Experience -->
      <section class="mt-6">
        <h2 class="text-center font-semibold text-2xl text-gray-700 border-b-2 pb-3 border-gray-600">Experience</h2>
        @php $works = App\Models\ResumeWorkHistory::where('user_id', auth()->id())->get(); @endphp
        @forelse($works as $work)
          <div class="mt-2">
            <div class="grid grid-cols-2 items-start text-sm">
              <div class="font-medium text-xl text-gray-600">{{ $work->employer }}</div>
              <div class="text-right text-gray-500">{{ $work->location }}</div>
              <div class="font-medium text-gray-600">{{ $work->job_title }}</div>
              <div class="text-right text-gray-500">{{ $work->remote == 1 ? 'Remote' : 'Full Time' }}<p>{{ $work->start_date }} - {{ $work->currently_work ? 'Present' : $work->end_date }}</p></div>
              <!-- <div class="text-right text-gray-600"></div> -->
            </div>
            <span class="text-gray-700 mt-1">{{ $work->experienced_with }}</span>
            @if(!empty($work->achievements))
              <ul class="mt-1 list-disc pl-5 text-[13px] text-gray-700 space-y-1">
                @foreach(explode("\n", $work->achievements) as $ach)
                  <li>{{ $ach }}</li>
                @endforeach
              </ul>
            @endif
          </div>
        @empty
          <!-- Default static experience -->
          <div class="mt-2">
            <div class="grid grid-cols-2 items-start text-sm">
              <div class="font-medium text-xl text-gray-600">American Airlines</div>
              <div class="text-right text-gray-500">Dallas, TX</div>
              <div class="font-medium text-gray-600">Aircraft Dispatcher</div>
              <div class="text-right text-gray-600">2017 - Present</div>
            </div>
            <span class="text-gray-700 mt-1">Ensured safe and efficient dispatch of aircraft for domestic flights,
              coordinating with pilots and staff.</span>
            <!-- <ul class="mt-1 list-disc pl-5 text-[13px] text-gray-700 space-y-1">
              <li>Improved on-time departure rate by 15% by optimizing flight route planning.</li>
              <li>Streamlined communication process between dispatch team and flight crew, reducing miscommunication
                incidents by 30%.</li>
              <li>Successfully managed irregularities during severe weather conditions, minimizing delay times and
                maintaining safety standards.</li>
            </ul> -->
          </div>
          <div class="mt-2">
            <div class="grid grid-cols-2 items-start text-sm">
              <div class="font-medium text-xl text-gray-600">United Airlines</div>
              <div class="text-right text-gray-500">Chicago, IL</div>
              <div class="font-medium text-gray-600">Flight Dispatcher</div>
              <div class="text-right text-gray-600">2013 - 2017</div>
            </div>
            <span class="text-gray-700 mt-1">Worked on flight dispatch and coordination for international flights,
              provided support for flight crews.</span>
            <!-- <ul class="mt-1 list-disc pl-5 text-[13px] text-gray-700 space-y-1">
              <li>Managed flight diversions and reschedules during flight emergencies, ensuring minimal disruption to
                passengers and operations.</li>
              <li>Pioneered a project to implement advanced weather monitoring systems, improving overall flight safety
                and forecasting accuracy.</li>
              <li>Negotiated fuel contracts, saving the airline over $500k annually.</li>
            </ul> -->
          </div>
          <div class="mt-2">
            <div class="grid grid-cols-2 items-start text-sm">
              <div class="font-medium text-xl text-gray-600">Alaska Airlines</div>
              <div class="text-right text-gray-500">Seattle, WA</div>
              <div class="font-medium text-gray-600">Airline Operations Officer</div>
              <div class="text-right text-gray-600">2009 - 2013</div>
            </div>
            <span class="text-gray-700 mt-1">Handled flight operation communication, coordinated with maintenance, crew
              scheduling and air traffic control.</span>
            <!-- <ul class="mt-1 list-disc pl-5 text-[13px] text-gray-700 space-y-1">
              <li>Assisted in a system-wide upgrade of flight communication software, reducing system downtime by 20%.
              </li>
              <li>Played key role in developing crew scheduling strategy that resulted in an 18% improvement in crew
                utilization.</li>
              <li>Established effective procedures for coordinating emergency responses in line with FAA standards.</li>
            </ul> -->
          </div>
        @endforelse
      </section>

      <!-- Education -->
      <section class="mt-6">
        <h2 class="text-center font-semibold text-2xl border-b-2 pb-3 border-gray-600">Education</h2>
        @php $educations = App\Models\ResumeEducationCertification::where('user_id', auth()->id())->get(); @endphp
        @forelse($educations as $edu)
          <div class="mt-1">
            <div class="font-medium text-xl text-gray-600">{{ $edu->best_match }}</div>
            <div class="grid grid-cols-2 items-start text-sm">
              <div class="font-medium text-xl text-gray-600">{{ $edu->school_name }}</div>
              <div class="text-right text-gray-500">{{ $edu->school_location }}</div>
              <div class="font-medium text-gray-600">{{ $edu->degree }} in {{ $edu->field_of_study }}</div>
              <div class="font-medium text-xl text-gray-600">{{ $edu->certificates }} <p class="text-right">{{ $edu->start_year }} - {{ $edu->graduation_year }}</p></div>
              <!-- <div class="text-right text-gray-600"></div> -->
            </div>
          </div>
        @empty
          <div class="mt-1">
            <div class="grid grid-cols-2 items-start text-sm">
              <div class="font-medium text-xl text-gray-600">Embry-Riddle Aeronautical University</div>
              <div class="text-right text-gray-500">Daytona Beach, FL</div>
              <div class="font-medium text-gray-600">Master’s Degree in Aeronautical Science</div>
              <div class="text-right text-gray-600">2007 - 2009</div>
            </div>
          </div>
          <div class="mt-2">
            <div class="grid grid-cols-2 items-start text-sm">
              <div class="font-medium text-xl text-gray-600">Purdue University</div>
              <div class="text-right text-gray-500">West Lafayette, IN</div>
              <div class="font-medium text-gray-600">Bachelor’s Degree in Aviation Management</div>
              <div class="text-right text-gray-600">2003 - 2007</div>
            </div>
          </div>
        @endforelse
      </section>
    </div>
  </div>
</div>

{{-- static code --}}

{{--
<!-- Timothy Duncan Resume (Tailwind) -->
<div class="mx-auto  bg-white text-gray-900 leading-relaxed px-8 py-10">

  <!-- Header -->
  <header class="text-center pb-6 ">
    <h1 class="text-3xl font-semibold">Timothy Duncan</h1>
    <p class="mt-1 text-xl font-semibold tracking-wide text-gray-600">
      Aircraft Dispatcher | Operational Planning Expert
    </p>
    <p class=" text-xs font-medium text-gray-600">
      help@enhancv.com <span class="mx-2">•</span> linkedin.com <span class="mx-2">•</span> San Jose, CA
    </p>
  </header>

  <!-- Summary -->
  <section class="mt-2">
    <h2 class="text-center font-semibold text-2xl  text-gray-700 border-b-2 pb-3 border-gray-600">Summary</h2>
    <p class="mt-2 text-sm text-gray-700">
      Experienced Aircraft Dispatcher with a decade of service in the aviation industry.
      Proficient in flight planning, weather forecasting and operational control.
      Inventive problem-solver with a proven record of influencing on-time performance and schedule integrity.
    </p>
  </section>

  <!-- Skills -->
  <section class="mt-6">
    <h2 class="text-center font-semibold text-2xl  text-gray-700 border-b-2 pb-3 border-gray-600">Skills</h2>
    <p class="mt-2 text-sm text-gray-700">
      Flight Dispatching, Operational Control, Flight Planning, FAA Regulations, Aircraft Systems, Weather Forecasting,
      Communication, Negotiation, Microsoft Office, Internet Applications
    </p>
  </section>

  <!-- Experience -->
  <section class="mt-6">
    <h2 class="text-center font-semibold text-2xl  text-gray-700 border-b-2 pb-3 border-gray-600">Experience</h2>

    <!-- Item -->
    <div class="mt-2">
      <div class="grid grid-cols-2 items-start text-sm">
        <div class="font-medium text-xl text-gray-600">American Airlines</div>
        <div class="text-right text-gray-500">Dallas, TX</div>
        <div class="font-medium ">Aircraft Dispatcher</div>
        <div class="text-right text-gray-600">2017 - Present</div>
      </div>
      <span class="text-gray-700 mt-1">Ensured safe and efficient dispatch of aircraft for domestic flights,
        coordinating with pilots and staff.</span>
      <ul class="mt-1 list-disc pl-5 text-[13px] text-gray-700 space-y-1">
        <li>Improved on-time departure rate by 15% by optimizing flight route planning.</li>
        <li>Streamlined communication process between dispatch team and flight crew, reducing miscommunication incidents
          by 30%.</li>
        <li>Successfully managed irregularities during severe weather conditions, minimizing delay times and maintaining
          safety standards.</li>
      </ul>
    </div>

    <!-- Item -->
    <div class="mt-2">
      <div class="grid grid-cols-2 items-start text-sm">
        <div class="font-medium text-xl text-gray-600">United Airlines</div>
        <div class="text-right text-gray-500">Chicago, IL</div>
        <div class="font-medium text-gray-600">Flight Dispatcher</div>
        <div class="text-right text-gray-600">2013 - 2017</div>
      </div>
      <span class="text-gray-700 mt-1">Worked on flight dispatch and coordination for international flights, provided
        support for flight crews.</span>
      <ul class="mt-1 list-disc pl-5 text-[13px] text-gray-700 space-y-1">
        <li>Managed flight diversions and reschedules during flight emergencies, ensuring minimal disruption to
          passengers and operations.</li>
        <li>Pioneered a project to implement advanced weather monitoring systems, improving overall flight safety and
          forecasting accuracy.</li>
        <li>Negotiated fuel contracts, saving the airline over $500k annually.</li>
      </ul>
    </div>

    <!-- Item -->
    <div class="mt-2">
      <div class="grid grid-cols-2 items-start text-sm">
        <div class="font-medium text-xl text-gray-600">Alaska Airlines</div>
        <div class="text-right text-gray-500">Seattle, WA</div>
        <div class="font-medium text-gray-600">Airline Operations Officer</div>
        <div class="text-right text-gray-600">2009 - 2013</div>
      </div>
      <span class="text-gray-700 mt-1">Handled flight operation communication, coordinated with maintenance, crew
        scheduling and air traffic control.</span>
      <ul class="mt-1 list-disc pl-5 text-[13px] text-gray-700 space-y-1">
        <li>Assisted in a system-wide upgrade of flight communication software, reducing system downtime by 20%.</li>
        <li>Played key role in developing crew scheduling strategy that resulted in an 18% improvement in crew
          utilization.</li>
        <li>Established effective procedures for coordinating emergency responses in line with FAA standards.</li>
      </ul>
    </div>
  </section>

  <section class="mt-6">
    <h2 class="text-center font-semibold text-2xl border-b-2 pb-3 border-gray-600">Education</h2>
    <div class="mt-1">
      <div class="grid grid-cols-2 items-start text-sm">
        <div class="font-medium text-xl text-gray-600">Embry-Riddle Aeronautical University</div>
        <div class="text-right text-gray-500">Daytona Beach, FL</div>
        <div class="font-medium text-gray-600">Master’s Degree in Aeronautical Science</div>
        <div class="text-right text-gray-600">2007 - 2009</div>
      </div>
    </div>
    <div class="mt-2">
      <div class="grid grid-cols-2 items-start text-sm">
        <div class="font-medium text-xl text-gray-600">Purdue University</div>
        <div class="text-right text-gray-500">West Lafayette, IN</div>
        <div class="font-medium text-gray-600">Bachelor’s Degree in Aviation Management</div>
        <div class="text-right text-gray-600">2003 - 2007</div>
      </div>
    </div>
  </section>
</div>
--}}