<!-- Step 1 (Contact Details) -->
<form id="step1" class="step-form" method="POST" action="{{ route('user.resume.store') }}">
    @csrf
    <h2 class="text-3xl text-white font-bold mb-2" id="formTitle">Kindly confirm your contact details.</h2>
    <p class="text-white text-xl mb-6" id="formDesc">
        Employers might reach out by phone or email, so ensure your information is current.
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-4">
        <!-- First Name -->
        <div class="col-span-12 lg:col-span-6">
            <label class="text-sm">First Name <span class="text-red-600">*</span></label>
            <input type="text" name="first_name" class="w-full px-3 py-2 rounded-lg bg-secondary-color" placeholder="Enter Your First Name">
        </div>

        <!-- Surname -->
        <div class="col-span-12 lg:col-span-6">
            <label class="text-sm">Surname <span class="text-red-600">*</span></label>
            <input type="text" name="surname" class="w-full px-3 py-2 rounded-lg bg-secondary-color" placeholder="Enter Your Surname">
        </div>

        <!-- Phone -->
        <div class="col-span-12 lg:col-span-6">
            <label class="text-sm">Phone <span class="text-red-600">*</span></label>
            <input type="text" name="phone" class="w-full px-3 py-2 rounded-lg bg-secondary-color" placeholder="Enter Your Phone Number">
        </div>

        <!-- Email -->
        <div class="col-span-12 lg:col-span-6">
            <label class="text-sm">Email <span class="text-red-600">*</span></label>
            <input type="email" name="email" class="w-full px-3 py-2 rounded-lg bg-secondary-color" placeholder="Enter Your Email">
        </div>

        <!-- Date of Birth -->
        <div class="col-span-12 lg:col-span-6">
            <label class="text-sm">Date of Birth <span class="text-red-600">*</span></label>
            <input type="date" name="date_of_birth" class="w-full px-3 py-2 rounded-lg bg-secondary-color">
        </div>

        <!-- Nationality -->
        <div class="col-span-12 lg:col-span-6">
            <label class="text-sm">Nationality <span class="text-red-600">*</span></label>
            <input type="text" name="nationality" placeholder="e.g Indian" class="w-full px-3 py-2 rounded-lg bg-secondary-color">
        </div>

        <!-- Residential Address -->
        <div class="col-span-12">
            <label class="text-sm">Residential Address <span class="text-red-600">*</span></label>
            <input type="text" name="residential_address" class="w-full px-3 py-2 rounded-lg bg-secondary-color" placeholder="Enter Your Complete Address">
        </div>
    </div>

    <!-- Licensed / Unlicensed -->
    <div class="flex items-center space-x-6 mb-4">
        <label class="flex items-center space-x-2">
            <input type="radio" class="radio-btn" name="is_licensed" value="1">
            <span class="text-sm">Licensed</span>
        </label>
        <label class="flex items-center space-x-2">
            <input type="radio" class="radio-btn" name="is_licensed" value="0" checked>
            <span class="text-sm">Unlicensed</span>
        </label>
    </div>

    <!-- License No., Hobbies, Language -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <!-- License No -->
        <div>
            <label class="text-sm">License No.</label>
            <input id="licenseNo" type="text" name="license_no"
                placeholder="Enter License No."
                class="w-full px-3 py-2 rounded-lg bg-secondary-color"
                disabled>
        </div>

        <!-- Hobbies -->
        <div>
            <label class="text-sm">Hobbies</label>
            <input type="text" placeholder="Hobbies" name="hobbies" class="w-full px-3 py-2 rounded-lg bg-secondary-color">
        </div>

        <!-- Language (fixed UI to match others) -->
        <div>
            <label class="text-sm">Language <span class="text-red-600">*</span></label>
            <input type="text" placeholder="e.g English, Hindi" name="language" class="w-full px-3 py-2 rounded-lg bg-secondary-color">
        </div>
    </div>

    <!-- Marital Status -->
    <div class="mb-4">
        <label class="text-sm">Marital Status</label>
        <div class="flex items-center space-x-4 mt-2">
            <label class="flex items-center space-x-2">
                <input type="radio" class="radio-btn" name="marital_status" value="Single"> <span>Single</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="radio" class="radio-btn" name="marital_status" value="Married"> <span>Married</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="radio" class="radio-btn" name="marital_status" value="Divorced" > <span>Divorced</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="radio" class="radio-btn" name="marital_status" value="Widowed" > <span>Widowed</span>
            </label>
        </div>
    </div>
</form>

<script>
    document.querySelectorAll('input[name="is_licensed"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const licenseInput = document.getElementById('licenseNo');
            if (this.value === '1') { // licensed
                licenseInput.disabled = false;
            } else {
                licenseInput.disabled = true;
                licenseInput.value = '';
            }
        });
    });
</script>
