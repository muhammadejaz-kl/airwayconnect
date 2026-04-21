<!-- Step 3 (Education) -->
<form id="step3" class="step-form hidden" method="POST" action="{{ route('user.resume.store') }}">
    @csrf

    <!-- Education Selection Section -->
    <div id="educationSelection">
        <h2 class="text-3xl text-white font-bold mb-2">Which option best matches your educational background?</h2>
        <p class="text-white text-xl mb-8">
            Pick the most suitable option, and we'll help you format your education details.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="education-option bg-secondary-color p-6 rounded-lg cursor-pointer flex items-center justify-center" data-value="Vocational certificate or Diploma">
                <h3 class="text-lg font-normal text-white text-center">Vocational certificate or Diploma</h3>
            </div>
            <div class="education-option bg-secondary-color p-6 rounded-lg cursor-pointer flex items-center justify-center" data-value="Agreement/contract internship training">
                <h3 class="text-lg font-normal text-white text-center">Agreement/contract internship training</h3>
            </div>
            <div class="education-option bg-secondary-color p-6 rounded-lg cursor-pointer flex items-center justify-center" data-value="Associate">
                <h3 class="text-lg font-normal text-white text-center">Associate</h3>
            </div>
            <div class="education-option bg-secondary-color p-6 rounded-lg cursor-pointer flex items-center justify-center" data-value="Business">
                <h3 class="text-lg font-normal text-white text-center">Business</h3>
            </div>
            <div class="education-option bg-secondary-color p-6 rounded-lg cursor-pointer flex items-center justify-center" data-value="Medicine">
                <h3 class="text-lg font-normal text-white text-center">Medicine</h3>
            </div>
            <div class="education-option bg-secondary-color p-6 rounded-lg cursor-pointer flex items-center justify-center" data-value="Doctorate or Ph.D.">
                <h3 class="text-lg font-normal text-white text-center">Doctorate or Ph.D.</h3>
            </div>
        </div>
        <h3 class="text-lg font-normal text-primary-color text-center mb-4 underline cursor-pointer" id="preferNotToAnswer">Prefer not to answer</h3>
    </div>

    <!-- Education Summary -->
    <div id="educationSummary" class="mb-8 space-y-4"></div>

    <!-- Education Details Form -->
    <div id="educationForm" class="hidden">
        <h2 class="text-3xl text-white font-bold mb-6">Tell us about education</h2>
        <p class="text-white text-xl mb-8">
            Enter your education details so far, including unfinished programs or current studies
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-white mb-2">School/Collage/University Name<span class="text-red-600">*</span></label>
                <input type="text" id="schoolName" name="school_name" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white" placeholder="Enter Your School/Collage/University Name">
            </div>
            <div>
                <label class="block text-white mb-2">Location</label>
                <input type="text" id="schoolLocation" name="school_location" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white" placeholder="Enter Location">
            </div>
            <div>
                <label class="block text-white mb-2">Degree <span class="text-red-600">*</span></label>
                <select id="degree" name="degree" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white">
                    <option value="">Select Degree</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Associate">Associate</option>
                    <option value="Bachelor">Bachelor</option>
                    <option value="Master">Master</option>
                    <option value="PhD">Ph.D.</option>
                </select>
            </div>
                        <div>
                <label class="block text-white mb-2">Field of Study</label>
                <input type="text" id="fieldOfStudy" name="field_of_study" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white" placeholder="Enter Your Field Of Study">
            </div>
        </div>

        <div class="mb-6">

            <div>
                <label class="block text-white mb-2">Graduation date (or Expected Graduation date) <span class="text-red-600">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <select id="gradMonth" name="graduation_month" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white">
                        <option value="">Month</option>
                        <option>January</option>
                        <option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
                    </select>
                    <select id="gradYear" name="graduation_year" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white">
                        <option value="">Year</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex justify-between gap-2 items-center mb-2">
                <div class="flex gap-2 items-center">
                    <input type="checkbox" id="certificatesCheckbox" class="bg-secondary-color text-white">
                    <label class="block text-white m-0">Certificates</label>
                </div>
                <button type="button" id="addCertificate" class="text-primary-color text-sm flex items-center gap-1 hidden">
                    <i class="pi pi-plus"></i> Add another certificate
                </button>
            </div>

            <div id="certificatesContainer" class="flex flex-col gap-4 hidden"></div>
        </div>

        <div class="mb-8">
            <label class="block text-white mb-2">Additional Coursework:</label>
            <textarea id="coursework" name="additional_coursework" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white h-24" placeholder="Enter Additional Coursework"></textarea>
        </div>

        <div class="flex justify-start space-x-3">
            <button type="button" id="cancelEducation"
                class="border text-base border-gray-300 min-w-[200px] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition"
                style="display:none;">
                Cancel
            </button>
            <button type="button" id="saveEducation"
                class="bg-primary-color text-base min-w-[200px] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                + Add More
            </button>
        </div>

    </div>

    <input type="hidden" id="selectedEducation" name="education_level">
    <input type="hidden" id="educationsField" name="educations">
