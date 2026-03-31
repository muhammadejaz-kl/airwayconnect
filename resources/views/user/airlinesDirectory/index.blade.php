@extends('user.layout.user')

@section('content')
    <div class="py-7 px-6">
        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">
            <div class="text-gray-400 text-sm mb-4">
                <a href="{{ url('/') }}" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm"></i>
                <span class="text-gray-200 text-lg">Airlines Directory</span>
            </div>

            <div class="bg-secondary-color flex flex-col gap-3 p-5 rounded-lg">
                <h2 class="font-bold text-2xl text-white mb-3">Airlines Directory</h2>
                <p class="text-lg text-white">
                    Our airline directory page offers a complete, well-organized list of all the airlines featured on our
                    website.
                    This directory serves as a valuable resource for anyone looking for information on airlines operating
                    around the world.
                </p>

                <div class="bg-primary-dark p-5 rounded-lg">
                    <h2 class="text-white mt-0 text-2xl">List of All Airlines</h2>

                    <div class="flex space-x-3 mt-3 overflow-auto no-scrollbar sticky top-0 z-10 bg-primary-dark py-2">
                        @foreach (range('A', 'Z') as $letter)
                            <a href="#section-{{ $letter }}" class="letter-link min-w-[39px] min-h-[39px] flex items-center justify-center rounded-full border border-gray-400 text-white 
                                    hover:bg-[#1E40AF] hover:border-[#1E40AF] transition">
                                {{ $letter }}
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        @php
                            $hasAirlines = false;
                        @endphp

                        @foreach (range('A', 'Z') as $letter)
                            @php
                                $airlinesByLetter = $airlines->filter(function ($airline) use ($letter) {
                                    return strtoupper(substr($airline->name, 0, 1)) === $letter;
                                });
                            @endphp

                            @if($airlinesByLetter->count() > 0)
                                @php $hasAirlines = true; @endphp
                                <div id="section-{{ $letter }}" class="mb-8 scroll-mt-24">
                                    <div class="bg-secondary-color p-3 rounded-lg mb-3">
                                        <span class="text-xl text-white font-semibold">{{ $letter }}</span>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                        @foreach ($airlinesByLetter as $airline)
                                            <a href="{{ route('user.airlineDirectory.show', $airline->id) }}">
                                                <div
                                                    class="flex items-center space-x-3 bg-secondary-color p-3 rounded-lg hover:bg-[#1E3A8A] transition">
                                                    <img src="{{ asset('storage/' . $airline->logo) }}"
                                                        class="w-[65px] h-[65px] rounded-full border object-cover"
                                                        alt="{{ $airline->name }}">
                                                    <span class="text-white font-medium">{{ $airline->name }}</span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if(!$hasAirlines)
                            <div
                                class="bg-[#C5C5C5] rounded-lg flex flex-col items-center justify-center py-10 mt-6 shadow-inner">
                                <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Airlines Found"
                                    class="w-28 h-28 mb-4 opacity-80">
                                <p class="text-gray-700 text-lg font-medium text-center">
                                    No Airlines Found.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sections = document.querySelectorAll("[id^='section-']");
            const links = document.querySelectorAll(".letter-link");

            function setActiveLetter() {
                let index = sections.length;

                while (--index && window.scrollY + 150 < sections[index].offsetTop) { }

                links.forEach(link => link.classList.remove("bg-[#1E40AF]", "border-[#1E40AF]"));
                if (links[index]) {
                    links[index].classList.add("bg-[#1E40AF]", "border-[#1E40AF]");
                }
            }

            setActiveLetter();
            window.addEventListener("scroll", setActiveLetter);

            links.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute("href").substring(1);
                    document.getElementById(targetId).scrollIntoView({
                        behavior: "smooth"
                    });
                });
            });
        });
    </script>
@endsection