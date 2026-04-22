<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NNPNRSFM');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <title>Airway Connect</title>
    <link rel="shortcut icon" href="{{ asset('admin/assets/img/favicons.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{asset('admin/assets/css/custom.css')}}">

    @else
        <!-- style -->
    @endif
</head>

<body class="bg-primary-dark">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NNPNRSFM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    {{-- Include Header --}}
    @include('layouts.header')
    <!-- hero banner start -->
    <section class="h-[30rem] md:h-screen flex flex-col items-center justify-center text-white"
        style="background: url('{{ asset('assets/images/hero-banner.svg') }}') center center / cover no-repeat fixed;">
        <div class="w-full lg:w-8/12 p-2 text-center space-y-6 flex flex-col items-center justify-center">
            <h1 class="text-4xl md:text-6xl font-bold">
                Your Aviation Career Starts Here
            </h1>
            <p class="text-base md:text-2xl">
                Airway Connect is your all-in-one hub for aspiring and
                active flight dispatchers. Access training tools, resume
                builder, interview prep, airline directory, and industry
                forums—all in one place
            </p>
            <a href="{{ auth()->check() ? route('user.dashboard') : route('login') }}"
                class="flex justify-center mx-auto gap-2 items-center px-5 py-3 primary-button text-white rounded-lg hover:bg-blue-600 transition w-auto">
                Get Started <i class="pi pi-arrow-right"></i>
            </a>

        </div>
    </section>
    <!-- hero banner end -->
    <!-- carreer start -->
    <section class="px-6 py-12 md:py-20">
        <div class="container mx-auto">
            <div class="lg:w-7/12 m-auto text-center">
                <h2 class="text-3xl md:text-5xl font-bold text-white">
                    Elevate Your Dispatch Career
                </h2>
                <p class="text-white text-lg my-3">
                    Access everything you need to grow in the aviation
                    dispatch field—from building standout resumes to
                    connecting with airlines and industry peers
                </p>
            </div>

            @php
                $careerResources = [
                    [
                        'title' => 'Career Resources',
                        'description' =>
                            'Build dispatcher-ready resumes and prepare for interviews with role-specific tools and expert-clarified materials.',
                        'icon' => 'assets/images/icon/page.svg',
                    ],
                    [
                        'title' => 'Industry Insights',
                        'description' =>
                            'Discover detailed airline directories, hiring trends, and career pathways tailored for dispatchers.',
                        'icon' => 'assets/images/icon/industry.svg',
                    ],
                    [
                        'title' => 'Dispatcher Community',
                        'description' =>
                            'Join forums, connect with mentors, and engage with fellow dispatchers in a supportive professional network.',
                        'icon' => 'assets/images/icon/dispatch.svg',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
                @foreach ($careerResources as $resource)
                    <div class="bg-secondary-color text-center text-white career-card rounded-lg p-6">
                        <div class="bg-dark-blue flex items-center justify-center icon-box p-2">
                            <img src="{{ asset($resource['icon']) }}" alt="{{ $resource['title'] }}" class="">
                        </div>
                        <h3 class="text-xl font-bold my-2">{{ $resource['title'] }}</h3>
                        <p class="">{{ $resource['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- career end -->
    <!-- resources start -->
    <section class="bg-primary-color px-6 py-12 md:py-20">
        <div class="container mx-auto">
            <div class="lg:w-7/12 m-auto text-center">
                <h2 class="text-3xl md:text-5xl font-bold text-white">
                    Everything You Need to Succeed
                </h2>
                <p class="text-white text-lg my-3">
                    Our all-in-one platform equips you with practical
                    tools and knowledge to navigate and thrive in the
                    dispatch profession
                </p>
            </div>

            @php
                $succeedResources = [
                    [
                        'title' => 'Resume Builder',
                        'description' =>
                            'Generate professional dispatcher resumes using guided templates and AI-assisted content',
                        'icon' => 'assets/images/icon/page.svg',
                        'route' => route('user.resume.index')
                    ],
                    [
                        'title' => 'Interview Preparation',
                        'description' =>
                            'Practice with dispatcher-specific Q&As and scenario-based study materials curated by industry experts',
                        'icon' => 'assets/images/icon/job.svg',
                        'route' => route('user.interview.index')
                    ],
                    [
                        'title' => 'Airlines Directory',
                        'description' =>
                            'Browse verified listings of Part 121 and 135 airlines with filters for state, certification, and status',
                        'icon' => 'assets/images/icon/page.svg',
                        'route' => route('user.airlineDirectory.index')
                    ],
                    [
                        'title' => 'Jobs',
                        'description' =>
                            'Stay updated with new dispatcher job openings and direct links to official applications',
                        'icon' => 'assets/images/icon/job.svg',
                        'route' => route('user.job.index')
                    ],
                    [
                        'title' => 'Resource Library',
                        'description' =>
                            'Access scholarships, aviation events, internship opportunities, and curated learning materials',
                        'icon' => 'assets/images/icon/book.svg',
                        'route' => route('user.resource.index')
                    ],
                    [
                        'title' => 'Community Forum',
                        'description' =>
                            'Engage in focused discussions, ask questions, and exchange advice with fellow dispatch professionals',
                        'icon' => 'assets/images/icon/chat.svg',
                        'route' => route('user.forum.index')
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
                @foreach ($succeedResources as $resource)
                    <div class="bg-secondary-color p-6 succeed-card rounded-lg  ">
                        <div class=" h-full flex flex-col justify-between">
                            <div class="">
                                <div class=" icon-box">
                                    <img src="{{ asset($resource['icon']) }}" alt="{{ $resource['title'] }}" class="">
                                </div>
                                <h3 class="text-2xl font-bold text-white my-3">{{ $resource['title'] }}</h3>
                                <p class="text-white mb-4">{{ $resource['description'] }}</p>
                            </div>
                            <a href="{{$resource['route']  }}" class="text-lg text-white flex items-center">
                                Learn more
                            </a>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </section>
    <!-- resources end -->
    <!-- work start -->
    <section class="bg-secondary-color px-6 py-12 md:py-20">
        <div class="container mx-auto">
            <div class="lg:w-7/12 m-auto text-center">
                <h2 class="text-3xl md:text-5xl font-bold text-white">
                    How AirwayConnect Works
                </h2>
                <p class="text-white text-lg my-3">
                    Get started in minutes. Use powerful tools designed
                    for dispatchers—and take control of your aviation
                    career.
                </p>
            </div>

            @php
                $workResources = [
                    [
                        'title' => 'Register for Free',
                        'description' =>
                            'Set up your profile in minutes with just your email—no credit card or commitment required',
                        'icon' => '1',
                    ],
                    [
                        'title' => 'Explore Our Tools',
                        'description' =>
                            'Access resume templates, interview prep, airline directories, and more—all built for future and active dispatchers',
                        'icon' => '2',
                    ],
                    [
                        'title' => 'Grow Your Career',
                        'description' =>
                            'Leverage resources, apply for jobs, and build industry connections to advance confidently in your dispatch journey.',
                        'icon' => '3',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
                @foreach ($workResources as $resource)
                    <div class="bg-secondary-color p-6 career-card ">
                        <div class=" h-full flex flex-col justify-between">
                            <div class="text-center">
                                <div class="bg-primary-color text-2xl text-white icon-box w-[76px] h-[76px]">
                                    {{ $resource['icon'] }}
                                </div>
                                <h3 class="text-2xl font-bold text-white my-3">
                                    {{ $resource['title'] }}
                                </h3>
                                <p class="text-white mb-4">{{ $resource['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- work end -->

    <!-- testimonial start -->
    <!-- <section class="bg-primary-color px-6 py-12 md:py-20">
        <div class="container mx-auto">

            <div class="lg:w-7/12 m-auto text-center">
                <h2 class="text-3xl md:text-5xl font-bold text-white">
                    What Our Customer are Saying
                </h2>
                <p class="text-white text-lg my-3">
                    Real feedback from dispatchers who’ve accelerated
                    their careers with AirwayConnect
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">

                @if ($testimonials->count() === 0)

                    @for ($i = 0; $i < 3; $i++)
                        <div class="overflow-hidden rounded-lg shadow-inner transition" style="background-color: #C5C5C5;">
                            <div class="flex flex-col items-center justify-center h-60">
                                <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Testimonial"
                                    class="w-20 h-20 mb-4 opacity-80">
                                <p class="text-gray-700 text-lg font-medium text-center">
                                    No feedback yet
                                </p>
                            </div>
                        </div>
                    @endfor

                @elseif ($testimonials->count() === 1)

                            @php $t = $testimonials->first(); @endphp

                            <div class="bg-white rounded-lg shadow p-6 space-y-4">
                                <p class="text-gray-700">{{ $t->description }}</p>

                                <div class="flex items-center gap-3">
                                    <img src="{{ $t->profile_image
                    ? asset('storage/' . $t->profile_image)
                    : asset('admin/assets/img/profiles/avatar-01.png') }}" class="w-12 h-12 rounded-full">

                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $t->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $t->role }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="pi pi-star {{ $i <= $t->rating ? 'text-golden-color' : 'text-gray-300' }}"></i>
                                    @endfor

                                    <span class="text-secondary-200 text-[15px]">{{ $t->rating }}</span>
                                </div>
                            </div>

                @else

                    @foreach ($testimonials as $t)
                            <div class="bg-white rounded-lg shadow p-6 space-y-4">

                                <p class="text-gray-700">{{ $t->description }}</p>

                                <div class="flex items-center gap-3">
                                    <img src="{{ $t->profile_image
                        ? asset('storage/' . $t->profile_image)
                        : asset('admin/assets/img/profiles/avatar-01.png') }}" class="w-12 h-12 rounded-full">
                                    <div>
                                        <h3 class="text-lg font-semibold">{{ $t->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $t->role }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="pi pi-star {{ $i <= $t->rating ? 'text-golden-color' : 'text-gray-300' }}"></i>
                                    @endfor

                                    <span class="text-secondary-200 text-[15px]">{{ $t->rating }}</span>
                                </div>

                            </div>
                    @endforeach

                @endif
            </div>

        </div>
    </section> -->

    <!-- testimonial end  -->

    <!-- faq start -->
    <section class="bg-secondary-color px-6 py-12 md:py-20">
        <div class="container mx-auto">
            <div class="lg:w-7/12 m-auto text-center">
                <h2 class="text-3xl md:text-5xl font-bold text-white">
                    Frequently Asked Questions
                </h2>
            </div>

            <div class="lg:w-9/12 m-auto mt-12" x-data="{ activeIndex: null }">
                @forelse ($faqs as $index => $faq)
                    <div class="accordion-items overflow-hidden border-b border-gray-100">
                        <button class="flex justify-between items-center w-full p-5 text-left"
                            @click="activeIndex === {{ $index }} ? activeIndex = null : activeIndex = {{ $index }}">
                            <span class="font-medium text-xl md:text-2xl text-white">
                                {{ $faq->question }}
                            </span>
                            <span class="ml-2 text-gray-500 text-sm icon-box"
                                :class="activeIndex === {{ $index }} ? 'bg-primary-color text-white' : 'bg-white text-primary-color'">
                                <i x-show="activeIndex === {{ $index }}" class="pi pi-times"></i>
                                <i x-show="activeIndex !== {{ $index }}" class="pi pi-plus"></i>
                            </span>
                        </button>

                        <div x-show="activeIndex === {{ $index }}" x-transition
                            class="px-4 pb-4 pt-0 ease-in-out overflow-hidden">
                            <p class="text-white">{{ $faq->answer }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-white mt-6">No FAQs available at the moment.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- faq end -->
    <section class="bg-secondary-color px-6 ">
        <div class="container mx-auto">
            <div
                class="z-2 relative bg-primary-color text-center p-6 rounded-2xl space-y-3 md:space-y-6 md:w-10/12 mx-auto footer-content-banner">
                <p class="text-2xl md:text-4xl font-bold text-white">
                    Ready to Advance Your Dispatch Career?
                </p>
                <p class="text-white">
                    It is a long established fact that a reader will be
                    distracted by the readable content of a page when
                </p>
                <a href="{{ auth()->check() ? route('user.dashboard') : route('login') }}"
                    class="inline-flex justify-center items-center gap-2 px-6 py-3 bg-white text-primary-color font-semibold rounded-md shadow hover:bg-gray-100 transition">
                    Get Started Free
                </a>
                <p class="text-white">
                    It is a long established fact that a reader will be
                    distracted
                </p>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Slick JS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper('.testimonial-swiper', {
                modules: [], // No module config in vanilla
                slidesPerView: 1,
                spaceBetween: 30,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.custom-next',
                    prevEl: '.custom-prev',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                },
            });
        });


    </script>

    {{-- Include Footer --}}

    @include('layouts.footer')
    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>