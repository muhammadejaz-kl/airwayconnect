@extends('user.layout.user')

@section('content')
    <div class="py-7 px-6">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

            <div class="text-gray-400 text-sm mb-4">
                <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <a href="{{ route('user.resource.index') }}" class="text-gray-200 text-lg">Resource Library, Events &
                    Organizations</a>
            </div>

            <div class="p-5 py-7 rounded-lg rounded-b-none h-[411px] flex flex-col justify-end"
                style="background: url('{{ asset('assets/images/forumimg.svg') }}'); background-size: cover; background-position: center;">
                <h1 class="text-3xl font-bold mb-2 text-white">Resource Library</h1>
                <p class="text-sm text-white">
                    Explore a curated collection of guides, templates, tools, and learning materials designed to support
                    your journey. Whether you're just getting started or looking to grow, our Resource Library has
                    everything you need in one convenient place.
                </p>
            </div>

            <div class="bg-secondary-color flex flex-col gap-10 md:p-6 p-4 rounded-lg rounded-t-none">

                {{--
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="font-bold md:text-3xl text-[20px] text-white">Resources</h2>
                        <a href="{{ route('user.resource.show') }}">
                            <button class="bg-primary-color text-white rounded-full py-2 px-4 hover:bg-blue-700 transition">
                                View all
                            </button>
                        </a>
                    </div>

                    @forelse($resources as $resource)
                    <a href="{{ route('user.resource.details', $resource->id) }}" class="block">
                        <div class="relative rounded-lg overflow-hidden mt-4 h-[334px] hover:opacity-90 transition">
                            <img src="{{ asset('storage/' . $resource->banner) }}" alt="{{ $resource->title }}"
                                class="object-cover w-full h-full">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-6 flex flex-col justify-end">
                                <h2 class="text-3xl font-semibold text-white">{{ $resource->title }}</h2>
                                <p class="text-base text-gray-300">{{ $resource->description }}</p>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="rounded-lg flex flex-col items-center justify-center py-10 mt-6 shadow-inner"
                        style="background-color: #C5C5C5;">
                        <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Resources"
                            class="w-28 h-28 mb-4 opacity-80">
                        <p class="text-gray-700 text-lg font-medium text-center">No Resources found.</p>
                    </div>
                    @endforelse
                </div>

                --}}

                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="font-bold md:text-3xl text-[20px] text-white">Upcoming Events</h2>
                        <a href="{{ route('user.event.show') }}">
                            <button class="bg-primary-color text-white rounded-full py-2 px-4 hover:bg-blue-700 transition">
                                View all
                            </button>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        @if($events->isEmpty())
                            @for($i = 0; $i < 3; $i++)
                                <div class="overflow-hidden rounded-lg shadow-inner transition" style="background-color: #C5C5C5;">
                                    <div class="flex flex-col items-center justify-center h-80">
                                        <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Event"
                                            class="w-20 h-20 mb-4 opacity-80">
                                        <p class="text-gray-700 text-lg font-medium text-center">
                                            Nothing on the radar yet
                                        </p>
                                    </div>
                                </div>
                            @endfor
                        @else
                            @foreach($events as $event)
                                <div class="overflow-hidden bg-secondary-dark rounded-lg shadow hover:shadow-lg transition">
                                    <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}"
                                        class="w-full h-48 object-cover">
                                    <div class="p-4 space-y-2">
                                        <h4 class="text-2xl font-bold text-white">{{ $event->title }}</h4>
                                        <p class="text-base text-gray-300">{{ Str::limit($event->description, 80) }}</p>

                                        <div class="flex items-center text-sm text-gray-400 gap-2">
                                            <img src="{{ asset('assets/images/icon/calendar.svg') }}" alt="Calendar">
                                            {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                            &nbsp;|&nbsp;
                                            <img src="{{ asset('assets/images/icon/clock.svg') }}" alt="Clock">
                                            {{ $event->timing }}
                                        </div>

                                        <div class="text-sm flex gap-2 text-gray-400">
                                            <img src="{{ asset('assets/images/icon/location.svg') }}" alt="Location">
                                            {{ $event->location }}
                                        </div>

                                        <a href="{{ route('user.event.details', $event->id) }}"
                                            class="inline-block mt-3 px-4 py-2 bg-primary-color text-white text-sm rounded-full hover:bg-blue-700 transition">
                                            View Details →
                                        </a>

                                        <a href="{{ Str::startsWith($event->link, ['http://', 'https://']) ? $event->link : 'https://' . $event->link }}"
                                            target="_blank"
                                            class="px-4 py-2 bg-gray-600 text-white text-sm rounded-full hover:bg-gray-700 transition">
                                            Visit Link ↗
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-3 mt-4">
                        <h2 class="font-bold md:text-3xl text-[20px] text-white">Organizations</h2>
                        <a href="{{ route('user.organizations.show') }}">
                            <button class="bg-primary-color text-white rounded-full py-2 px-4 hover:bg-blue-700 transition">
                                View all
                            </button>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        @if($organizations->isEmpty())
                            @for($i = 0; $i < 3; $i++)
                                <div class="overflow-hidden rounded-lg shadow-inner transition" style="background-color: #C5C5C5;">
                                    <div class="flex flex-col items-center justify-center h-80">
                                        <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Organization"
                                            class="w-20 h-20 mb-4 opacity-80">
                                        <p class="text-gray-700 text-lg font-medium text-center">
                                            Nothing on the radar yet
                                        </p>
                                    </div>
                                </div>
                            @endfor
                        @else
                            @foreach($organizations as $organization)
                                <div class="overflow-hidden bg-secondary-dark rounded-lg shadow hover:shadow-lg transition">
                                    <img src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }}"
                                        class="w-full h-48 object-cover">
                                    <div class="p-4 space-y-2">
                                        <h4 class="text-2xl font-bold text-white">{{ $organization->name }}</h4>
                                        <p class="text-base text-gray-300">
                                            {{ Str::limit(strip_tags($organization->description), 80) }}
                                        </p>

                                        <div class="text-sm flex gap-2 text-gray-400">
                                            <img src="{{ asset('assets/images/icon/organization.png') }}" alt="Type">
                                            {{ $organization->type }} • {{ $organization->sector }}
                                        </div>

                                        <a href="{{ route('user.organizations.details', $organization->id) }}"
                                            class="inline-block mt-3 px-4 py-2 bg-primary-color text-white text-sm rounded-full hover:bg-blue-700 transition">
                                            View Details →
                                        </a>

                                        <a href="{{ Str::startsWith($organization->link, ['http://', 'https://']) ? $organization->link : 'https://' . $organization->link }}"
                                            target="_blank"
                                            class="px-4 py-2 bg-gray-600 text-white text-sm rounded-full hover:bg-gray-700 transition">
                                            Visit Link ↗
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection