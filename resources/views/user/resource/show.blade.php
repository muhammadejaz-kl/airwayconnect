@extends('user.layout.user')

@section('content')
    <div class="py-7 px-6">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

            <div class="text-gray-400 text-sm mb-4">
                <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <a href="{{ route('user.resource.index') }}" class="hover:text-white text-lg">Resource Library & Events</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <span class="text-gray-200 text-lg">All Resources</span>
            </div>

            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-bold md:text-3xl text-[20px] text-white">Resources</h2>
                </div>

                @forelse($resources as $resource)
                    <a href="{{ route('user.resource.details', $resource->id) }}" class="block">
                        <div class="relative rounded-lg overflow-hidden mt-4 h-[334px] hover:opacity-90 transition">
                            <img src="{{ asset('storage/' . $resource->banner) }}" alt="{{ $resource->title }}"
                                class="object-cover w-full h-full">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-6 flex flex-col justify-end">
                                <h2 class="text-3xl font-semibold text-white">{{ $resource->title }}</h2>
                                <p class="text-base text-gray-300">{{ Str::limit(strip_tags($resource->description), 150) }}</p>
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

        </div>
    </div>
@endsection