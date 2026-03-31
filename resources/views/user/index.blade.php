@extends('user.layout.user')
@section('content')
    <div class="py-7">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-12 md:col-span-4 flex flex-col gap-3">
                    <div class="overflow-hidden profile-card bg-secondary-color shadow-sm rounded-xl">
                        <img src="{{ Auth::user()->cover_image ? asset('storage/' . Auth::user()->cover_image) : asset('assets/images/default-cover.jpg') }}"
                            alt="Profile Background" class="w-full h-[148px]">

                        <div class="p-6 text-center">
                            <div
                                class="avatar mx-auto min-w-24 min-h-24 rounded-full overflow-hidden border-4 border-white">
                                <img src="{{ Auth::user()->profile_image
        ? asset('storage/' . Auth::user()->profile_image)
        : asset('admin/assets/img/profiles/avatar-01.png') }}" alt="Avatar"
                                    class="w-full h-full"
                                    onerror="this.onerror=null; this.src='{{ asset('admin/assets/img/profiles/avatar-01.png') }}';">
                            </div>

                            <h2 class="text-2xl text-white my-2">{{ Auth::user()->name ?? 'N/A' }}</h2>
                            <p class="text-white">{{ Auth::user()->email ?? 'N/A' }}</p>

                            <a href="{{ route('user.profile.index') }}"
                                class="bg-primary-color text-white p-3  px-6 mt-3 inline-block rounded-full hover:bg-primary-color/80 transition">
                                Edit Profile
                            </a>

                            <hr class="mt-3 text-gray-400">

                            <ul class="space-y-4 mt-3 w-[70%] mx-auto">
                                @php
                                    $menuItems = [
                                        [
                                            'icon' => asset('assets/images/icon/resumeicon.svg'),
                                            'label' => 'Resume Builder',
                                            'route' => route('user.resume.index'),
                                        ],
                                        [
                                            'icon' => asset('assets/images/icon/interviewicon.svg'),
                                            'label' => 'Interview Prepratoin',
                                            'route' => route('user.interview.index'),
                                        ],
                                        [
                                            'icon' => asset('assets/images/icon/airwayicon.svg'),
                                            'label' => 'Airline Directory',
                                            'route' => route('user.airlineDirectory.index'),
                                        ],
                                        [
                                            'icon' => asset('assets/images/icon/bag.svg'),
                                            'label' => 'Jobs',
                                            'route' => route('user.job.index'),
                                        ],
                                        [
                                            'icon' => asset('assets/images/icon/resourceicon.svg'),
                                            'label' => 'Resource Library',
                                            'route' => route('user.resource.index'),
                                        ],
                                        [
                                            'icon' => asset('assets/images/icon/forum.png'),
                                            'label' => 'Forum',
                                            'route' => route('user.forum.index'),
                                        ],
                                    ];
                                @endphp

                                @foreach($menuItems as $item)
                                    <li class="flex items-center space-x-4 text-[#4A8CFF] hover:text-white cursor-pointer">
                                        <img src="{{ $item['icon'] }}" alt="Icon">
                                        <a href="{{ $item['route'] }}" class="text-base text-white font-normal">
                                            {{ $item['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="bg-secondary-color text-white md:p-4 p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h2 class="md:text-2xl text-[18px] text-white font-semibold">Upcoming Events</h2>
                        </div>

                        @php
                            $event = $events->first();
                        @endphp

                        @if ($event)
                            <div class="mt-4 overflow-hidden rounded-lg bg-secondary-dark">
                                <img src="{{ Storage::url($event->banner) }}" alt="{{ $event->title }}"
                                    class="w-full h-48 rounded-lg object-cover"
                                    onerror="this.onerror=null; this.src='{{ asset('admin/asset/img/default-event.jpg') }}';">

                                <div class="p-3 space-y-2">
                                    <h4 class="text-2xl font-bold text-white">{{ $event->title }}</h4>
                                    <p class="text-base text-gray-300">
                                        {{ Str::limit($event->description, 100) }}
                                    </p>

                                    <div class="flex items-center text-sm text-gray-400 gap-2">
                                        <img src="{{ asset('assets/images/icon/calendar.svg') }}" alt="Calendar">
                                        {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400 gap-2">
                                        <img src="{{ asset('assets/images/icon/clock.svg') }}" alt="Clock">
                                        {{ $event->timing }}
                                    </div>
                                    <div class="text-sm flex gap-2 text-gray-400">
                                        <img src="{{ asset('assets/images/icon/location.svg') }}" alt="Location">
                                        {{ $event->location }}
                                    </div>

                                    <a href="{{ route('user.event.details', $event->id) }}"
                                        class="mt-2 inline-block px-4 py-2 bg-primary-color text-white text-sm rounded-full hover:bg-blue-700 transition">
                                        View Details →
                                    </a>

                                    <a href="{{ Str::startsWith($event->link, ['http://', 'https://']) ? $event->link : 'https://' . $event->link }}" target="_blank"
                                        class="px-4 py-2 bg-gray-600 text-white text-sm rounded-full hover:bg-gray-700 transition">
                                        Visit Link ↗
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="rounded-lg flex flex-col items-center justify-center py-10 mt-6 shadow-inner"
                                style="background-color: #C5C5C5;">
                                <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Events"
                                    class="w-28 h-28 mb-4 opacity-80">
                                <p class="text-gray-700 text-lg font-medium text-center">No events yet.</p>
                            </div>
                        @endif
                    </div>

                </div>
                <div class="col-span-12 md:col-span-8 flex flex-col gap-3">
                    <div class="bg-secondary-color text-white md:p-4 p-3 rounded-lg">
                        <div class="flex justify-between items-center ">
                            <h2 class="md:text-2xl text-[18px] text-white font-semibold">Welcome
                                {{ Auth::user()->name ?? 'N/A' }}
                            </h2>
                        </div>
                    </div>
                    <div class="bg-secondary-color text-white p-4 rounded-lg">
                        <div class="grid grid-cols-12 md:p-4 p-3  items-center">
                            <div class="col-span-12 md:col-span-8 space-y-3">
                                <h3 class="md:text-2xl text-[18px] text-white font-semibold">
                                    Struggling with Resume Writing? Let Experts Help You!
                                </h3>
                                <p>
                                    Get a professionally crafted resume — built from scratch or improved from your current
                                    one.
                                    ATS-optimized. Job-ready.
                                </p>
                                <a href="{{ route('user.resume.index') }}"
                                    class="inline-block bg-primary-color text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                    Create Resume
                                </a>
                            </div>

                            <div class="col-span-12 md:col-span-4">
                                <img src="{{ asset('assets/images/resume-writing.svg') }}" alt="Resume Writing"
                                    class="w-full">
                            </div>
                        </div>

                    </div>
                    <div class="bg-secondary-color text-white md:p-4 p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h2 class="md:text-2xl text-[18px] text-white font-semibold">Job Openings</h2>
                            <a href="{{ route('user.job.index') }}" class="bg-light-white p-2 px-4 rounded-full">
                                View all
                            </a>
                        </div>

                        @if($jobs->isNotEmpty())
                            <div class="job-slider mt-3 relative overflow-hidden">
                                <div class="swiper-wrapper overflow-hidden">
                                    @foreach($jobs as $job)
                                        <div class="swiper-slide">
                                            <div
                                                class="bg-[#112240] text-white rounded-lg p-6 shadow-lg h-full relative transition-transform hover:scale-[1.02] duration-300">
                                                <h3 class="text-xl text-white font-semibold mb-4">{{ $job->title }}</h3>

                                                <div class="space-y-2 text-sm text-gray-300">
                                                    <div class="flex gap-6 flex-wrap">
                                                        <div class="flex items-center gap-2 text-sm">
                                                            <img src="{{ asset('assets/images/icon/location.svg') }}"
                                                                alt="Location">
                                                            {{ $job->location }}
                                                        </div>
                                                        <div class="flex items-center gap-2 text-sm">
                                                            <img src="{{ asset('assets/images/icon/bag.svg') }}" alt="Experience">
                                                            {{ $job->experience }}
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-2 text-sm">
                                                        <img src="{{ asset('assets/images/icon/bag.svg') }}" alt="Type">
                                                        {{ $job->type }}
                                                    </div>

                                                    <div class="flex items-center gap-2 text-sm font-medium">
                                                        <img src="{{ asset('assets/images/icon/calendar.svg') }}" alt="Posted On">
                                                        Posted On: {{ $job->created_at->format('d M Y') }}
                                                    </div>

                                                    <div class="flex items-center gap-2 text-sm font-medium">
                                                        <img src="{{ asset('assets/images/icon/calendar.svg') }}" alt="Apply By">
                                                        Apply By: {{ \Carbon\Carbon::parse($job->last_date)->format('d M Y') }}
                                                    </div>
                                                </div>

                                                <div class="absolute top-4 right-4 text-4xl text-[#1e3a8a] opacity-10">
                                                    <img src="{{ asset('assets/images/icon/plane-vector.svg') }}"
                                                        alt="Plane Vector">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                                @for($i = 0; $i < 3; $i++)
                                    <div
                                        class="bg-[#C5C5C5] rounded-lg shadow-inner flex flex-col items-center justify-center h-56 p-4">
                                        <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Job"
                                            class="w-16 h-16 mb-3 opacity-70">
                                        <p class="text-gray-700 text-base font-medium text-center">No Job Available</p>
                                    </div>
                                @endfor
                            </div>
                        @endif
                    </div>

                    <div class="bg-secondary-color text-white md:p-4 p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h2 class="md:text-2xl text-[18px] text-white font-semibold">Airlines</h2>
                            <a href="{{ route('user.airlineDirectory.index') }}"
                                class="bg-light-white p-2 px-4 rounded-full">
                                View all
                            </a>
                        </div>

                        @if($airlines->isNotEmpty())
                            <div class="relative airline-slider mt-5 pb-4 overflow-hidden">
                                <div class="swiper-wrapper">
                                    @foreach($airlines as $airline)
                                        <div class="swiper-slide text-center">
                                            <a href="{{ route('user.airlineDirectory.show', $airline->id) }}" class="block">
                                                <div
                                                    class="w-[120px] h-[120px] bg-white rounded-full shadow mx-auto overflow-hidden">
                                                    <img src="{{ asset('storage/' . $airline->logo) }}" alt="{{ $airline->name }}"
                                                        class="w-full h-full object-cover"
                                                        onerror="this.onerror=null; this.src='{{ asset('admin/assets/img/default-airline.jpg') }}';">
                                                </div>
                                                <p class="mt-2 text-sm font-medium text-white">{{ $airline->name }}</p>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 mt-6 justify-items-center">
                                @for($i = 0; $i < 6; $i++)
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-[120px] h-[120px] bg-gray-400 rounded-full shadow-inner flex items-center justify-center overflow-hidden">
                                            <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Airline"
                                                class="w-16 h-16 opacity-70">
                                        </div>
                                        <p class="mt-2 text-sm font-medium text-gray-300">No Airline</p>
                                    </div>
                                @endfor
                            </div>
                        @endif
                    </div>

                    <div class="bg-secondary-color text-white md:p-4 p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h2 class="md:text-2xl text-[18px] text-white font-semibold">Interview Preparation</h2>
                            <a href="{{ route('user.interview.index') }}" class="bg-light-white p-2 px-4 rounded-full">
                                View all
                            </a>
                        </div>

                        @if($topics->isNotEmpty())
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-w-6xl w-full mt-4">
                                @foreach($topics as $topic)
                                    <a href="{{ route('user.interview.show', $topic->id) }}"
                                        class="bg-[#112240] text-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 block">
                                        <h3 class="text-base text-white font-bold mb-2">{{ $topic->topic }}</h3>
                                        <p class="text-xs text-gray-300">{{ Str::limit($topic->description, 80) }}</p>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-w-6xl w-full mt-4">
                                @for($i = 0; $i < 3; $i++)
                                    <div
                                        class="bg-[#1b2b46] text-gray-400 p-6 rounded-lg shadow-inner h-32 flex flex-col justify-center">
                                        <h3 class="text-sm leading-snug text-gray-400 font-semibold mb-1">No Interview Prep
                                            Materials
                                            Yet</h3>
                                        <p class="text-sm leading-snug text-gray-400">
                                            We couldn’t find any preparation modules. New content will appear here once added.
                                        </p>
                                    </div>
                                @endfor
                            </div>
                        @endif
                    </div>

                    <div class="bg-secondary-color text-white md:p-4 p-3 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h2 class="md:text-2xl text-[18px] text-white font-semibold">organizations</h2>
                            <a href="{{ route('user.organizations.show') }}" class="bg-light-white p-2 px-4 rounded-full">
                                View all
                            </a>
                        </div>

                        @if($organizations->isNotEmpty())
                            @foreach($organizations->take(2) as $organizations)
                                <a href="{{ route('user.organizations.details', $organizations->id) }}"
                                    class="relative rounded-lg overflow-hidden mt-4 h-60 block group">
                                    <img src="{{ Storage::url($organizations->banner) }}" alt="{{ $organizations->name }}"
                                        class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.onerror=null; this.src='{{ asset('admin/assets/img/default-banner.jpg') }}';">

                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-6 flex flex-col justify-end">
                                        <h2 class="text-xl font-semibold text-white">{{ $organizations->name }}</h2>
                                        <p class="text-xs text-gray-300">{{ Str::limit($organizations->established, 80) }}</p>
                                        <p class="text-xs text-gray-300">{{ Str::limit($organizations->type, 80) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="rounded-lg flex flex-col items-center justify-center py-10 mt-6 shadow-inner"
                                style="background-color: #C5C5C5;">
                                <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Resources"
                                    class="w-28 h-28 mb-4 opacity-80">
                                <p class="text-gray-700 text-lg font-medium text-center">No Resources found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".job-slider", {
                slidesPerView: 2,
                spaceBetween: 30,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    320: {
                        slidesPerView: 1
                    },
                    991: {
                        slidesPerView: 1
                    },
                    1024: {
                        slidesPerView: 2
                    },
                },
            });
            new Swiper(".airline-slider", {
                slidesPerView: 5,
                spaceBetween: 20,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    320: {
                        slidesPerView: 2
                    },
                    640: {
                        slidesPerView: 3
                    },
                    768: {
                        slidesPerView: 3
                    },
                    1024: {
                        slidesPerView: 5
                    },
                }
            });
        });
    </script>
@endsection