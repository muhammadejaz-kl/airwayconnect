@extends('admin.layouts.master')
@section('content')
<div class="py-7"  x-data="{ isEditingName: false, name: 'John Bride' }">
    <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

        <!-- Card -->
        <div class="bg-secondary-color text-white p-5 rounded-lg">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl text-white">Manage Profile</h2>
            </div>

            <!-- Profile Info -->
            <div class="bg-primary-dark rounded-lg mt-3 p-6 flex flex-wrap gap-8 items-center space-y-10 md:space-y-0 md:space-x-20">

                <!-- Avatar -->
                <div class="relative w-[10rem] h-[10rem]">
                    <img src="{{ asset('assets/images/avatarImg.svg') }}" alt="Profile"
                        class="w-full rounded-full object-cover" />
                    <div class="absolute bottom-1 right-1 bg-blue-600 p-1 w-[30px] h-[30px] flex items-center justify-center rounded-full cursor-pointer">
                        <i class="pi pi-pencil text-white text-xs"></i>
                    </div>
                </div>

                <!-- User Info -->
                <div class="grid w-full md:w-auto grid-cols-1 md:grid-cols-3 gap-4 md:gap-12 text-sm m-0">
                    <!-- Name -->
                    <div>
                        <p class="text-gray-400">Name</p>
                        <div class="flex items-center space-x-2" x-show="!isEditingName">
                            <p x-text="name"></p>
                            <i class="pi pi-pencil text-blue-500 text-xs cursor-pointer"
                                @click="isEditingName = true"></i>
                        </div>

                        <!-- Editable Input -->
                        <div class="flex items-center space-x-2" x-show="isEditingName">
                            <input type="text"
                                x-model="name"
                                class="bg-gray-700 border text-white px-2 py-1 rounded" />
                            <i class="pi pi-check text-green-500 text-lg cursor-pointer"
                                @click="isEditingName = false"></i>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div>
                        <p class="text-gray-400">Phone number</p>
                        <p>+156223213213</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <p class="text-gray-400">Email</p>
                        <p>john@gmail.com</p>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <h3 class="text-2xl my-4 text-white">Change password</h3>
            <div class="bg-primary-dark rounded-lg mt-3 p-6">
                @include('user.profile.partials.update-password-form')
            </div>
        </div>
    </div>
</div>
@endsection