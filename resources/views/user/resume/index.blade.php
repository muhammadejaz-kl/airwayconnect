@extends('user.layout.user')

@section('content')
    <div class="py-7">
        <div class="mx-auto w-full md:w-[80vw] md:max-w-[90vw] p-2 sm:px-6 lg:px-8">

            {{-- Step 1: Create Resume --}}
            <div id="step-create" class="">
                @include('user.resume.partials.create-resume')
            </div>

            {{-- Step 2: Working Experience --}}
            <div id="step-experience" class="hidden">
                @include('user.resume.partials.working-experience')
            </div>

            {{-- Step 3: Select Template --}}
            <div id="step-template" class="hidden">
                @include('user.resume.partials.select-template')
            </div>

            {{-- Step 4: Upload Resume --}}
            <div id="step-upload" class="hidden">
                @include('user.resume.partials.upload-resume')
            </div>

            {{-- Step 5: Resume Editor --}}
            <div id="step-editor" class="hidden">
                @include('user.resume.partials.resume-editor')
            </div>

        </div>
    </div>
@endsection

@push('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const steps = {
                create: document.getElementById("step-create"),
                experience: document.getElementById("step-experience"),
                template: document.getElementById("step-template"),
                upload: document.getElementById("step-upload"),
                editor: document.getElementById("step-editor"),
            };

            window.showStep = function (stepName) {
                Object.values(steps).forEach(step => step.classList.add("hidden"));
                steps[stepName].classList.remove("hidden");
            };

            document.querySelector("#step-create button[onclick]").addEventListener("click", () => {
                showStep("experience");
            });

            document.querySelectorAll("#step-experience #experienceButtons button").forEach(btn => {
                btn.addEventListener("click", () => showStep("template"));
            });

            const changeTemplateBtn = document.getElementById("changeTemplate");
            if (changeTemplateBtn) {
                changeTemplateBtn.addEventListener("click", () => {
                    showStep("template");
                });
            }

            const templateNextBtn = document.getElementById("templateNextBtn");
            const templateBackBtn = document.getElementById("templateBackBtn");

            window.selectedTemplate = null;

            templateBackBtn.addEventListener("click", () => showStep("experience"));
            templateNextBtn.addEventListener("click", () => {
                if (window.selectedTemplate) showStep("upload");
            });

            const uploadBackBtn = document.getElementById("uploadBackBtn");
            const uploadSkipBtn = document.getElementById("uploadSkipBtn");
            const uploadNextBtn = document.getElementById("uploadNextBtn");

            uploadBackBtn.addEventListener("click", () => showStep("template"));

            uploadSkipBtn.addEventListener("click", () => {
                showStep("editor");
                loadTemplatePreview();
            });

            uploadNextBtn.addEventListener("click", () => {
                const fileInput = document.getElementById("resume");
                if (fileInput.files.length === 0) {
                    showStep("editor");
                    loadTemplatePreview();
                    return;
                }

                const formData = new FormData();
                formData.append("resume", fileInput.files[0]);
                formData.append("_token", "{{ csrf_token() }}");

                fetch("{{ env('APP_URL') }}/resume/parse", {
                    method: "POST",
                    body: formData
                })

                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            document.querySelector('[name="first_name"]').value = res.data.first_name || "";
                            document.querySelector('[name="surname"]').value = res.data.surname || "";
                            document.querySelector('[name="phone"]').value = res.data.phone || "";
                            document.querySelector('[name="email"]').value = res.data.email || "";
                            document.querySelector('[name[Your Name]="residential_address"]').value = res.data.residential_address || "";

                            document.getElementById("jobTitle").value = res.data.job_title || "";
                            document.getElementById("employer").value = res.data.employer || "";
                            document.getElementById("location").value = res.data.location || "";

                            if (res.data.start_date) {
                                let [month, year] = res.data.start_date.split(" ");
                                document.getElementById("startMonth").value = month.substring(0, 3);
                                document.getElementById("startYear").value = year;
                            }

                            if (res.data.end_date) {
                                let [month, year] = res.data.end_date.split(" ");
                                document.getElementById("endMonth").value = month.substring(0, 3);
                                document.getElementById("endYear").value = year;
                            }

                            document.getElementById("schoolName").value = res.data.school_name || "";
                            document.getElementById("schoolLocation").value = res.data.school_location || "";
                            document.getElementById("degree").value = res.data.degree || "";
                            document.getElementById("fieldOfStudy").value = res.data.field_of_study || "";

                            if (res.data.graduation_date) {
                                let [month, year] = res.data.graduation_date.split(" ");
                                document.getElementById("gradMonth").value = month;
                                document.getElementById("gradYear").value = year;
                            }

                            if (res.data.skills && res.data.skills.length > 0) {
                                const selectedSkills = document.getElementById("selectedSkills");
                                res.data.skills.forEach(skill => {
                                    if (!skill) return;
                                    const div = document.createElement('div');
                                    div.textContent = skill;
                                    div.dataset.skill = skill;
                                    div.className = 'bg-gray-700 text-white px-3 py-1 text-sm flex items-center gap-2 border border-gray-500 rounded-md';

                                    const removeBtn = document.createElement('button');
                                    removeBtn.textContent = '×';
                                    removeBtn.className = 'ml-2 text-red-400 hover:text-red-600 font-bold';
                                    removeBtn.onclick = () => div.remove();

                                    div.appendChild(removeBtn);

                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'skills[]';
                                    input.value = skill;
                                    div.appendChild(input);

                                    selectedSkills.appendChild(div);
                                });
                            }

                            if (res.data.professional_summary) {
                                document.getElementById("professional_summary").value = res.data.professional_summary;
                            }
                        }

                        showStep("editor");
                        loadTemplatePreview();
                    })
                    .catch(() => {
                        showStep("editor");
                        loadTemplatePreview();
                    });
            });

            const dropArea = document.getElementById('dropArea');
            const input = document.getElementById('resume');
            const browseLabel = document.getElementById('browseLabel');
            const dropText = document.getElementById('dropText');

            function updateFileName(fileName) {
                dropText.textContent = fileName;
                browseLabel.textContent = "Replace";
                browseLabel.classList.add('bg-primary-color');

                uploadSkipBtn.classList.add("hidden");
                uploadNextBtn.classList.remove("hidden");
            }

            // dropArea.addEventListener('click', () => input.click());
            dropArea.addEventListener('click', (e) => {
                if (e.target.id !== 'browseLabel') {
                    input.click();
                }
            });

            dropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropArea.classList.add('border-blue-500');
            });
            dropArea.addEventListener('dragleave', () => {
                dropArea.classList.remove('border-blue-500');
            });
            dropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                input.files = e.dataTransfer.files;
                updateFileName(input.files[0].name);
            });

            input.addEventListener('change', () => {
                if (input.files.length > 0) {
                    updateFileName(input.files[0].name);
                }
            });

            function loadTemplatePreview() {
                fetch("{{ route('user.resume.getTemplatePreview') }}")
                    .then(res => res.json())
                    .then(data => {
                        const templateId = data.templateId;

                        const templateImages = {
                            'template1': "{{ asset('assets/images/templates/template2.png') }}",
                            'template2': "{{ asset('assets/images/templates/template3.png') }}",
                            'template3': "{{ asset('assets/images/templates/template4.png') }}"
                        };

                        const preview = document.getElementById("resumePreviewArea");
                        if (!preview) return;

                        preview.innerHTML = "";

                        const wrapper = document.createElement("div");
                        wrapper.className = "rounded-lg text-center relative";

                        const img = document.createElement("img");
                        img.src = templateImages[templateId] || templateImages['template1'];
                        img.className = "rounded shadow-lg w-full h-[500px] border-2 border-gray-300";

                        wrapper.appendChild(img);
                        preview.appendChild(wrapper);
                    })
                    .catch(() => {
                        const preview = document.getElementById("resumePreviewArea");
                        if (preview) {
                            preview.innerHTML =
                                `<div class="flex items-center justify-center h-full text-gray-400">
                                        Failed to load preview
                                    </div>`;
                        }
                    });
            }


        });
    </script>



@endpush