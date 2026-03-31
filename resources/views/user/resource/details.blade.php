@extends('user.layout.user')

@section('content')
<div class="py-7 px-6">
    <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

        <div class="text-gray-400 text-sm mb-4">
            <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
            <i class="pi pi-chevron-right text-sm"></i>

            <a href="{{ route('user.resource.show') }}" class="hover:text-white text-lg">Resource Library & Events</a>
            <i class="pi pi-chevron-right text-sm"></i>

            <a href="{{ route('user.resource.show') }}" class="hover:text-white text-lg">All Resources</a>
            <i class="pi pi-chevron-right text-sm"></i>
            <span class="text-gray-200 text-lg">{{ $resource->title }}</span>
        </div>

        <div class="p-5 py-7 rounded-lg rounded-b-none h-[411px] flex flex-col justify-end"
            style="background: url('{{ asset('storage/' . $resource->banner) }}'); background-size: cover; background-position:center">
            <h1 class="text-3xl font-bold mb-2 text-white">{{ $resource->title }}</h1>
            <p class="text-sm text-white">{{ $resource->description }}</p>
        </div>
        <div class="bg-secondary-color flex flex-col gap-3 p-5 rounded-lg rounded-t-none">
            <div class="flex items-center gap-3 justify-between">
                <h2 class="font-bold text-3xl text-white">About</h2>
            </div>
            <div class="text-gray-300 text-base leading-relaxed">
                {!! $resource->about !!}
            </div>
        </div>

    </div>
</div>
@endsection