@extends('user.layout.user')

@section('content')
    <div class="py-7">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-3">

                <div class="col-span-12 md:col-span-4 flex flex-col gap-3">
                    <div class="text-gray-400 text-sm mb-4">
                        <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
                        <i class="pi pi-chevron-right text-sm"></i>
                        <span class="text-gray-200 text-lg">Jobs</span>
                    </div>
                    <div class="overflow-hidden profile-card bg-secondary-color p-6 shadow-sm rounded-xl">
                        <div class="flex justify-between items-center gap-3">
                            <span class="text-2xl text-white font-bold">Filter</span>
                            <a href="{{ route('user.job.index') }}" class="text-sm text-white">Clear all</a>
                        </div>
                        <form method="GET" action="{{ route('user.job.index') }}" class="mt-3">
                            <div class="mb-3">
                                <label class="block text-base mb-2 text-white">Airlines</label>
                                <input type="text" name="airlines" value="{{ request('airlines') }}"
                                    placeholder="e.g. Gal Aerostaff"
                                    class="w-full px-4 py-2 rounded-md bg-primary-dark text-white placeholder-gray-400 focus:outline-none">
                            </div>

                            <div class="mb-3">
                                <label class="block text-base mb-2 text-white">Location</label>
                                <input type="text" name="location" value="{{ request('location') }}"
                                    placeholder="e.g. New York"
                                    class="w-full px-4 py-2 rounded-md bg-primary-dark text-white placeholder-gray-400 focus:outline-none">
                            </div>

                            <div class="mb-3">
                                <label class="block text-base mb-2 text-white">Job Type</label>
                                <select name="type"
                                    class="w-full px-4 py-2 rounded-md bg-primary-dark text-white focus:outline-none">
                                    <option value="">All</option>
                                    <option value="FullTime" {{ request('type') == 'Full Time' ? 'selected' : '' }}>Full Time
                                    </option>
                                    <option value="PartTime" {{ request('type') == 'Part Time' ? 'selected' : '' }}>Part Time
                                    </option>
                                    <option value="Remote" {{ request('type') == 'Contract' ? 'selected' : '' }}>Remote
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="block text-base mb-2 text-white">Years of experience</label>
                                <input type="text" name="experience" value="{{ request('experience') }}"
                                    placeholder="e.g. 1,2,3,4... Years"
                                    class="w-full px-4 py-2 rounded-md bg-primary-dark text-white placeholder-gray-400 focus:outline-none">
                            </div>

                            <button
                                class="w-full bg-primary-color hover:bg-blue-700 py-2 rounded-md text-white font-semibold">
                                Search Jobs
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-8 flex flex-col gap-3">
                    <h2 class="font-bold text-2xl text-white mb-4">Recommended Jobs for You</h2>

                    @if($jobs->isNotEmpty())
                        @foreach ($jobs as $job)
                            <div
                                class="bg-secondary-color text-white p-4 rounded-lg transition-transform hover:scale-[1.02] duration-300">
                                <div class="flex justify-between mb-2 gap-2 flex-wrap">
                                    <div>
                                        <h3 class="font-semibold text-2xl mb-2 text-white">{{ $job->for_airlines }}</h3>
                                        <p class="text-white text-sm mb-2">
                                            Experience: {{ $job->experience ?? 'N/A' }}
                                        </p>
                                        <p class="text-white text-sm mb-2">
                                            Title: {{ $job->title ?? 'N/A' }}
                                        </p>
                                        <span class="text-white text-sm">Job Type: {{ ucfirst($job->type) }}</span>
                                    </div>
                                    <div class="flex items-start text-sm text-gray-300">
                                        <i class="pi pi-map-marker text-primary-color mr-2"></i> {{ $job->location }}
                                    </div>
                                </div>

                                <p class="text-sm mb-2">{{ $job->description }}</p>

                                <div class="flex flex-wrap gap-3 mb-3 text-sm text-gray-300">
                                    <span class="flex items-center gap-2">
                                        <i class="pi pi-calendar text-primary-color text-base"></i>
                                        Posted On: {{ $job->created_at->format('F d, Y') }}
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <i class="pi pi-calendar text-primary-color text-base"></i>
                                        Apply By: {{ \Carbon\Carbon::parse($job->last_date)->format('F d, Y') }}
                                    </span>
                                </div>

                                <a href="{{ Str::startsWith($job->link, ['http://', 'https://']) ? $job->link : 'https://' . $job->link }}"
                                    target="_blank"
                                    class="bg-primary-color px-4 py-2 rounded-md text-white hover:bg-blue-700 text-sm">
                                    Apply Now
                                </a>
                            </div>
                        @endforeach

                        @if ($jobs->hasPages())
                            <div class="flex justify-center gap-2 mt-6">
                                @if ($jobs->onFirstPage())
                                    <button class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md"
                                        disabled>&lt;&lt;</button>
                                    <button class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md" disabled>&lt;</button>
                                @else
                                    <a href="{{ $jobs->appends(request()->query())->url(1) }}"
                                        class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md">&lt;&lt;</a>
                                    <a href="{{ $jobs->appends(request()->query())->previousPageUrl() }}"
                                        class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md">&lt;</a>
                                @endif

                                @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                                    @if ($page == $jobs->currentPage())
                                        <button class="md:px-3 px-2 py-1 text-white bg-primary-color rounded-md">{{ $page }}</button>
                                    @else
                                        <a href="{{ $url }}&{{ http_build_query(request()->except('page')) }}"
                                            class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($jobs->hasMorePages())
                                    <a href="{{ $jobs->appends(request()->query())->nextPageUrl() }}"
                                        class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md">&gt;</a>
                                    <a href="{{ $jobs->appends(request()->query())->url($jobs->lastPage()) }}"
                                        class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md">&gt;&gt;</a>
                                @else
                                    <button class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md" disabled>&gt;</button>
                                    <button class="md:px-3 px-2 py-1 text-white bg-secondary-color rounded-md"
                                        disabled>&gt;&gt;</button>
                                @endif
                            </div>
                        @endif

                    @else
                        <div class="grid grid-cols-1">
                            @for($i = 0; $i < 1; $i++)
                                <div
                                    class="bg-[#C5C5C5] rounded-lg shadow-inner flex flex-col justify-center items-center p-6 h-48">
                                    <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Job"
                                        class="w-14 h-14 mb-3 opacity-70">
                                    <p class="text-gray-700 text-base font-medium text-center">No Recommended Job</p>
                                </div>
                            @endfor
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection