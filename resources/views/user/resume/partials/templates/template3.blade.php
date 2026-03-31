<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg overflow-hidden rounded-lg flex flex-col"
    style="width:100%; min-height: 297mm; max-width: 100%; box-sizing: border-box;">
    <div class="p-8 pb-5">
      <!-- Header -->
      <div class="border-b border-gray-300 pb-5 ">
        @php
          $contact = App\Models\ResumeContactDetail::where('user_id', auth()->id())->first();
        @endphp
        <h1 class="text-3xl font-bold text-gray-900">
          {{ $contact->first_name ?? 'Timothy' }} {{ $contact->surname ?? 'Duncan' }}
        </h1>
        <p class="text-[#d19f09] mt-2 font-semibold text-base">
          {{ $contact->experience_level ?? 'Aircraft Dispatcher | Operational Planning Expert' }}
        </p>
        <div class="flex mt-2 flex-wrap items-center gap-x-5 gap-y-2 text-xs text-gray-600 font-semibold">
          <p><span class="text-[#d19f09]">@</span> {{ $contact->email ?? 'help@enhancv.com' }}</p>
          <p><i class="pi pi-link text-[#d19f09]"></i> {{ $contact->linkedin ?? 'linkedin.com' }}</p>
          <p><i class="pi pi-link text-[#d19f09]"></i> {{ $contact->phone ?? '+01 ********' }}</p>
          <p><i class="pi pi-link text-[#d19f09]"></i> {{ $contact->date_of_birth ?? 'MM-DD-YYYY' }}</p>
          <p><i class="pi pi-link text-[#d19f09]"></i> {{ $contact->nationality ?? 'USA' }}</p>
          <p><i class="pi pi-link text-[#d19f09]"></i> {{ $contact->license_no ?? 'License No' }}</p>
          <p><i class="pi pi-link text-[#d19f09]"></i> {{ $contact->hobbies ?? 'N/A' }}</p>
          <p><i class="pi pi-link text-[#d19f09]"></i> {{ $contact->language ?? 'English, French, German' }}</p>
          <p><i class="pi pi-link text-[#d19f09]"></i> {{ $contact->marital_status ?? 'Single' }}</p>

          <span><i class="pi pi-map-marker text-[#d19f09]"></i>
            {{ $contact->residential_address ?? 'San Jose, CA' }}</span>
        </div>
      </div>

      {{-- SUMMARY --}}
      <section class="mb-4">
        @php $summary = App\Models\ResumeUserSummary::where('user_id', auth()->id())->first(); @endphp
        <h2 class="font-bold text-xl text-gray-900">SUMMARY</h2>
        <p class="text-gray-700 text-sm mt-2 leading-relaxed">
          {{ $summary->summary ?? 'Experienced Aircraft Dispatcher with a decade of service in the aviation industry. Proficient in flight planning, weather forecasting and operational control. Inventive problem-solver with a proven record of influencing on-time performance and schedule integrity.' }}
        </p>
      </section>

      {{-- SKILLS --}}
      <section class="mb-4">
        @php $skills = App\Models\ResumeUserSkill::where('user_id', auth()->id())->pluck('skill'); @endphp
        <h2 class="font-bold text-xl text-gray-900">SKILLS</h2>
        <p class="text-gray-700 text-sm mt-2">
          {{ $skills->count() ? $skills->implode(', ') : 'Flight Dispatching, Operational Control, Flight Planning, FAA Regulations, Aircraft Systems, Weather Forecasting, Communication, Negotiation, Microsoft Office, Internet Applications' }}
        </p>
      </section>

      {{-- EXPERIENCE --}}
      <section class="mt-6">
        @php $works = App\Models\ResumeWorkHistory::where('user_id', auth()->id())->get(); @endphp
        <h2 class="text-2xl mb-4  font-bold">EXPERIENCE</h2>
        @forelse($works as $work)
          <div class="flex ">
            <div class="w-[29%] text-sm text-gray-500">
              <p class="text-gray-700 font-semibold text-md">{{ $work->start_date }} - {{ $work->currently_work ? 'Present' : $work->end_date }} </p>
              <p>{{ $work->location }}</p>
              <p>{{ $work->remote == 1 ? 'Remote' : 'Full Time' }}</p>
            </div>
            <div class="w-[2px] bg-gray-300 relative mr-12">
              <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-gray-600 text-base">{{ $work->job_title }}</h3>
              <p class="text-[#d19f09] font-semibold">{{ $work->employer }}</p>
              <span class="mt-1">{{ $work->experienced_with }}</span>
              @if(!empty($work->achievements))
                <ul class="list-disc list-inside text-sm text-gray-700 mt-1 space-y-1">
                  @foreach(explode("\n", $work->achievements) as $ach)
                    <li>{{ $ach }}</li>
                  @endforeach
                </ul>
              @endif
            </div>
          </div>
        @empty
          {{-- Default static experience --}}
          <div class="flex mt-2">
            <div class="w-[18%] text-sm text-gray-500">
              <p class="text-gray-700 font-semibold text-base">2017 - Present</p>
              <p>Dallas, TX</p>
            </div>
            <div class="w-[2px] bg-gray-300 relative mr-12">
              <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-gray-600 text-base">Aircraft Dispatcher</h3>
              <p class="text-[#d19f09] font-semibold">American Airlines</p>
              <span class="mt-1">Ensured safe and efficient dispatch of aircraft for domestic flights, coordinating with
                pilots and staff.</span>
              <!-- <ul class="list-disc list-inside text-sm text-gray-700 mt-1 space-y-1">
                <li>Improved on-time departure rate by 15% by optimizing flight route planning.</li>
                <li>Streamlined communication process between dispatch team and flight crew, reducing miscommunication
                  incidents by 30%.</li>
                <li>Successfully managed irregularities during severe weather conditions, minimizing delay times and
                  maintaining safety standards.</li>
              </ul> -->
            </div>
          </div>
          <div class="flex mt-6">
            <div class="w-[18%] text-sm text-gray-500">
              <p class="text-gray-700 font-semibold text-base">2013 - 2017</p>
              <p>Chicago, IL</p>
            </div>
            <div class="w-[2px] bg-gray-300 relative mr-12">
              <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-gray-600 text-base">Flight Dispatcher</h3>
              <p class="text-[#d19f09] font-semibold">United Airlines</p>
              <span class="mt-1">Worked on flight dispatch and coordination for international flights, provided support
                for flight crews.</span>
              <!-- <ul class="list-disc list-inside text-sm text-gray-700 mt-1 space-y-1">
                <li>Managed flight diversions and reschedules during flight emergencies, ensuring minimal disruption to
                  passengers and operations.</li>
                <li>Pioneered a project to implement advanced weather monitoring systems, improving overall flight safety
                  and forecasting accuracy.</li>
                <li>Negotiated fuel contracts, saving the airline over $500k annually.</li>
              </ul> -->
            </div>
          </div>
          <div class="flex mt-6">
            <div class="w-[18%] text-sm text-gray-500">
              <p class="text-gray-700 font-semibold text-base">2009 - 2013</p>
              <p>Seattle, WA</p>
            </div>
            <div class="w-[2px] bg-gray-300 relative mr-12">
              <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-gray-600 text-base">Airline Operations Officer</h3>
              <p class="text-[#d19f09] font-semibold">Alaska Airlines</p>
              <span class="mt-1">Handled flight operation communication, coordinated with maintenance, crew scheduling and
                air traffic control.</span>
              <!-- <ul class="list-disc list-inside text-sm text-gray-700 mt-1 space-y-1">
                <li>Assisted in a system-wide upgrade of flight communication software, reducing system downtime by 20%.
                </li>
                <li>Played key role in developing crew scheduling strategy that resulted in an 18% improvement in crew
                  utilization.</li>
                <li>Established effective procedures for coordinating emergency responses in line with FAA standards.</li>
              </ul> -->
            </div>
          </div>
        @endforelse
      </section>

      {{-- EDUCATION --}}
      <section class="mt-6">
        @php $educations = App\Models\ResumeEducationCertification::where('user_id', auth()->id())->get(); @endphp
        <h2 class="font-bold text-xl mb-4 text-gray-900">EDUCATION</h2>
        @forelse($educations as $edu)
          <div class="flex">
            <div class="w-[29%] text-sm text-gray-500">
              <p class="font-bold text-gray-700 text-md">{{ $edu->start_year }} - {{ $edu->graduation_year }}</p>
              <p>{{ $edu->best_match }}</p>
              <p>{{ $edu->certificates }}</p>
              <p>{{ $edu->school_location }}</p>
            </div>
            <div class="w-[2px] bg-gray-300 relative mr-12">
              <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
            </div>
            <div class="col-span-3">
              <p class="font-bold text-gray-600 text-base">{{ $edu->degree }} in {{ $edu->field_of_study }}</p>
              <p class="text-[#d19f09] text-sm font-semibold">{{ $edu->school_name }}</p>
            </div>
          </div>
        @empty
          {{-- Default static education --}}
          <div class="flex mt-2">
            <div class="w-[18%] text-sm text-gray-500">
              <p class="font-bold text-gray-600 text-md">2007 - 2009</p>
              <p>Daytona Beach, FL</p>
            </div>
            <div class="w-[2px] bg-gray-300 relative mr-12">
              <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
            </div>
            <div class="col-span-3">
              <p class="font-bold text-gray-600 text-base">Master’s Degree in Aeronautical Science</p>
              <p class="text-[#d19f09] text-sm font-semibold">Embry-Riddle Aeronautical University</p>
            </div>
          </div>
          <div class="flex mt-4">
            <div class="w-[18%] text-sm text-gray-500">
              <p class="font-bold text-gray-600 text-md">2003 - 2007</p>
              <p>West Lafayette, IN</p>
            </div>
            <div class="w-[2px] bg-gray-300 relative mr-12">
              <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
            </div>
            <div class="col-span-3">
              <p class="font-bold text-gray-600 text-base">Bachelor’s Degree in Aviation Management</p>
              <p class="text-[#d19f09] text-sm font-semibold">Purdue University</p>
            </div>
          </div>
        @endforelse
      </section>

      {{-- STRENGTHS --}}
      
    </div>
  </div>
