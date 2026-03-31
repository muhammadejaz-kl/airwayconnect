@extends('user.layout.user')

@section('content')
    <div class="py-7" x-data="{
                            isEditingName: false,
                            isEditingPhone: false,
                            isEditingEmail: false,
                            name: '{{ Auth::user()->name }}',
                            phone_code: '{{ Auth::user()->phone_code ?? '' }}',
                            phone_number: '{{ Auth::user()->phone_number ?? '' }}',
                            email: '{{ Auth::user()->email }}',

                            original: {
                                name: '{{ Auth::user()->name }}',
                                phone_code: '{{ Auth::user()->phone_code ?? '' }}',
                                phone_number: '{{ Auth::user()->phone_number ?? '' }}',
                                email: '{{ Auth::user()->email }}',
                            },

                            profileImage: null,
                            coverImage: null,

                            hasChanges() {
                                return this.name !== this.original.name ||
                                       this.phone_code !== this.original.phone_code ||
                                       this.phone_number !== this.original.phone_number ||
                                       this.email !== this.original.email ||
                                       this.profileImage !== null ||
                                       this.coverImage !== null;
                            },

                            chooseProfileImage() {
                                this.$refs.profileInput.click();
                            },

                            chooseCoverImage() {
                                this.$refs.coverInput.click();
                            },

                            previewProfile(e) {
                                this.profileImage = e.target.files[0];
                            },

                            previewCover(e) {
                                this.coverImage = e.target.files[0];
                            },

                            cancelProfile() {
                                this.profileImage = null;
                                this.$refs.profileInput.value = '';
                            },

                            cancelCover() {
                                this.coverImage = null;
                                this.$refs.coverInput.value = '';
                            },

                            updateForm(refName) {
                            const form = this.$refs[refName].closest('form');
                            showPreloader();
                            form.submit();
                        }

                        }">

        <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">
            <form id="profileForm" method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="profile_image" x-ref="profileInput" class="hidden"
                    @change="previewProfile($event)">
                <input type="file" name="cover_image" x-ref="coverInput" class="hidden" @change="previewCover($event)">

                <div class="bg-secondary-color text-white rounded-lg overflow-hidden">
                    <div class="flex justify-between items-center px-5 py-4">
                        <h2 class="text-2xl text-white">Manage Profile</h2>
                    </div>

                    <!-- Cover Image -->
                    <!-- <div class="relative w-full h-60">
                                        <img :src="coverImage ? URL.createObjectURL(coverImage) : '{{ Auth::user()->cover_image ? asset('storage/' . Auth::user()->cover_image) : asset('assets/images/default-cover.jpg') }}'"
                                            alt="Cover Image"
                                            class="w-full h-full object-cover">

                                        <div class="absolute bottom-2 right-2 flex items-center gap-2">
                                            <div class="cursor-pointer shadow-md d-flex justify-center align-center bg-blue-600 p-2 rounded-full"
                                                @click="chooseCoverImage()">
                                                <i class="pi pi-pencil text-white text-sm"></i>
                                            </div>
                                            <template x-if="coverImage">
                                                <div class="flex gap-2">
                                                    <div class="cursor-pointer shadow-md d-flex justify-center align-center bg-green-600 p-2 rounded-full"
                                                        @click="updateForm('coverInput')">
                                                        <i class="pi pi-check text-white text-sm"></i>
                                                    </div>
                                                    <div class="cursor-pointer shadow-md d-flex justify-center align-center bg-red-600 p-2 rounded-full"
                                                        @click="cancelCover()">
                                                        <i class="pi pi-times text-white text-sm"></i>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div> -->

                    <!-- Profile Info -->
                    <div class="relative z-10 mt-6 px-6">
                        <div
                            class="bg-primary-dark rounded-lg p-6 flex flex-wrap gap-8 items-center space-y-10 md:space-y-0 md:space-x-20 shadow-lg relative">

                            <!-- Profile Image -->
                            <div class="relative w-[10rem] h-[10rem]">
                                <img :src="profileImage ? URL.createObjectURL(profileImage) : '{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('admin/assets/img/profiles/avatar-01.png') }}'"
                                    alt="Profile"
                                    class="w-full h-full rounded-full object-cover border-4 border-white shadow-md" />

                                <!-- Action Buttons -->
                                <div class="absolute bottom-1 right-1 flex gap-1">
                                    <!-- Pencil -->
                                    <div class="bg-blue-600 p-1 w-[30px] h-[30px] flex items-center justify-center rounded-full cursor-pointer shadow-md"
                                        @click="chooseProfileImage()">
                                        <i class="pi pi-pencil text-white text-xs"></i>
                                    </div>

                                    <template x-if="profileImage">
                                        <div class="flex gap-1">
                                            <div class="bg-green-600 p-1 w-[30px] h-[30px] flex items-center justify-center rounded-full cursor-pointer shadow-md"
                                                @click="updateForm('profileInput')">
                                                <i class="pi pi-check text-white text-xs"></i>
                                            </div>
                                            <div class="bg-red-600 p-1 w-[30px] h-[30px] flex items-center justify-center rounded-full cursor-pointer shadow-md"
                                                @click="cancelProfile()">
                                                <i class="pi pi-times text-white text-xs"></i>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="grid w-full md:w-auto grid-cols-1 md:grid-cols-3 gap-4 md:gap-12 text-sm m-0">

                                <!-- Name -->
                                <div>
                                    <p class="text-gray-400">Name</p>

                                    <div class="flex items-center space-x-2" x-show="!isEditingName">
                                        <p x-text="name"></p>
                                        <i class="pi pi-pencil text-blue-500 text-xs cursor-pointer"
                                            @click="isEditingName = true"></i>
                                    </div>

                                    <div class="flex items-center space-x-2" x-show="isEditingName" x-transition>
                                        <input type="text" name="name" x-model="name"
                                            class="bg-gray-700 border text-white px-2 py-1 rounded" x-ref="nameField" />

                                        <i class="pi pi-check text-green-500 text-lg cursor-pointer"
                                            @click="updateForm('nameField')"></i>

                                        <i class="pi pi-times text-red-500 text-lg cursor-pointer"
                                            @click="isEditingName = false"></i>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-gray-400">Phone number</p>
                                    <p>
                                        <span>{{ Auth::user()->phone_code ?? '' }}</span>
                                        <span>{{ Auth::user()->phone_number ?? 'N/A' }}</span>
                                    </p>
                                </div>

                                <div>
                                    <p class="text-gray-400">Email</p>
                                    <p>{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <h3 class="text-2xl my-6 text-white px-6">Change Password</h3>
                    <div class="bg-primary-dark rounded-lg mx-6 mb-6 p-6">
                        @include('user.profile.partials.update-password-form')
                    </div>

                    <div class="flex justify-between items-center px-6 mt-6">
                        <h3 class="text-2xl text-white">Your Subscription</h3>

                        <a href="{{ route('user.premium.index') }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-semibold">
                            View Plans
                        </a>
                    </div>

                    <div class="mx-6 mt-4 mb-6">
                        <div class="bg-primary-dark rounded-lg p-6 flex justify-between items-center text-white shadow-md">
                            @if($subscription)
                                <div>
                                    <p class="text-lg font-semibold">{{ $subscription->name }}</p>
                                    <p class="text-xl font-bold mt-1">${{ number_format($subscription->amount, 2) }}/month</p>
                                    <p class="text-sm text-gray-400 mt-1">Single user Plan</p>
                                </div>
                                <div class="text-sm text-gray-400">
                                    Renews
                                    {{ $user->premium_end_date ? \Carbon\Carbon::parse($user->premium_end_date)->format('d M Y') : 'N/A' }}
                                </div>
                            @else
                                <div>
                                    <p class="text-lg font-semibold">Default User Plan</p>
                                    <p class="text-xl font-bold mt-1">$0.00/month</p>
                                    <p class="text-sm text-gray-400 mt-1">1 included user</p>
                                </div>
                                <div class="text-sm text-gray-400">
                                    Lifetime
                                </div>
                            @endif
                        </div>
                    </div>



                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('submit', function (e) {
            if (e.target.tagName === 'FORM') {
                showPreloader();
            }
        });
    </script>

@endpush