<x-guest-layout :title="'Verification Code'">
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form id="otpForm" method="POST" action="{{ route('register.verify.submit') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="code" id="otpFull">

        <div>
            <x-input-label :value="__('Enter 6-digit OTP')" class="text-sm text-white" />

            <div class="flex justify-between gap-2 mt-2">
                @for ($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1"
                        class="w-12 h-12 text-center border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-lg text-white bg-transparent"
                        inputmode="numeric" pattern="[0-9]*" autocomplete="one-time-code" data-otp-input />
                @endfor
            </div>

            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center primary-button">
                {{ __('Verify') }}
            </x-primary-button>
        </div>
    </form>

    @if ($errors->has('code'))
        <div class="mt-6 text-center">
            <form method="POST" action="{{ route('register.verify.resend') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="underline text-blue-500 hover:text-blue-700">
                    Re-send OTP
                </button>
            </form>

            <p class="mt-3">
                <a href="{{ route('register') }}" class="underline text-red-500 hover:text-red-700">
                    Enter another email
                </a>
            </p>
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll("[data-otp-input]");
            const hiddenInput = document.getElementById("otpFull");

            inputs.forEach((input, index) => {
                input.addEventListener("input", () => {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    updateHidden();
                });

                input.addEventListener("keydown", (e) => {
                    if (e.key === "Backspace" && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener("paste", (e) => {
                    e.preventDefault();
                    const pasted = (e.clipboardData || window.clipboardData).getData("text").trim();
                    if (/^\d+$/.test(pasted)) {
                        const chars = pasted.split("");
                        inputs.forEach((box, i) => {
                            box.value = chars[i] ?? "";
                        });
                        updateHidden();
                    }
                });
            });

            function updateHidden() {
                hiddenInput.value = Array.from(inputs).map(i => i.value).join("");
            }

            document.getElementById("otpForm").addEventListener("submit", () => {
                updateHidden();
            });
        });
    </script>

</x-guest-layout>