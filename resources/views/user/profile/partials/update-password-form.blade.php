<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    <div x-data="passwordValidation()" class="grid grid-cols-1 md:grid-cols-3 gap-3">
        
        <!-- Current Password -->
        <div class="mb-4" x-data="{ show: false }">
            <label for="current_password" class="block text-sm font-medium text-gray-300">Current Password</label>
            <div class="relative">
                <input id="current_password" name="current_password" :type="show ? 'text' : 'password'"
                    placeholder="Old password"
                    class="mt-1 block w-full border rounded-md bg-gray-700 text-white pr-12"
                    x-model="currentPassword"
                    @input="checkCurrentPassword"
                    autocomplete="new-password"
                    autocorrect="off"
                    required
                    spellcheck="false">
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white focus:outline-none">
                    <i :class="show ? 'pi pi-eye-slash' : 'pi pi-eye'" class="text-xl"></i>
                </button>
            </div>
            <p x-show="currentPassword.length > 0"
                x-text="currentPasswordStatus"
                class="text-sm mt-1"
                :class="currentPasswordValid ? 'text-green-400' : 'text-red-400'"></p>
        </div>

        <!-- New Password -->
        <div class="mb-4" x-data="{ show: false }">
            <label for="password" class="block text-sm font-medium text-gray-300">New Password</label>
            <div class="relative">
                <input id="password" name="password" :type="show ? 'text' : 'password'"
                    class="mt-1 block w-full border rounded-md bg-gray-700 text-white pr-12"
                    placeholder="New password"
                    x-model="newPassword"
                    required
                    @input="validatePasswords">
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white focus:outline-none">
                    <i :class="show ? 'pi pi-eye-slash' : 'pi pi-eye'" class="text-xl"></i>
                </button>
            </div>
            <ul class="text-xs mt-2 space-y-1" x-show="newPassword.length > 0" x-transition>
                <li :class="hasUppercase ? 'text-green-400' : 'text-red-400'">• At least 1 uppercase letter</li>
                <li :class="hasNumber ? 'text-green-400' : 'text-red-400'">• At least 1 number</li>
                <li :class="hasSpecial ? 'text-green-400' : 'text-red-400'">• At least 1 special character</li>
                <li :class="newPassword !== currentPassword ? 'text-green-400' : 'text-red-400'">• Must be different from current password</li>
            </ul>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4" x-data="{ show: false }">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
            <div class="relative">
                <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'"
                    class="mt-1 block w-full border rounded-md bg-gray-700 text-white pr-12"
                    placeholder="Confirm password"
                    x-model="confirmPassword"
                    required    
                    @input="validatePasswords">
                <button type="button" @click="show = !show"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white focus:outline-none">
                    <i :class="show ? 'pi pi-eye-slash' : 'pi pi-eye'" class="text-xl"></i>
                </button>
            </div>
            <p x-show="confirmPassword.length > 0"
                x-text="confirmPasswordStatus"
                class="text-sm mt-1"
                :class="confirmPasswordValid ? 'text-green-400' : 'text-red-400'"></p>
        </div>
    </div>

    <button type="submit"
        class="bg-primary-color text-white px-4 py-2 rounded mt-4"
        :disabled="!isFormValid"
        :class="isFormValid ? 'opacity-100 cursor-pointer' : 'opacity-50 cursor-not-allowed'">
        Change Password
    </button>
</form>


<script>
    function passwordValidation() {
        return {
            currentPassword: '',
            newPassword: '',
            confirmPassword: '',
            currentPasswordValid: false,
            currentPasswordStatus: '',
            confirmPasswordValid: false,
            confirmPasswordStatus: '',
            isFormValid: false,

            hasUppercase: false,
            hasNumber: false,
            hasSpecial: false,

            checkCurrentPassword() {
                if (this.currentPassword.length > 0) {
                    fetch('{{ route('user.profile.check-password') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    current_password: this.currentPassword
                                })
                            })
                        .then(response => response.json())
                        .then(data => {
                            this.currentPasswordValid = data.valid;
                            this.currentPasswordStatus = data.valid ? 'Current password is correct' : 'Incorrect password';
                            this.validateForm();
                        });
                }
            },

            validatePasswords() {
                this.hasUppercase = /[A-Z]/.test(this.newPassword);
                this.hasNumber = /[0-9]/.test(this.newPassword);
                this.hasSpecial = /[^A-Za-z0-9]/.test(this.newPassword);

                this.confirmPasswordValid = this.newPassword === this.confirmPassword;
                this.confirmPasswordStatus = this.confirmPasswordValid ? 'Passwords match' : 'Passwords do not match';

                this.validateForm();
            },

            validateForm() {
                this.isFormValid =
                    this.currentPasswordValid &&
                    this.newPassword.length >= 8 &&
                    this.hasUppercase &&
                    this.hasNumber &&
                    this.hasSpecial &&
                    this.confirmPasswordValid &&
                    this.newPassword !== this.currentPassword;
            }
        }
    }
</script>