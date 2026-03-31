@extends('user.layout.user')

@section('content')
<div class="py-7 px-6">
    <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">
        <div class="text-gray-400 text-sm mb-4">
            <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
            <i class="pi pi-chevron-right text-sm"></i>
            <a href="{{ route('user.airlineDirectory.index') }}" class="hover:text-white text-lg">Airlines Directory</a>
            <i class="pi pi-chevron-right text-sm"></i>
            <span class="text-gray-200 text-lg">{{ $airline->name }}</span>
        </div>

        <div class="bg-secondary-color flex flex-col gap-3 p-5 rounded-lg">
            <div class="bg-primary-dark overflow-hidden rounded-lg">
                <div class="bg-primary-color p-2"></div>
                <div class="p-5">
                    <div class="flex items-center space-x-5">
                        <img src="{{ asset('storage/'.$airline->logo) }}"
                            alt="{{ $airline->name }}"
                            class="w-[93px] h-[93px] rounded-full border">
                        <span class="text-3xl text-white">{{ $airline->name }}</span>
                    </div>

                    @if($airline->details->isNotEmpty())
                    @php $detail = $airline->details->first(); @endphp
                    <div class="grid mt-4 text-white md:grid-cols-2 lg:grid-cols-6">
                        <div class="border-r px-4 ps-0">
                            <p>Part:</p>
                            <p class="text-2xl">{{ $detail->part ?? 'N/A' }}</p>
                        </div>
                        <div class="border-r px-4">
                            <p>Airline Type:</p>
                            <p class="text-2xl">{{ $detail->airlines_type ?? 'N/A' }}</p>
                        </div>
                        <div class="border-r px-4">
                            <p>Job Type:</p>
                            <p class="text-2xl">{{ $detail->job_type ?? 'N/A' }}</p>
                        </div>
                        <div class="border-r px-4">
                            <p>Schedule Type:</p>
                            <p class="text-2xl">{{ $detail->schedule_type ?? 'N/A' }}</p>
                        </div>
                        <div class="border-r px-4">
                            <p>401k Option:</p>
                            <p class="text-2xl">{{ $detail->option_401k ?? 'N/A' }}</p>
                        </div>
                        <div class="px-4 pr-0">
                            <p>Flight Benefits:</p>
                            <p class="text-2xl">{{ $detail->flight_benefits ?? 'N/A' }}</p>
                        </div>
                    </div>
 
                    <div class="mt-4">
                        <span class="text-lg text-white font-semibold">Description: </span>
                        <span class="text-lg text-white max-w-full break-all  ">
                            {!! $detail->description ?? 'No description available.' !!}
                        </span>
                    </div>

                    @else
                    <p class="text-white mt-4">No details available for this airline.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection