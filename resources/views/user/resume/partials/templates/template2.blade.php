<div class="flex justify-center items-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg overflow-hidden rounded-lg flex flex-col"
    style="width:100%; min-height: 297mm; max-width: 100%; box-sizing: border-box;">

    <div class="p-8 pb-4">
      @php
        $contact = App\Models\ResumeContactDetail::where('user_id', auth()->id())->first();
      @endphp
      <h1 class="text-3xl font-bold text-gray-900">
        {{ $contact->first_name ?? 'Timothy' }} {{ $contact->surname ?? 'Duncan' }}
      </h1>
      <p class="text-[#1f9be1] mt-2 font-semibold text-base">
        {{ $contact->experience_level ?? 'Aircraft Dispatcher | Operational Planning Expert' }}
      </p>
      <div class="flex mt-2 flex-wrap items-center gap-x-5 gap-y-2 text-xs text-gray-600 font-semibold">
        <p><span class="text-[#1f9be1]">@</span> {{ $contact->email ?? 'help@enhancv.com' }}</p>
        <p><span class="text-[#1f9be1]">@</span> {{ $contact->phone ?? '+01 ********' }}</p>
        <p><span class="text-[#1f9be1]">@</span> {{ $contact->date_of_birth ?? 'MM-DD-YYYY' }}</p>
        <p><span class="text-[#1f9be1]">@</span> {{ $contact->nationality ?? 'USA' }}</p>
        <p><span class="text-[#1f9be1]">@</span> {{ $contact->license_no ?? 'License No' }}</p>
        <p> {{@ $contact->hobbies ?? '' }}</p>
        <p><span class="text-[#1f9be1]">@</span> {{ $contact->language ?? 'English, French, German' }}</p>
        <p><span class="text-[#1f9be1]">@</span> {{ $contact->marital_status ?? 'Single' }}</p>
        <p><i class="pi pi-link text-[#1f9be1]"></i> linkedin.com</p>
        <span><i class="pi pi-map-marker text-[#1f9be1]"></i>
          {{ $contact->residential_address ?? 'San Jose, CA' }}</span>
      </div>
    </div>

    <div class="px-8 space-y-4">
      {{-- SUMMARY --}}
      <section>
        @php $summary = App\Models\ResumeUserSummary::where('user_id', auth()->id())->first(); @endphp
        <h2 class="font-bold text-xl border-b-[4px] border-gray-800 pb-2 w-full">SUMMARY</h2>
        <p class="text-gray-700 text-sm mt-2 leading-relaxed">
          {{ $summary->summary ?? 'Experienced Aircraft Dispatcher with a decade of service in the aviation industry. Proficient in flight planning, weather forecasting and operational control. Inventive problem-solver with a proven record of influencing on-time performance and schedule integrity.' }}
        </p>
      </section>

      {{-- SKILLS --}}
      <section>
        @php $skills = App\Models\ResumeUserSkill::where('user_id', auth()->id())->pluck('skill'); @endphp
        <h2 class="font-bold text-xl border-b-[4px] border-gray-800 pb-2 w-full">SKILLS</h2>
        <p class="text-gray-700 text-sm mt-2 leading-relaxed">
          {{ $skills->count() ? $skills->implode(', ') : 'Flight Dispatching, Operational Control, Flight Planning, FAA Regulations, Aircraft Systems, Weather Forecasting, Communication, Negotiation, Microsoft Office, Internet Applications' }}
        </p>
      </section>

      {{-- EXPERIENCE --}}
      <section>
        @php $works = App\Models\ResumeWorkHistory::where('user_id', auth()->id())->get(); @endphp
        <h2 class="font-bold text-xl border-b-[4px] border-gray-800 pb-2 w-full">EXPERIENCE</h2>
        @forelse($works as $work)
          <div class="mt-2">
            <h3 class="font-medium text-gray-900 text-lg">{{ $work->job_title }}</h3>
            <p class="text-[#1f9be1] font-semibold text-sm">{{ $work->employer }}</p>
            <p class="text-sm text-gray-500">
              <i class="pi pi-calendar"></i> {{ $work->start_date }} –
              {{ $work->currently_work ? 'Present' : $work->end_date }}
              <i class="pi pi-map-marker ml-2"></i> {{ $work->location }}
              <i class="pi pi-map-marker ml-2"></i> {{ $work->remote == 1 ? 'Remote' : 'Full Time' }}
            </p>
            <span class="mt-1 text-gray-500">{{ $work->experienced_with }}</span>
          </div>
        @empty
          {{-- Default Experience --}}
          <div class="mt-2">
            <h3 class="font-medium text-gray-900 text-lg">Aircraft Dispatcher</h3>
            <p class="text-[#1f9be1] font-semibold text-sm">American Airlines</p>
            <p class="text-sm text-gray-500"><i class="pi pi-calendar"></i> 2017 – Present <i
                class="pi pi-map-marker ml-2"></i> Dallas, TX</p>
            <span class="mt-1 text-gray-500">Ensured safe and efficient dispatch of aircraft for domestic flights, coordinating with
              pilots and staff.</span>
          </div>
          <div class="mt-4">
            <h3 class="font-medium text-gray-900 text-lg">Flight Dispatcher</h3>
            <p class="text-[#1f9be1] font-semibold text-sm">United Airlines</p>
            <p class="text-sm text-gray-500"><i class="pi pi-calendar"></i> 2013 – 2017 <i
                class="pi pi-map-marker ml-2"></i> Chicago, IL</p>
            <span class="mt-1 text-gray-500">Worked on flight dispatch and coordination for international flights, provided support for
              flight crews.</span>
          </div>
          <div class="mt-4">
            <h3 class="font-medium text-gray-900 text-lg">Airline Operations Officer</h3>
            <p class="text-[#1f9be1] font-semibold text-sm">Alaska Airlines</p>
            <p class="text-sm text-gray-500"><i class="pi pi-calendar"></i> 2009 – 2013 <i
                class="pi pi-map-marker ml-2"></i> Seattle, WA</p>
            <span class="mt-1 text-gray-500">Handled flight operation communication, coordinated with maintenance, crew scheduling and
              air traffic control.</span>
          </div>
        @endforelse
      </section>

      {{-- EDUCATION --}}
      <section>
        @php $educations = App\Models\ResumeEducationCertification::where('user_id', auth()->id())->get(); @endphp
        <h2 class="font-bold text-xl border-b-[4px] border-gray-800 pb-2 w-full">EDUCATION</h2>
        @forelse($educations as $edu)
          <div class="mt-1">
            <p class="font-medium text-gray-800 text-xl">{{ $edu->degree }} in {{ $edu->field_of_study }}</p>
            <p class="text-[#1f9be1] text-sm font-semibold">{{ $edu->best_match }}</p>
            <p class="text-[#1f9be1] text-sm font-semibold">{{ $edu->certificates }}</p>
            <p class="text-[#1f9be1] text-sm font-semibold">{{ $edu->school_name }}</p>
            <p class="text-sm text-gray-500">
              <i class="pi pi-calendar"></i> {{ $edu->graduation_year }}
              <i class="pi pi-map-marker ml-2"></i> {{ $edu->school_location }}
            </p>
          </div>
        @empty
          {{-- Default Education --}}
          <div class="mt-1">
            <p class="font-medium text-gray-800 text-xl">Master’s Degree in Aeronautical Science</p>
            <p class="text-[#1f9be1] text-sm font-semibold">Embry-Riddle Aeronautical University</p>
            <p class="text-sm text-gray-500"><i class="pi pi-calendar"></i> 2007 – 2009 <i
                class="pi pi-map-marker ml-2"></i> Daytona Beach, FL</p>
          </div>
          <div class="mt-1">
            <p class="font-medium text-gray-800 text-xl">Bachelor’s Degree in Aviation Management</p>
            <p class="text-[#1f9be1] text-sm font-semibold">Purdue University</p>
            <p class="text-sm text-gray-500"><i class="pi pi-calendar"></i> 2003 – 2007 <i
                class="pi pi-map-marker ml-2"></i> West Lafayette, IN</p>
          </div>
        @endforelse
      </section>
    </div>
  </div>
