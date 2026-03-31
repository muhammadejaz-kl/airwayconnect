@extends('user.layout.user')
@section('content')

    <div class="py-7 px-6">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <div class="text-gray-400 text-sm mb-4">
                <a href="{{ route('user.resource.index') }}" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm"></i>

                <a href="{{ route('user.resource.index') }}" class="hover:text-white text-lg">Resource Library & Events</a>
                <i class="pi pi-chevron-right text-sm"></i>

                <a href="{{ route('user.event.show') }}" class="hover:text-white text-lg">Upcoming Events</a>
                <i class="pi pi-chevron-right text-sm"></i>

                <span class="text-gray-200 text-lg">{{ $event->title }}</span>
            </div>

            <!-- Header Section -->
            <div class="p-5 py-7 rounded-lg rounded-b-none h-[411px] flex flex-col justify-end"
                style="background: url('{{ asset('storage/' . $event->banner) }}'); background-size: cover; background-position:center">
                <h1 class="text-3xl font-bold mb-2 text-white">{{ $event->title }}</h1>
                <p class="text-sm text-white">
                    {{ $event->description ?? '' }}
                </p>
                <p class="text-sm text-gray-400 mt-2 italic" target="_blank">
                    Visit Link ↗ : {{ $event->link }}
                </p>
            </div>

            <!-- Event Details -->
            <div class="bg-secondary-color flex flex-col gap-3 p-5 rounded-lg rounded-t-none">
                <div class="flex items-center gap-3 justify-between">
                    <div class="flex gap-3 items-center">
                        <div class="bg-primary-dark flex items-center gap-2 p-2 rounded-lg">
                            <img src="{{ asset('assets/images/icon/calendar.svg') }}" class="w-6 h-6" alt="Calendar">
                            <span
                                class="text-white text-xl">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</span>
                        </div>
                        <div class="bg-primary-dark flex items-center gap-2 p-2 rounded-lg">
                            <img src="{{ asset('assets/images/icon/clock.svg') }}" class="w-6 h-6" alt="Clock">
                            <span class="text-white text-xl">{{ $event->timing }}</span>
                        </div>
                    </div>
                    <div class="bg-primary-dark flex items-center gap-2 p-2 rounded-lg">
                        <img src="{{ asset('assets/images/icon/location.svg') }}" class="w-6 h-6" alt="Location">
                        <span class="text-white text-xl">{{ $event->location }}</span>
                    </div>
                </div>

                <!-- About the Event -->
                <div class="mt-3 text-white">
                    <h2 class="text-3xl text-white font-bold">About the Event</h2>
                    <p class="text-2xl mt-3">{!! $event->about !!}</p>
                </div>
            </div>
        </div>
    </div>

@endsection