</form>

<script>
    $(document).ready(function() {

        const gradYearSelect = $('#gradYear');
        const currentYear = new Date().getFullYear();
        const startYear = 1980;
        for (let year = currentYear; year >= startYear; year--) {
            gradYearSelect.append(`<option value="${year}">${year}</option>`);
        }

        const educations = [];
        let editingIndex = null;
        let certificateCount = 0;
        let bestMatch = null;

        function resetEducationForm() {
            $('#schoolName').val('');
            $('#schoolLocation').val('');
            $('#degree').val('');
            $('#fieldOfStudy').val('');
            $('#gradMonth').val('');
            $('#gradYear').val('');
            $('#coursework').val('');
            $('#certificatesCheckbox').prop('checked', false);
            $('#certificatesContainer').empty().addClass('hidden');
            $('#addCertificate').addClass('hidden');
            certificateCount = 0;

            editingIndex = null;
            $('#saveEducation').text('+ Add More');
            $('#cancelEducation').hide();
        }

        function getCertificates() {
            const certificates = [];
            $('.certificate-item').each(function() {
                const name = $(this).find('.certificate-name-input').val().trim();
                const month = $(this).find('.certificate-month-input').val();
                const year = $(this).find('.certificate-year-input').val();
                if (name) certificates.push({ name, month, year });
            });
            return certificates;
        }

        function addCertificateField(name = '', month = '', year = '') {
            certificateCount++;

            const months = ['January','February','March','April','May','June',
                            'July','August','September','October','November','December'];
            let monthOptions = '<option value="">Month</option>';
            months.forEach(m => {
                monthOptions += `<option value="${m}" ${month === m ? 'selected' : ''}>${m}</option>`;
            });

            let yearOptions = '<option value="">Year</option>';
            for (let y = currentYear; y >= startYear; y--) {
                yearOptions += `<option value="${y}" ${year == y ? 'selected' : ''}>${y}</option>`;
            }

            const field = `
                <div class="rounded-lg certificate-item">
                    <div class="flex justify-end mb-3">
                        <button type="button" class="remove-certificate text-red-500 hover:text-red-400" title="Remove">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6h14zM10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        </button>
                    </div>
                    <div class="mb-4">
                        <label class="block text-white mb-2">Name <span class="text-red-600">*</span></label>
                        <input type="text" class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white certificate-name-input" placeholder="Enter certificate name" value="${name}">
                    </div>
                    <div>
                        <label class="block text-white mb-2">Completion Date <span class="text-red-600">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <select class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white certificate-month-input">
                                ${monthOptions}
                            </select>
                            <select class="w-full px-4 py-3 rounded-lg bg-secondary-color text-white certificate-year-input">
                                ${yearOptions}
                            </select>
                        </div>
                    </div>
                </div>
            `;
            $('#certificatesContainer').append(field);
        }

        $('#certificatesCheckbox').change(function() {
            if ($(this).is(':checked')) {
                $('#certificatesContainer, #addCertificate').removeClass('hidden');
                if (certificateCount === 0) addCertificateField();
            } else {
                $('#certificatesContainer').addClass('hidden').empty();
                $('#addCertificate').addClass('hidden');
                certificateCount = 0;
            }
        });

        $('#addCertificate').click(function() {
            addCertificateField();
        });
        $(document).on('click', '.remove-certificate', function() {
            $(this).closest('.certificate-item').remove();
        });

        function updateEducationSummary() {
            const $summary = $('#educationSummary');
            $summary.empty();

            if (educations.length === 0) return;

            $summary.append(`
                <div class="flex justify-between items-center gap-3">
                    <h3 class="text-2xl text-white font-bold">Education Summary</h3>
                    <button type="button" id="addAnotherEducation" class="bg-primary-color py-2 px-3 rounded-lg">
                        + Add Another Education
                    </button>
                </div>
            `);

            educations.forEach((edu, index) => {
                $summary.append(`
                    <div class="bg-secondary-color p-4 rounded-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-base text-white mb-2 font-semibold">${edu.degree} in ${edu.field_of_study}</h4>
                                <p class="text-sm text-white">${edu.school_name}, ${edu.school_location} | ${edu.graduation_month} ${edu.graduation_year}</p>
                                ${edu.certificates && edu.certificates.length ? `<p class="text-xs text-gray-300 mt-1">Certificates: ${edu.certificates.map(c => typeof c === 'object' ? c.name : c).join(', ')}</p>` : ''}
                                ${edu.additional_coursework ? `<p class="text-xs text-gray-300 mt-1">Coursework: ${edu.additional_coursework}</p>` : ''}
                            </div>
                            <div class="flex space-x-3">
                                <button type="button" class="edit-education text-yellow-400 hover:text-yellow-600" data-index="${index}">✏️</button>
                                <button type="button" class="delete-education text-red-400 hover:text-red-600" data-index="${index}">🗑️</button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $('#educationsField').val(JSON.stringify(educations));
            $('#educationForm').hide();
        }

        function updateFormVisibility() {
            if (educations.length === 0) {
                $('#educationForm').show();
                $('#addAnotherEducation').hide();
                $('#cancelEducation').hide();
            } else {
                $('#educationForm').hide();
                $('#addAnotherEducation').show();
                $('#cancelEducation').hide();
            }
        }

        $('#educationSelection').show();
        $('#educationForm').hide();

        $('.education-option, #preferNotToAnswer').click(function() {
            bestMatch = $(this).hasClass('education-option') ?
                $(this).data('value') :
                $(this).text().trim();

            $('.education-option').removeClass('ring-4 ring-primary-color');
            if ($(this).hasClass('education-option')) $(this).addClass('ring-4 ring-primary-color');
            if ($(this).attr('id') === 'preferNotToAnswer') $(this).addClass('text-blue-400');

            $.post("{{ route('user.resume.saveBestMatchEducationSession') }}", {
                best_match: bestMatch,
                _token: "{{ csrf_token() }}"
            });

            $('#educationSelection').hide();
            $('#educationForm').show();

            $('#saveEducation').show();
        });

        $('#saveEducation').click(function() {
            const eduData = {
                best_match: bestMatch,
                school_name: $('#schoolName').val(),
                school_location: $('#schoolLocation').val(),
                degree: $('#degree').val(),
                field_of_study: $('#fieldOfStudy').val(),
                graduation_month: $('#gradMonth').val(),
                graduation_year: $('#gradYear').val(),
                additional_coursework: $('#coursework').val(),
                certificates: getCertificates()
            };

            if (!eduData.school_name || !eduData.degree || !eduData.graduation_month || !eduData.graduation_year) {
                alert('Please fill all required fields');
                return;
            }

            $.ajax({
                url: editingIndex !== null ?
                    "{{ route('user.resume.updateEducation') }}" : "{{ route('user.resume.saveEducationSession') }}",
                type: "POST",
                data: {
                    ...eduData,
                    index: editingIndex,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        educations.length = 0;
                        Array.prototype.push.apply(educations, response.educations);

                        updateEducationSummary();
                        resetEducationForm();
                        updateFormVisibility();
                    }
                }
            });
        });

        $(document).on('click', '.edit-education', function() {
            const index = $(this).data('index');
            editingIndex = index;

            $.ajax({
                url: "{{ route('user.resume.getEducations') }}",
                type: "GET",
                data: {
                    index: index
                },
                success: function(response) {
                    if (response.success) {
                        const edu = response.education;

                        $('#schoolName').val(edu.school_name);
                        $('#schoolLocation').val(edu.school_location);
                        $('#degree').val(edu.degree);
                        $('#fieldOfStudy').val(edu.field_of_study);
                        $('#gradMonth').val(edu.graduation_month);
                        $('#gradYear').val(edu.graduation_year);
                        $('#coursework').val(edu.additional_coursework);

                        renderCertificates(edu.certificates);

                        $('#saveEducation').text('Update Education');

                        $('#cancelEducation').show();

                        $('#educationSelection').hide();
                        $('#educationForm').show();
                    }
                }
            });
        });

        function renderCertificates(certificates) {
            $('#certificatesContainer').empty();
            certificateCount = 0;

            if (certificates && certificates.length > 0) {
                $('#certificatesCheckbox').prop('checked', true);
                $('#certificatesContainer').removeClass('hidden');
                $('#addCertificate').removeClass('hidden');

                certificates.forEach(cert => {
                    if (typeof cert === 'object') {
                        addCertificateField(cert.name, cert.month, cert.year);
                    } else {
                        addCertificateField(cert);
                    }
                });
            } else {
                $('#certificatesCheckbox').prop('checked', false);
                $('#certificatesContainer').addClass('hidden');
                $('#addCertificate').addClass('hidden');
            }
        }

        $(document).on('click', '.delete-education', function() {
            const index = $(this).data('index');

            if (!window.confirm("Are you sure you want to delete this education entry?")) {
                return;
            }

            $.ajax({
                url: "{{ route('user.resume.deleteEducation') }}",
                type: "POST",
                data: {
                    index: index,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        educations.length = 0;
                        Array.prototype.push.apply(educations, response.educations);

                        updateEducationSummary();
                        updateFormVisibility();
                    }
                }
            });
        });

        $(document).on('click', '#addAnotherEducation', function() {
            resetEducationForm();
            $('#educationForm').show();
            $(this).hide();
            $('#cancelEducation').show();
        });

        $('#cancelEducation').click(function() {
            resetEducationForm();
            updateFormVisibility();
        });

    });
</script>