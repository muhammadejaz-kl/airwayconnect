<x-guest-layout :title="'Register your account'">
    <form id="registerForm" class="text-start" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm text-white" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" placeholder="Enter Your Full Name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('User Name')" class="text-sm text-white" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" placeholder="Choose a unique username" :value="old('username')" required autocomplete="off" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-sm text-white" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="Enter Your Email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" class="text-sm text-white" />
            <input type="tel" id="phone" maxlength="15" class="w-full px-4 py-2 rounded-lg custom-number" placeholder="Enter phone number">
            
            <!-- Hidden fields -->
            <input type="hidden" name="phone_code" id="phone_code">
            <input type="hidden" name="phone_number" id="phone_number">
            
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>
        
        <!-- Job Title -->
        <div class="mt-4">
            <x-input-label for="job_title" :value="__('Job Title')" class="text-sm text-white" />
            <x-text-input id="job_title" class="block mt-1 w-full" type="text" name="job_title" placeholder="Enter Your Job Title" :value="old('job_title')" autocomplete="organization-title" />
            <x-input-error :messages="$errors->get('job_title')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" class="text-sm text-white" />
            <div class="relative">
                <input
                    id="password"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    placeholder="Create New Password"
                    required
                    autocomplete="new-password">
                <button type="button" @click="showPassword = !showPassword"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white focus:outline-none">
                    <i :class="showPassword ? 'pi pi-eye-slash' : 'pi pi-eye'" class="text-xl"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4" x-data="{ showConfirm: false }">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm text-white" />
            <div class="relative">
                <input
                    id="password_confirmation"
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    :type="showConfirm ? 'text' : 'password'"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    required
                    autocomplete="new-password">
                <button type="button" @click="showConfirm = !showConfirm"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white focus:outline-none">
                    <i :class="showConfirm ? 'pi pi-eye-slash' : 'pi pi-eye'" class="text-xl"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <div class="flex flex-col items-center justify-end mt-4">
            <x-primary-button class="w-full primary-button justify-center">
                {{ __('Create account') }}
            </x-primary-button>
            <p class="text-center w-full text-white mt-4">
                Already have an account?
                <a class="underline text-sm text-white" href="{{ route('login') }}">
                    {{ __('Login') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const input = document.querySelector("#phone");
        const form = document.querySelector("#registerForm");

        const iti = window.intlTelInput(input, {
            initialCountry: "us",
            geoIpLookup: function(success) {
                fetch('https://ipapi.co/json/')
                    .then(res => res.json())
                    .then(data => success(data.country_code))
                    .catch(() => success('us'));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });

        form.addEventListener("submit", function(e) {
            const countryData = iti.getSelectedCountryData();
            const rawNumber = input.value.replace(/\D/g, '');

            if (rawNumber.length > 15) {
                e.preventDefault();
                alert("Phone number cannot exceed 15 digits.");
                return;
            }

            document.getElementById('phone_code').value = countryData.dialCode;
            document.getElementById('phone_number').value = rawNumber;
        });
    });
</script>