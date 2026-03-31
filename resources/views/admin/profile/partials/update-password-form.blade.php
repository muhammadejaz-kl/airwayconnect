<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div class="mb-4">
            <label for="current_password" class="block text-sm font-medium text-gray-300">Current Password</label>
            <input id="current_password" name="current_password" type="password" placeholder="Old password"
                class="mt-1 block w-full border rounded-md bg-gray-700 text-white" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-300">New Password</label>
            <input id="password" name="password" type="password"
                class="mt-1 block w-full border rounded-md bg-gray-700 text-white" placeholder="New password" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full border rounded-md bg-gray-700 text-white" placeholder="Confirm password" required>
        </div>
    </div>


    <button type="submit" class="bg-primary-color text-white px-4 py-2 rounded">Change Password </button>
</form>