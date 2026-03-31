@extends('user.layout.user')

@section('content')
    <div class="py-7 px-6">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">
            <div class="text-gray-400 text-sm mb-4">
                <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <span class="text-gray-200 text-lg">Organizations</span>
            </div>

            <div class="p-5 py-7 rounded-lg rounded-b-none h-[411px] flex flex-col justify-end" style="background: url('{{ asset('assets/images/organization.jpg') }}');
                       background-size: cover;
                       background-position:center;">
                <h1 class="text-3xl font-bold mb-2 text-white">Organizations</h1>
                <p class="text-sm text-white">
                    Explore partner organizations contributing to innovation, growth, and collaboration.
                </p>
            </div>

            <div class="bg-secondary-color flex flex-col gap-3 md:p-5 p-4 rounded-lg rounded-t-none">
                <div class="flex items-center gap-3 justify-between">
                    <h2 class="font-bold md:text-3xl text-[20px] text-white">Our Partners</h2>
                    <a href="{{ route('user.organizations.show') }}">
                        <button class="bg-primary-color text-white rounded-full py-2 px-3 md:w-auto w-[100px]">
                            View all
                        </button>
                    </a>

                </div>

                @forelse($organizations as $organization)
                    <a href="{{ route('user.organizations.details', $organization->id) }}" class="block">
                        <div class="relative rounded-lg overflow-hidden mt-4 h-[334px] hover:opacity-90 transition">
                            <img src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }}"
                                class="object-cover w-full h-full">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent p-6 flex flex-col justify-end">
                                <h2 class="text-3xl font-semibold text-white">
                                    {{ $organization->name }}
                                </h2>
                                <p class="text-base text-gray-300">
                                    {!! Str::limit($organization->description, 120) !!}
                                </p>
                                <p class="text-sm text-gray-400 mt-1">
                                    {{ $organization->type }} • {{ $organization->sector }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-400 text-lg col-span-full text-center py-10">No organizations found.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection