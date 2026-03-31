@extends('user.layout.user')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet">

<style>
    .scenario-font {
        font-family: 'Courier Prime', monospace;
        letter-spacing: 0.6px;
    }
</style>

<div class="py-7 px-6">
    <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

        <div class="text-gray-400 text-sm mb-4">
            <a href="#" class="hover:text-white text-lg">Home</a>
            <i class="pi pi-chevron-right text-sm mx-1"></i>
            <span class="text-gray-200 text-lg">Interview Preparation</span>
        </div>

        <div class="bg-secondary-color flex flex-col gap-3 p-5 rounded-lg scenario-font">

            <h2 class="font-bold text-2xl text-white mb-5 scenario-font">
                Interview Preparation
            </h2>

            @if ($topics->count())

                <div class="flex flex-col gap-4">

                    @foreach ($topics as $topic)
                        <a href="{{ route('user.interview.show', $topic->id) }}"
                           class="flex items-center justify-between text-white text-lg hover:text-primary-color transition">

                            <div class="flex items-center gap-3">
                                <span class="text-xl">✈</span>
                                <span class="uppercase font-medium">
                                    {{ $topic->topic }}
                                </span>
                            </div>

                            <span class="text-gray-300">
                                [{{ $topic->questions_count ?? 0 }}]
                            </span>

                        </a>
                    @endforeach

                </div>

            @else

                <div class="bg-[#C5C5C5] rounded-lg flex flex-col items-center justify-center py-10 mt-6 shadow-inner">

                    <img src="{{ asset('assets/images/icon/empty-screen.png') }}"
                         alt="No Interview Topics"
                         class="w-28 h-28 mb-4 opacity-80">

                    <p class="text-gray-700 text-lg font-medium text-center">
                        No Interview Preparation found.
                    </p>
                </div>

            @endif

        </div>
    </div>
</div>

@endsection
