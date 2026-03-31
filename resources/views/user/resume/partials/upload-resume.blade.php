<div class="flex flex-col py-8 items-center justify-center text-white">
    <h1 class="text-4xl text-white font-bold mb-3">How do you want to upload your resume?</h1>
    <p class="text-xl text-gray-400 mb-8">
        We'll find the best templates for your experience level.
    </p>

    <!-- Drag & Drop Area -->
    <div
        id="dropArea"
        class="w-full max-w-2xl h-[300px] border-2 border-white rounded-lg flex flex-col items-center justify-center bg-secondary-color">
        <img src="{{ asset('assets/images/icon/upload-icon.svg') }}" alt="Avatar" class="mb-3">
        <p class="text-2xl mb-2" id="dropText">Drag and drop here</p>
        <label for="resume" id="browseLabel"
            class="cursor-pointer bg-primary-color px-6 py-3 rounded-full text-base hover:bg-blue-700 transition">
            Browse
        </label>
        <input type="file" id="resume" name="resume" class="hidden" accept=".doc,.docx,.pdf,.html,.rtf,.txt" />
    </div>

    <p class="mt-3 text-sm text-white text-start">File support:PDF Only</p>

    <div class="flex space-x-4 mt-10">
        <button id="uploadBackBtn"
            class="border text-base border-gray-300 min-w-[200px] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
            Back
        </button>

        <button id="uploadSkipBtn"
            class="border text-base bg-primary-color min-w-[200px] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
            Skip
        </button>

        <button id="uploadNextBtn"
            class="hidden bg-primary-color text-base min-w-[200px] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            Next
        </button>
    </div>

</div>