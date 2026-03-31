<!-- Step 4 (Skills) -->
<form id="step4" class="step-form hidden" method="POST" action="{{ route('user.resume.store') }}">
    @csrf
    <h2 class="text-3xl text-white font-bold mb-2">Which skills would you like to showcase?</h2>
    <p class="text-white text-xl mb-8">
        Select one of the sample options below or enter your own.
    </p>

    <!-- Skill Search -->
    <div class="mb-8 relative">
        <h3 class="text-white text-lg font-medium mb-4">Search by job title for Pre-written Examples</h3>
        <div class="relative">
            <input type="text" id="jobTitleSearch" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white"
                placeholder="Search by job title">

            <button type="button" id="clearSearch"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-white bg-red-600 px-2 py-1 rounded"
                style="display: none;">
                Clear
            </button>
        </div>

        <ul id="skillDropdown"
            class="w-full mt-2 bg-[#172A46] text-white rounded shadow hidden z-10 max-h-60 overflow-y-auto relative">
        </ul>

    </div>

    <div class="mb-8">
        <h3 class="text-white text-3xl font-bold mb-4">Skills <span class="text-red-600">*</span></h3>
        <div id="selectedSkills"
            class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white min-h-[100px] flex flex-col gap-2">

        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('jobTitleSearch');
        const dropdown = document.getElementById('skillDropdown');
        const selectedSkills = document.getElementById('selectedSkills');
        const clearBtn = document.getElementById('clearSearch');

        searchInput.addEventListener('input', () => {
            clearBtn.style.display = searchInput.value.trim() ? 'block' : 'none';
        });

        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            clearBtn.style.display = 'none';
            dropdown.classList.add('hidden');
            searchInput.focus();
        });

        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length < 2) {
                dropdown.classList.add('hidden');
                return;
            }

            fetch(`resume/search?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(skills => {
                    dropdown.innerHTML = '';
                    if (skills.length === 0) {
                        dropdown.classList.add('hidden');
                        return;
                    }

                    skills.forEach(skill => {
                        const li = document.createElement('li');
                        li.classList.add('px-4', 'py-2', 'hover:bg-[#2A4365]', 'cursor-pointer', 'flex', 'items-center', 'gap-2');
                        li.textContent = skill;

                        li.addEventListener('click', () => addSkill(skill));

                        dropdown.appendChild(li);
                    });

                    dropdown.classList.remove('hidden');
                });
        });

        function addSkill(skill) {
            const exists = Array.from(selectedSkills.children).some(el => el.dataset.skill === skill);
            if (exists) return;

            const div = document.createElement('div');
            div.dataset.skill = skill;
            div.className = 'flex items-center gap-2 cursor-pointer p-2 text-lg hover:bg-[#2A4365]';

            const radio = document.createElement('input');
            radio.type = 'radio';
            radio.checked = true;
            radio.disabled = true;

            const label = document.createElement('span');
            label.textContent = skill;

            div.appendChild(radio);
            div.appendChild(label);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'skills[]';
            input.value = skill;
            div.appendChild(input);

            div.addEventListener('click', () => removeSkill(skill));

            selectedSkills.appendChild(div);
        }

        function removeSkill(skill) {
            const div = Array.from(selectedSkills.children).find(el => el.dataset.skill === skill);
            if (div) div.remove();
        }
    });
</script>