</div>

{{-- static code --}}

{{--
<div class="bg-white shadow-lg overflow-hidden w-full p-8">

  <!-- Header -->
  <div class="border-b border-gray-300 pb-4 mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Timothy Duncan</h1>
    <p class="text-[#d19f09] font-semibold text-base">
      Aircraft Dispatcher | Operational Planning Expert
    </p>
    <div class="flex justify-between w-[50%] flex-wrap items-center gap-6 text-xs text-gray-600 font-semibold">
      <p><span class="text-[#d19f09]">@</span> help@enhancv.com</p>
      <p><i class="pi pi-link text-[#d19f09]"></i> linkedin.com</p>
      <span><i class="pi pi-map-marker text-[#d19f09]"></i> San Jose, CA</span>
    </div>
  </div>

  <section class="mb-6">
    <h2 class="font-bold text-xl text-gray-900">SUMMARY</h2>
    <p class="text-gray-700 text-sm mt-2 leading-relaxed">
      Experienced Aircraft Dispatcher with a decade of service in the aviation industry.
      Proficient in flight planning, weather forecasting and operational control.
      Inventive problem-solver with a proven record of influencing on-time performance and schedule integrity.
    </p>
  </section>

  <section class="mb-6">
    <h2 class="font-bold text-xl text-gray-900">SKILLS</h2>
    <p class="text-gray-700 text-sm mt-2">
      Flight Dispatching, Operational Control, Flight Planning, FAA Regulations, Aircraft Systems, Weather Forecasting,
      Communication, Negotiation, Microsoft Office, Internet Applications
    </p>
  </section>

  <section class="mt-6">
    <h2 class="text-2xl font-bold ">EXPERIENCE</h2>

    <div class="flex mt-2">
      <div class="w-[18%] text-sm text-gray-500">
        <p class="text-gray-700 font-semibold text-base">2017 - Present</p>
        <p>Dallas, TX</p>
      </div>
      <div class="w-[2px] bg-gray-300 h-full relative mr-12">
        <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
      </div>
      <div class="flex-1">
        <h3 class="font-bold text-gray-600 text-base">Aircraft Dispatcher</h3>
        <p class="text-[#d19f09] font-semibold">American Airlines</p>
        <span class="mt-1">Ensured safe and efficient dispatch of aircraft for domestic flights, coordinating with
          pilots and staff.</span>
        <ul class="list-disc list-inside text-sm text-gray-700 mt-1 space-y-1">
          <li>Improved on-time departure rate by 15% by optimizing flight route planning.</li>
          <li>Streamlined communication process between dispatch team and flight crew, reducing miscommunication
            incidents by 30%.</li>
          <li>Successfully managed irregularities during severe weather conditions, minimizing delay times and
            maintaining safety standards.</li>
        </ul>
      </div>
    </div>

    <div class="flex mt-6">
      <div class="w-[18%] text-sm text-gray-500">
        <p class="text-gray-700 font-semibold text-base">2013 - 2017</p>
        <p>Chicago, IL</p>
      </div>
      <div class="w-[2px] bg-gray-300 relative mr-12">
        <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
      </div>
      <div class="flex-1">
        <h3 class="font-bold text-gray-600 text-base">Flight Dispatcher</h3>
        <p class="text-[#d19f09] font-semibold">United Airlines</p>
        <span class="mt-1">Worked on flight dispatch and coordination for international flights, provided support for
          flight crews.</span>
        <ul class="list-disc list-inside text-sm text-gray-700 mt-1 space-y-1">
          <li>Managed flight diversions and reschedules during flight emergencies, ensuring minimal disruption to
            passengers and operations.</li>
          <li>Pioneered a project to implement advanced weather monitoring systems, improving overall flight safety and
            forecasting accuracy.</li>
          <li>Negotiated fuel contracts, saving the airline over $500k annually.</li>
        </ul>
      </div>
    </div>

    <div class="flex mt-6">
      <div class="w-[18%] text-sm text-gray-500">
        <p class="text-gray-700 font-semibold text-base">2009 - 2013</p>
        <p>Seattle, WA</p>
      </div>
      <div class="w-[2px] bg-gray-300 relative mr-12">
        <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
      </div>
      <div class="flex-1">
        <h3 class="font-bold text-gray-600 text-base">Airline Operations Officer</h3>
        <p class="text-[#d19f09] font-semibold">Alaska Airlines</p>
        <span class="mt-1">Handled flight operation communication, coordinated with maintenance, crew scheduling and air
          traffic control.</span>
        <ul class="list-disc list-inside text-sm text-gray-700 mt-1 space-y-1">
          <li>Assisted in a system-wide upgrade of flight communication software, reducing system downtime by 20%.</li>
          <li>Played key role in developing crew scheduling strategy that resulted in an 18% improvement in crew
            utilization.</li>
          <li>Established effective procedures for coordinating emergency responses in line with FAA standards.</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="mb-6">
    <h2 class="font-bold text-xl text-gray-900">EDUCATION</h2>
    <div class="flex  mt-2">
      <div class="w-[18%] text-sm text-gray-500">
        <p class="font-bold text-gray-600 text-md">2007 - 2009</p>
        <p>Daytona Beach, FL</p>
      </div>
      <div class="w-[2px] bg-gray-300 relative mr-12">
        <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
      </div>
      <div class="col-span-3">
        <p class="font-bold text-gray-600 text-base">Master’s Degree in Aeronautical Science</p>
        <p class="text-[#d19f09] text-sm font-semibold">Embry-Riddle Aeronautical University</p>
      </div>
    </div>

    <div class="flex mt-4">
      <div class="w-[18%] text-sm text-gray-500">
        <p class="font-bold text-gray-600 text-md">2003 - 2007</p>
        <p>West Lafayette, IN</p>
      </div>
      <div class="w-[2px] bg-gray-300 relative mr-12">
        <div class="w-[10px] h-[10px] bg-black rounded-full absolute -left-[4px] top-0"></div>
      </div>
      <div class="col-span-3">
        <p class="font-bold text-gray-600 text-base">Bachelor’s Degree in Aviation Management</p>
        <p class="text-[#d19f09] text-sm font-semibold">Purdue University</p>
      </div>
    </div>
  </section>

  <section>
    <h2 class="font-bold text-xl text-gray-900">STRENGTHS</h2>
    <div class="grid grid-cols-2 gap-6 mt-2">
      <div class="flex items-start gap-3">
        <i class="pi pi-comments text-[#d19f09] text-xl"></i>
        <div>
          <p class="font-semibold">Communication</p>
          <p class="text-sm text-gray-700">Proven ability to effectively communicate with diverse teams. Played crucial
            role in establishing seamless communication among flight crews at American Airlines.</p>
        </div>
      </div>
      <div class="flex items-start gap-3">
        <i class="pi pi-check-circle text-[#d19f09] text-xl"></i>
        <div>
          <p class="font-semibold">Critical Thinking</p>
          <p class="text-sm text-gray-700">Expert at making on-the-spot and informed decisions during emergency
            situations, ensuring passenger safety and adherence to FAA guidelines.</p>
        </div>
      </div>
    </div>
  </section>
  
</div>
--}}