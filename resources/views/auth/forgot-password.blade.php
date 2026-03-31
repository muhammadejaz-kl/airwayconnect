<x-guest-layout :title="'Forgot password?'"  detail="Don't worry! It occurs. Please enter the email address linked with your account." >
  

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="text-start" method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm text-white" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="w-full primary-button justify-center">
                {{ __('Send Otp') }}
            </x-primary-button>
            <p class="text-center w-full text-white mt-4">
                Already have an account
                <a class="underline text-sm text-white" href="{{ route('login') }}">
                    {{ __('Login') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