</div>




{{-- static data code --}}
{{--
<div class="bg-white shadow-lg  overflow-hidden w-full flex flex-col">
  <div class="p-8">
    <h1 class="text-3xl font-bold text-gray-900">Timothy Duncan</h1>
    <p class="text-[#1f9be1] font-semibold text-base">
      Aircraft Dispatcher | Operational Planning Expert
    </p>
    <div class="flex justify-between w-[50%] flex-wrap items-center gap-6 text-xs text-gray-600 font-semibold">
      <p><span class="text-[#1f9be1]">@</span> help@enhancv.com</p>
      <p> <i class="pi pi-link  text-[#1f9be1]"></i> linkedin.com</p>
      <span><i class="pi pi-map-marker text-[#1f9be1] "></i> San Jose, CA</span>
    </div>
  </div>

  <div class="px-8 pb-10 space-y-8">
    <section>
      <h2 class="font-bold text-2xl border-b-[4px] border-gray-800 w-full ">SUMMARY</h2>
      <p class="text-gray-700 text-sm mt-2 leading-relaxed">
        Experienced Aircraft Dispatcher with a decade of service in the aviation industry. Proficient in flight
        planning, weather
        forecasting and operational control. Inventive problem-solver with a proven record of influencing on-time
        performance and
        schedule integrity.
      </p>
    </section>
    <section>
      <h2 class="font-bold text-2xl border-b-[4px] border-gray-800 w-full">SKILLS</h2>
      <p class="text-gray-700 text-sm mt-2 leading-relaxed">
        Flight Dispatching, Operational Control, Flight Planning, FAA Regulations, Aircraft Systems, Weather
        Forecasting,
        Communication, Negotiation, Microsoft Office, Internet Applications
      </p>
    </section>
    <section>
      <h2 class="font-bold text-2xl border-b-[4px] border-gray-800 w-full">EXPERIENCE</h2>
      <div class="mt-2">
        <h3 class="font-medium text-gray-900 text-lg">Aircraft Dispatcher</h3>
        <p class="text-[#1f9be1] font-semibold text-sm">American Airlines</p>
        <p class="text-sm text-gray-500"><i class="pi pi-calendar "></i> 2017 – Present <i
            class="pi pi-map-marker ml-2 "></i> Dallas, TX</p>
        <span class="mt-1 text-gray-500">Ensured safe and efficient dispatch of aircraft for domestic flights, coordinating with
          pilots and staff.</span>
        <ul class="list-disc pl-5 text-sm text-gray-700 mt-1 space-y-1">
          <li>Improved on-time departure rate by 15% by optimizing flight route planning.</li>
          <li>Streamlined communication process between dispatch team and flight crew, reducing miscommunication
            incidents by 30%.</li>
          <li>Successfully managed irregularities during severe weather conditions, minimizing delay times and
            maintaining safety standards.</li>
        </ul>
      </div>
      <div class="mt-4">
        <h3 class="font-medium text-gray-900 text-lg">Flight Dispatcher</h3>
        <p class="text-[#1f9be1] font-semibold text-sm">United Airlines</p>
        <p class="text-sm text-gray-500"><i class="pi pi-calendar "></i> 2013 – 2017 <i
            class="pi pi-map-marker ml-2 "></i> Chicago, IL</p>
        <span class="mt-1 text-gray-500">Worked on flight dispatch and coordination for international flights, provided support for
          flight crews.</span>
        <ul class="list-disc pl-5 text-sm text-gray-700 mt-1 space-y-1">
          <li>Managed flight diversions and reschedules during flight emergencies, ensuring minimal disruption to
            passengers and operations.</li>
          <li>Pioneered a project to implement advanced weather monitoring systems, improving overall flight safety and
            forecasting accuracy.</li>
          <li>Negotiated fuel contracts, saving the airline over $500k annually.</li>
        </ul>
      </div>

      <div class="mt-4">
        <h3 class="font-medium text-gray-900 text-lg">Airline Operations Officer</h3>
        <p class="text-[#1f9be1] font-semibold text-sm">Alaska Airlines</p>
        <p class="text-sm text-gray-500"><i class="pi pi-calendar "></i> 2009 – 2013 <i
            class="pi pi-map-marker ml-2 "></i> Seattle, WA</p>
        <span class="mt-1 text-gray-500">Handled flight operation communication, coordinated with maintenance, crew scheduling and air
          traffic control.</span>
        <ul class="list-disc pl-5 text-sm text-gray-700 mt-1 space-y-1">
          <li>Assisted in a system-wide upgrade of flight communication software, reducing system downtime by 20%.</li>
          <li>Played key role in developing crew scheduling strategy that resulted in an 18% improvement in crew
            utilization.</li>
          <li>Established effective procedures for coordinating emergency responses in line with FAA standards.</li>
        </ul>
      </div>
    </section>

    <section>
      <h2 class="font-bold text-2xl border-b-[4px] border-gray-800 w-full">EDUCATION</h2>
      <div class="mt-1">
        <p class="font-medium text-gray-800 text-xl">Master’s Degree in Aeronautical Science</p>
        <p class="text-[#1f9be1] text-sm font-semibold">Embry-Riddle Aeronautical University</p>
        <p class="text-sm text-gray-500"><i class="pi pi-calendar "></i> 2007 – 2009 <i
            class="pi pi-map-marker ml-2 "></i> Daytona Beach, FL</p>
      </div>
      <div class="mt-1">
        <p class="font-medium text-gray-800 text-xl">Bachelor’s Degree in Aviation Management</p>
        <p class="text-[#1f9be1] text-sm font-semibold">Purdue University</p>
        <p class="text-sm text-gray-500"><i class="pi pi-calendar "></i> 2003 – 2007 <i
            class="pi pi-map-marker ml-2 "></i> West Lafayette, IN</p>
      </div>
    </section>

  </div>
</div>
--}}