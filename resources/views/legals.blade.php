<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Airway Connect</title>

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
    @else
    <!-- style -->
    @endif
</head>

<body class="bg-primary-dark">
    {{-- Include Header --}}
    @include('layouts.header')
    <!-- hero banner start -->

    <section class="bg-secondary-color">

        <div class="h-[600px] flex items-center justify-center" style="background: url('assets/images/legalbg.svg');">

            <h1 class="text-3xl text-white md:text-5xl font-bold mb-8 text-center">{{ $title }}</h1>
        </div>
        <div class="px-6">
            <div class="container mx-auto ">
                <div class="prose legal-data prose-invert text-white py-[50px]  max-w-none">
                    {!! $content !!}
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
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