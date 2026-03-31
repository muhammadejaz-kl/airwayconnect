@props(['title' => '', 'detail' => '', 'showIcon' => false])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Airway Connect</title>
    <link rel="shortcut icon" href="{{ asset('admin/assets/img/favicons.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="grid bg-primary-dark lg:grid-cols-2 min-h-screen flex-col sm:justify-center sm:pt-0 guest-layout">
<header class="bg-transparent absolute header shadow-sm p-6 w-full">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo">
            </a>
        </div>

    </div>
</header>
        {{-- Left Content Section --}}
        <div class="flex left-content flex-col justify-center lg:min-h-screen"
            style="background-image: url('{{ asset('assets/images/guest-login.svg') }}');
                    background-size: cover;
                    background-position: center;">
            <h2 class="text-4xl font-bold text-white">
                Your Aviation Career Starts Here
            </h2>
            <p class="text-xl text-white my-4">
                Airway Connect is your all-in-one hub for aspiring and active flight dispatchers.
                Access training tools, resume builder, interview prep, airline directory, and industry forums—
                all in one place
            </p>
        </div>

        {{-- Right Content Section --}}
        <div class="flex p-3 auth-form flex-col items-center justify-center"
            style="background: url('{{ asset('assets/images/plane-bg.svg') }}');background-repeat: no-repeat;background-position: center bottom;background-size: contain; ">
            <div class="shadow-md bg-secondary-color p-8 w-full sm:max-w-md rounded-lg text-center">
                @isset($showIcon)
                @if($showIcon)
                <img src="{{ asset('assets/images/icon/confirm-check.svg') }}" alt="" class="mx-auto" />
                @endif
                @endisset
                @isset($title)
                <h2 class="text-3xl text-white text-center font-bold">{{ $title }}</h2>
                @endisset

                @isset($detail)
                <p class="text-center text-white text-lg my-5">{{ $detail }}</p>
                @endisset

                {{-- Page Content --}}
                <!-- @yield('guest-content') -->
                {{ $slot }}
            </div>
        </div>
    </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</body>

</html>