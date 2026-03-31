@extends('user.layout.user')

@section('content')
    <div class="py-10 px-6">
        <div class="mx-auto w-full md:max-w-7xl">

            <div class="text-gray-400 text-sm mb-4">
                <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <a href="{{ route('user.resource.index') }}" class="hover:text-white text-lg">Resource Library, Events &
                    Organizations</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <span class="text-gray-200 text-lg">All Organizations</span>
            </div>

            <h1 class="text-3xl font-bold text-white mb-6">All Organizations</h1>

            @php
                $orgCount = $organizations->count();
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($orgCount > 0)
                    @foreach($organizations as $organization)
                        <div class="bg-secondary-color rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                            <a href="{{ route('user.organizations.details', $organization->id) }}">
                                <img src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }}"
                                    class="w-full h-52 object-cover">
                            </a>
                            <div class="p-4 space-y-2">
                                <h2 class="text-xl font-bold text-white">
                                    {{ $organization->name }}
                                </h2>
                                <p class="text-sm text-gray-300">
                                    {!! Str::limit(strip_tags($organization->description), 100) !!}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $organization->type }} • {{ $organization->sector }}
                                </p>
                                <a href="{{ route('user.organizations.details', $organization->id) }}"
                                    class="inline-block mt-3 bg-primary-color text-white text-sm rounded-full px-4 py-2 hover:bg-blue-700 transition">
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
                @else
                    @for($i = 0; $i < 3; $i++)
                        <div class="overflow-hidden rounded-lg shadow-inner transition" style="background-color: #C5C5C5;">
                            <div class="flex flex-col items-center justify-center h-80">
                                <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Organization"
                                    class="w-24 h-24 mb-4 opacity-80">
                                <p class="text-gray-700 text-lg font-medium text-center">
                                    Nothing on the radar yet
                                </p>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </div>
@endsection