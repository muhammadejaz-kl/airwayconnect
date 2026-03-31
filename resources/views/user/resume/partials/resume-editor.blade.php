<div class="flex flex-col lg:flex-row py-8 text-white min-h-screen">
    <!-- Stepper -->
    <div class="w-full lg:w-1/4 bg-secondary-color rounded-lg p-6 space-y-8">
        <div class="space-y-6">
            @php
                $steps = [
                    'Contact Details',
                    'Work History',
                    'Education',
                    'Skills',
                    'Summary',
                    'Finalize'
                ];
            @endphp
            @foreach($steps as $index => $step)
                <div class="flex items-center space-x-3 step-item cursor-pointer" data-step="{{ $index + 1 }}">
                    <div
                        class="w-8 h-8 rounded-full border-2 flex items-center justify-center 
                        step-circle {{ $index == 0 ? 'bg-primary-color active border-[#1e40af]' : 'bg-secondary-color border-gray-400' }}">
                        <span class="step-number">{{ $index + 1 }}</span>
                    </div>
                    <span class="text-lg step-text text-white">{{ $step }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Form Area -->
    <div class="w-full lg:w-2/4 p-8">
        <!-- step1 -->
        @include('user.resume.partials.editor.contact-detail')
        <!-- step2 -->
        @include('user.resume.partials.editor.work-history')
        <!-- step3 -->
        @include('user.resume.partials.editor.education')
        <!-- step4 -->
        @include('user.resume.partials.editor.skills')
        <!-- step5 -->
        @include('user.resume.partials.editor.summary')
        <!-- final -->
        @include('user.resume.partials.editor.finalize')

        <div id="formButtons" class="flex justify-end gap-3 mt-4">
            <button type="button" id="backBtn"
                class="border text-base border-gray-300 md:min-w-[200px] w-[130px] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                Back
            </button>
            <button type="button" id="nextBtn"
                class="bg-primary-color text-base md:min-w-[200px] w-[130px] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Next
            </button>
        </div>

    </div>

    <div class="hidden lg:block w-[380px] " id="sidebarArea">

        <div id="resumePreviewWrapper">
            <div id="resumePreviewArea"
                style="width:100%; height:500px; border:1px solid #444; border-radius:8px; overflow:hidden;">
                <div class="flex h-full text-gray-400">
                    Template preview will appear here
                </div>
            </div>

            <button id="changeTemplate" class="bg-blue-600 mt-4 px-6 py-2 rounded-full w-full">
                Change Template
            </button>
        </div>

        <div id="sidebarButtons" class="hidden flex justify-between gap-2 mt-6">
            <button id="sideBackBtn"
                class="border border-gray-300 text-white px-4 py-3 rounded-lg hover:bg-gray-700 transition w-1/2">
                Back
            </button>
            <button id="sideNextBtn"
                class="bg-primary-color text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition w-1/2">
                Finish
            </button>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let currentStep = 1;
        const totalSteps = 6;

        // -------------------- STEP NAVIGATION --------------------
        $('#nextBtn').click(function () {
            if (currentStep === 6) {
                saveResumeImage();
                return;
            }
            switch (currentStep) {
                case 1:
                    saveContactDetails();
                    break;
                case 2:
                    saveWorkHistory();
                    break;
                case 3:
                    saveEducation();
                    break;
                case 4:
                    saveSkills();
                    break;
                case 5:
                    saveSummary();
                    break;
                default:
                    if (currentStep < totalSteps) goToStep(currentStep + 1);
            }
        });

        $('#backBtn').click(function () {
            if (currentStep > 1) {
                goToStep(currentStep - 1);
            } else {
                showStep("upload");
            }
        });

        $('.step-item').click(function () {
            const step = parseInt($(this).data('step'));
            goToStep(step);
        });

        function goToStep(step) {
            $('#step' + currentStep).addClass('hidden');
            currentStep = step;
            $('#step' + currentStep).removeClass('hidden');

            $('.step-item').each(function (index) {
                const circle = $(this).find('.step-circle');
                const text = $(this).find('.step-text');
                const stepIndex = index + 1;
                const isActive = stepIndex === currentStep;
                const isCompleted = stepIndex < currentStep;

                circle.toggleClass('bg-primary-color active border-[#1e40af]', isActive);
                circle.toggleClass('completed', isCompleted);
                circle.toggleClass('bg-secondary-color border-gray-400', !isActive && !isCompleted);

                text.toggleClass('font-bold', isActive);
                $(this).toggleClass('active', isActive);
                updateButtonLabel();
            });

            if (currentStep === 6) {
                $('#resumePreviewWrapper').hide();
                $('#sidebarButtons').removeClass('hidden').show();

                $('#backBtn').parent().hide();
            } else {
                $('#resumePreviewWrapper').show();
                $('#sidebarButtons').hide();
                $('#backBtn').parent().show();

                if (currentStep < 5) {
                    loadTemplatePreview();
                }
            }
        }

        $('#sideBackBtn').click(function () {
            $('#backBtn').trigger('click');
        });
        $('#sideNextBtn').click(function () {
            $('#nextBtn').trigger('click');
        });

        function updateButtonLabel() {
            if (currentStep === 6) {
                $('#nextBtn').text('Finish');
            } else {
                $('#nextBtn').text('Next');
            }
        }

        let resizeTimer;
        $(window).resize(function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(generatePreview, 200);
        });

        // -------------------- STEP FUNCTIONS --------------------
        function saveContactDetails() {
            let form = $('#step1')[0];
            let isValid = true;

            $('#step1 .error-message').remove();

            $(form).find('[required]').each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    if ($(this).next('.error-message').length === 0) {
                        $(this).after('<span class="text-red-600 text-sm error-message">This field is required</span>');
                    }
                }
            });

            if (!isValid) return;

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let formData = new FormData(form);
            formData.append('step', 'details');

            $.ajax({
                url: "{{ route('user.resume.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log("Contact details saved:", res);
                    goToStep(currentStep + 1);
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            let input = $(`[name="${field}"]`);
                            if (input.length && input.next('.error-message').length === 0) {
                                input.after('<span class="text-red-600 text-sm error-message">' + errors[field][0] + '</span>');
                            }
                        }
                    }
                }
            });
        }

        function saveWorkHistory() {
            let form = $('#step2')[0];

            $('#step2 .error-message').remove();
            let isValid = true;

            const requiredFields = ['#jobTitle', '#employer', '#startMonth', '#startYear'];
            let currentJobFilled = requiredFields.every(sel => $(sel).val());

            $.ajax({
                url: "{{ route('user.resume.getJobs') }}",
                type: "GET",
                async: false,
                success: function (response) {
                    const hasPreviousJobs = response.success && response.jobs.length > 0;

                    if (!currentJobFilled && !hasPreviousJobs) {
                        isValid = false;
                        if ($('#jobTitle').next('.error-message').length === 0) {
                            $('#jobTitle').after('<span class="text-red-600 text-sm error-message">Please fill all required fields OR add at least one job.</span>');
                        }
                    }
                }
            });

            if (!isValid) return;

            let formData = new FormData(form);
            formData.append('step', 'work');
            formData.append('remote', $('#isRemote').is(':checked') ? 1 : 0);
            formData.append('start_date', $('#startMonth').val() + " " + $('#startYear').val());
            formData.append('end_date', $('#currentJob').is(':checked') ? "Present" : $('#endMonth').val() + " " + $('#endYear').val());
            formData.append('currently_work', $('#currentJob').is(':checked') ? 1 : 0);

            let experiencedWith = $('.experience-btn.bg-blue-600').map(function () {
                return $(this).data('value');
            }).get().join(", ");
            formData.append('experienced_with', experiencedWith);

            $.ajax({
                url: "{{ route('user.resume.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log("All work history saved:", res);
                    goToStep(currentStep + 1);
                },
                error: function (xhr) {
                    console.error("Save failed:", xhr.responseText);
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            const input = $(`[name="${field}"]`);
                            if (input.length && input.next('.error-message').length === 0) {
                                input.after('<span class="text-red-600 text-sm error-message">' + errors[field][0] + '</span>');
                            }
                        }
                    }
                }
            });
        }

        function saveEducation() {
            let form = $('#step3')[0];

            $('#step3 .error-message').remove();
            let isValid = true;

            const requiredFields = ['#schoolName', '#degree', '#gradMonth', '#gradYear'];
            let currentEduFilled = requiredFields.every(sel => $(sel).val());

            $.ajax({
                url: "{{ route('user.resume.getEducations') }}",
                type: "GET",
                async: false,
                success: function (response) {
                    const hasPreviousEdu = response.success && response.educations.length > 0;

                    if (!currentEduFilled && !hasPreviousEdu) {
                        isValid = false;
                        if ($('#schoolName').next('.error-message').length === 0) {
                            $('#schoolName').after('<span class="text-red-600 text-sm error-message">Please fill all required fields OR add at least one education.</span>');
                        }
                    }
                }
            });

            if (!isValid) return;

            let formData = new FormData(form);
            formData.append('step', 'education');

            const certificates = [];
            $('.certificate-input').each(function () {
                let v = $(this).val().trim();
                if (v) certificates.push(v);
            });
            formData.set('certificates', JSON.stringify(certificates));

            $.ajax({
                url: "{{ route('user.resume.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log("Education saved:", res);
                    goToStep(currentStep + 1);
                },
                error: function (xhr) {
                    console.error("Save failed:", xhr.responseText);
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            const input = $(`[name="${field}"]`);
                            if (input.length && input.next('.error-message').length === 0) {
                                input.after('<span class="text-red-600 text-sm error-message">' + errors[field][0] + '</span>');
                            }
                        }
                    }
                }
            });
        }

        function saveSkills() {
            let form = $('#step4')[0];

            $('#step4 .error-message').remove();

            let formData = new FormData(form);
            formData.append('step', 'skills');

            let selectedSkills = [];
            $('#selectedSkills input[name="skills[]"]').each(function () {
                selectedSkills.push($(this).val());
                formData.append('skills[]', $(this).val());
            });

            if (selectedSkills.length === 0) {
                if ($('#selectedSkills').find('.error-message').length === 0) {
                    $('#selectedSkills').after('<span class="text-red-600 text-sm error-message">Please select at least one skill.</span>');
                }
                return;
            }

            $.ajax({
                url: "{{ route('user.resume.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log("Skills saved:", res);
                    goToStep(currentStep + 1);
                },
                error: function (xhr) {
                    console.error("Save failed:", xhr.responseText);
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            const input = $(`[name="${field}"]`);
                            if (input.length && input.next('.error-message').length === 0) {
                                input.after('<span class="text-red-600 text-sm error-message">' + errors[field][0] + '</span>');
                            }
                        }
                    }
                }
            });
        }

        function saveSummary() {
            let form = $('#step5')[0];

            $('#step5 .error-message').remove();

            const summaryInput = $('#professional_summary');
            if (!summaryInput.val().trim()) {
                if (summaryInput.next('.error-message').length === 0) {
                    summaryInput.after('<span class="text-red-600 text-sm error-message">Please enter your professional summary.</span>');
                }
                return;
            }

            let formData = new FormData(form);
            formData.append('step', 'summary');

            $.ajax({
                url: "{{ route('user.resume.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    console.log("Summary saved:", res);

                    $.ajax({
                        url: "{{ route('user.resume.finalize.template') }}",
                        type: "GET",
                        success: function (html) {
                            $("#step6 .w-full").html(html);
                            goToStep(currentStep + 1);
                        },
                        error: function (xhr) {
                            console.error("Template fetch failed:", xhr.responseText);
                        }
                    });
                },
                error: function (xhr) {
                    console.error("Save failed:", xhr.responseText);
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            const input = $(`[name="${field}"]`);
                            if (input.length && input.next('.error-message').length === 0) {
                                input.after('<span class="text-red-600 text-sm error-message">' + errors[field][0] + '</span>');
                            }
                        }
                    }
                }
            });
        }

        function saveResumeImage() {
            html2canvas($('#step6 .w-full')[0], {
                scale: 2,
                backgroundColor: '#fff'
            }).then(function (canvas) {
                let imageData = canvas.toDataURL('image/png');

                $.ajax({
                    url: "{{ route('user.resume.save.image') }}",
                    type: "POST",
                    data: {
                        image: imageData,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Resume saved successfully!',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Ok',
                            cancelButtonText: 'Close'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                clearResumeSession();
                            }
                        });
                    },
                    error: function (xhr) {
                        let message = 'Failed to save resume image.';

                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            message = xhr.responseJSON.error;
                        }

                        Swal.fire({
                            title: 'Error!',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        }

        function clearResumeSession() {
            $.ajax({
                url: "{{ route('user.resume.clearSession') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (res) {
                    location.reload();
                },
                error: function () {
                    Swal.fire({ title: 'Error!', text: 'Failed to clear session.', icon: 'error', confirmButtonText: 'OK' });
                }
            });
        }

    });
</script>