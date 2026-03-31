@extends('user.layout.user')
@section('content')
    <div class="py-7 px-6">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

            <div class="text-gray-400 text-sm mb-4">
                <a href="#" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm"></i>

                <a href="{{ route('user.resource.index') }}" class="hover:text-white text-lg">Resource Library & Events</a>
                <i class="pi pi-chevron-right text-sm"></i>

                <span class="text-gray-200 text-lg">Upcoming Events</span>
            </div>

            <div class="p-5 py-7 rounded-lg rounded-b-none h-[411px] flex flex-col justify-end"
                style="background: url('{{ asset('assets/images/forumimg.svg') }}'); background-size: cover; background-position: center;">
                <h1 class="text-3xl font-bold mb-2 text-white">Upcoming Events</h1>
                <p class="text-sm text-white">
                    Explore a curated collection of guides, templates, tools, and learning materials designed to support
                    your journey.
                </p>
            </div>

            <div class="bg-secondary-color flex flex-col gap-3 p-5 rounded-lg rounded-t-none">
                <div class="flex items-center gap-3 justify-between">
                    <h2 class="font-bold text-3xl text-white">Events</h2>
                </div>

                <div class="mt-8">
                    @if($events->isEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @for($i = 0; $i < 3; $i++)
                                <div class="overflow-hidden rounded-lg shadow-inner transition" style="background-color: #C5C5C5;">
                                    <div class="flex flex-col items-center justify-center h-80">
                                        <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Event"
                                            class="w-24 h-24 mb-4 opacity-80">
                                        <p class="text-gray-700 text-lg font-medium text-center">
                                            Nothing on the radar yet
                                        </p>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($events as $event)
                                <div class="overflow-hidden bg-secondary-dark rounded-lg shadow hover:shadow-lg transition">
                                    <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->title }}"
                                        class="w-full h-48 object-cover">

                                    <div class="p-4 space-y-2">
                                        <h4 class="text-2xl font-bold text-white">{{ $event->title }}</h4>
                                        <p class="text-base text-gray-300">
                                            {{ Str::limit($event->description, 80) }}
                                        </p>

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
                                            class="mt-2 inline-block px-4 py-2 bg-primary-color text-white text-sm rounded-full hover:bg-blue-700">
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
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection