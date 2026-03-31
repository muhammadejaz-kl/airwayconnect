<x-guest-layout :title="'Verification Code'" detail="Enter the 6-digit verification code sent to s****@gmail.com">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="text-start" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="code" :value="__('Code')" class="text-sm text-white" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center primary-button">
                {{ __('Verify') }}
            </x-primary-button>
            <p class="text-center w-full text-white mt-4">
                Remember Password?  <a href="{{ route('login') }}" class="underline">Log in</a>
            </p>
        </div>
    </form>
</x-guest-layout>