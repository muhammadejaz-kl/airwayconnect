<x-guest-layout :title="'Login to account'">

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="text-start" method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm text-white" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email"
                name="email"
                placeholder="Enter Your Email"
                :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" class="text-sm text-white" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    placeholder="Enter Your Password"
                    required autocomplete="current-password" />

                <span id="togglePassword" class="absolute inset-y-0 right-4 flex items-center cursor-pointer">
                    <i class="pi pi-eye text-primary-color" id="eyeIcon"></i>
                </span>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4 text-end">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-white no-underline" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
            @endif
        </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center primary-button">
                {{ __('Log in') }}
            </x-primary-button>
            <p class="text-center w-full text-white mt-4">
                Don't have an account? <a href="{{ route('register') }}" class="underline">Register</a>
            </p>
        </div>
    </form>
</x-guest-layout>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    window.$notification = function (message, type = 'success') {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: '3000'
        };
        toastr[type](message);
    };

    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            $notification("{{ session('success') }}", "success");
        @endif

        @if(session('error'))
            $notification("{{ session('error') }}", "error");
        @endif

        @if(session('warning'))
            $notification("{{ session('warning') }}", "warning");
        @endif

        @if(session('info'))
            $notification("{{ session('info') }}", "info");
        @endif
    });
</script>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.outerHTML = `<i class="pi pi-eye-slash text-primary-color" id="eyeIcon"></i>`;
        } else {
            passwordField.type = 'password';
            eyeIcon.outerHTML = `<i class="pi pi-eye text-primary-color" id="eyeIcon"></i>`;
        }
    });
</script>
