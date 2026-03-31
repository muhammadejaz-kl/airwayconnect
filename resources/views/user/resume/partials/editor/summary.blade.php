<!-- Step 5 (Skills) -->
<form id="step5" class="step-form hidden" method="POST" action="{{ route('user.resume.store') }}">
    @csrf
    <h2 class="text-3xl text-white font-bold mb-2">
        Share a quick overview of your experience and background.
    </h2>

    <div class="mb-8">
        <h3 class="text-white text-3xl font-bold mb-4">Professional Summary <span class="text-red-600">*</span></h3>
        <textarea
            name="professional_summary"
            id="professional_summary"
            class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white min-h-[300px] resize-y"
            placeholder="Write a brief summary of your experience and background..."></textarea>
    </div>
</form>