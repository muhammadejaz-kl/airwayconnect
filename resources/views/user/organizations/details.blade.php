@extends('user.layout.user')

@section('content')
    <div class="py-7 px-6">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

            <div class="text-gray-400 text-sm mb-4">
                <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <a href="{{ route('user.resource.index') }}" class="hover:text-white text-lg">Resource Library, Events &
                    Organizations</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <a href="{{ route('user.organizations.show') }}" class="hover:text-white text-lg">All Organizations</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <span class="text-gray-200 text-lg">{{ $organization->name }}</span>
            </div>

            <div class="relative p-5 py-7 rounded-lg rounded-b-none h-[411px] flex flex-col justify-end"
                style="background: url('{{ asset('storage/' . $organization->logo) }}'); background-size: cover; background-position:center; background-repeat:no-repeat;">

                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent rounded-lg"></div>

                <div class="relative z-10">
                    <h1 class="text-3xl font-bold mb-2 text-white">{{ $organization->name }}</h1>
                    <p class="text-sm text-gray-300">
                        {{ $organization->type ?? 'N/A' }} • {{ $organization->sector ?? 'N/A' }}
                    </p>
                    <p class="text-sm text-gray-400 mt-2 italic">
                        Established:
                        {{ $organization->established ? \Carbon\Carbon::parse($organization->established)->format('d:M:Y') : 'N/A' }}
                    </p>

                    <p class="text-sm text-gray-400 mt-2 italic" target="_blank">
                        Visit Link ↗ : {{ $organization->link }}
                    </p>

                </div>
            </div>

            <div class="bg-secondary-color flex flex-col gap-6 p-5 rounded-lg rounded-t-none mt-0">

                @if($organization->purpose)
                    <div>
                        <h3 class="text-2xl font-semibold text-white mb-2">Purpose</h3>
                        <p class="text-gray-300 text-base leading-relaxed">
                            {{ $organization->purpose }}
                        </p>
                    </div>
                @endif

                <div>
                    <h2 class="font-bold text-3xl text-white mb-3">About</h2>
                    <div class="text-gray-300 text-base leading-relaxed">
                        @if($organization->description)
                            {!! $organization->description !!}
                        @else
                            <p>No description available.</p>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection