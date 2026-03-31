<div class="flex flex-col py-8 items-center justify-center text-white">
    <h1 class="text-4xl text-white font-bold mb-3">How long have you been working?</h1>
    <p class="text-xl text-gray-400 mb-8">
        We'll find the best templates for your experience level.
    </p>

    <div class="w-full max-w-xs flex flex-col gap-4" id="experienceButtons">
        @php
            $options = [
                'No Experience',
                'Less Than 3 Years',
                '3-5 Years',
                '5-10 Years',
                '10+ Years'
            ];
        @endphp

        @foreach ($options as $option)
            <button 
                type="button"
                class="p-4 text-lg rounded-lg font-medium transition-colors 
                       bg-secondary-color text-gray-300"
                data-value="{{ $option }}">
                {{ $option }}
            </button>
        @endforeach
    </div>
</div>

<script>
    const buttons = document.querySelectorAll('#experienceButtons button');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            buttons.forEach(btn => {
                btn.classList.remove('bg-primary-color', 'text-white');
                btn.classList.add('bg-secondary-color', 'text-gray-300');
            });

            button.classList.remove('bg-secondary-color', 'text-gray-300');
            button.classList.add('bg-primary-color', 'text-white');

            fetch("{{ route('user.resume.saveExperienceLevelSession') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ experience_level: button.dataset.value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    console.log("Saved to session:", data.experience_level);
                }
            })
            .catch(err => console.error(err));
        });
    });
</script>
