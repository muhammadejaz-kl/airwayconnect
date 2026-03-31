<x-guest-layout :title="'Reset Password'" :detail="'Enter your new password for ' . $email">
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.reset.post') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <x-input-label for="password" :value="__('New Password')" class="text-sm text-white" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm text-white" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center primary-button">
                {{ __('Reset Password') }}
            </x-primary-button>
            <p class="text-center w-full text-white mt-4">
                Remember Password? <a href="{{ route('login') }}" class="underline">Log in</a>
            </p>
        </div>
    </form>
</x-guest-layout>
