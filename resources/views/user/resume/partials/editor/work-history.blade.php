<!-- Step 2 (Work History) -->
<form id="step2" class="step-form hidden" method="POST" action="{{ route('user.resume.store') }}">
    @csrf
    <h2 class="text-3xl text-white font-bold mb-2" id="formTitle">Share some details about your last job</h2>
    <p class="text-white text-xl mb-6" id="formDesc">
        We'll start there and work backward.
    </p>

    <!-- Jobs Summary Section (moved above the job form) -->
    <div id="jobsSummary" class="mb-8 space-y-4">
        <!-- Jobs will be listed here -->
    </div>

    <!-- Job Form -->
    <div id="jobForm">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="text-sm">Job title<span class="text-red-600">*</span></label>
                <input type="text" id="jobTitle" name="job_title" class="w-full px-3 py-2 rounded-lg bg-secondary-color" placeholder="e.g. Operations Coordinator" required>
            </div>
            <div>
                <label class="text-sm">Employer<span class="text-red-600">*</span></label>
                <input type="text" id="employer" name="employer" class="w-full px-3 py-2 rounded-lg bg-secondary-color" placeholder="e.g. Delta Airlines" required>
            </div>
            <div>
                <label class="text-sm">Location</label>
                <input type="text" id="location" name="location" placeholder="e.g. Sunshine Junction" class="w-full px-3 py-2 rounded-lg bg-secondary-color">
            </div>
        </div>

        <div class="flex items-center space-x-4 mb-4">
            <label class="flex items-center space-x-2">
                <input type="checkbox" id="isRemote" name="remote" value="1" class="radio-btn">
                <span class="text-sm">Remote</span>
            </label>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="grid grid-cols-1 items-end md:grid-cols-2 gap-3">
                <div>
                    <label class="text-sm">Start Date <span class="text-red-600">*</span></label>
                    <select id="startMonth" name="start_month" class="px-3 w-full py-2 rounded-lg bg-secondary-color border-none">
                        <option value="">Month</option> <option value="Jan">January</option> <option value="Feb">February</option> <option value="Mar">March</option> <option value="Apr">April</option> <option value="May">May</option>
                        <option value="Jun">June</option> <option value="Jul">July</option> <option value="Aug">August</option> <option value="Sep">September</option> <option value="Oct">October</option>
                        <option value="Nov">November</option> <option value="Dec">December</option>
                    </select>
                </div>
                <div>
                    <select id="startYear" name="start_year" class="px-3 w-full py-2 rounded-lg bg-secondary-color border-none">
                        <option value="">Year</option>
                        <!-- Years added by JS -->
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 items-end md:grid-cols-2 gap-3" id="endDateSection">
                <div>
                    <label class="text-sm">End Date</label>
                    <select id="endMonth" name="end_month" class="px-3 w-full py-2 rounded-lg bg-secondary-color border-none">
                        <option value="">Month</option> <option value="Jan">January</option> <option value="Feb">February</option> <option value="Mar">March</option> <option value="Apr">April</option>
                        <option value="May">May</option> <option value="Jun">June</option> <option value="Jul">July</option> <option value="Aug">August</option> <option value="Sep">September</option>
                        <option value="Oct">October</option> <option value="Nov">November</option> <option value="Dec">December</option>
                    </select>
                </div>
                <div>
                    <select id="endYear" name="end_year" class="px-3 w-full py-2 rounded-lg bg-secondary-color border-none">
                        <option value="">Year</option>
                        <!-- Years added by JS -->
                    </select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div></div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" id="currentJob" name="currently_work" value="1" class="radio-btn">
                <span class="text-sm">I currently work here</span>
            </label>
        </div>

        <div class="flex items-center mb-4" x-data="{ selected: '' }">
            <div class="w-full max-w-lg">
                <h3 class="text-white text-lg font-semibold mb-6">Experienced With</h3>
                <div class="flex flex-wrap gap-2">
                    <template x-for="btn in ['WSI','Foreflight','Flightops','Flightaware']" :key="btn">
                        <p
                            class="experience-btn cursor-pointer px-5 py-2 rounded-lg border border-gray-500 text-gray-300 hover:bg-gray-700"
                            :class="{ 'bg-blue-600 text-white font-medium': selected === btn }"
                            :data-value="btn"
                            @click="selected = btn">
                            <span x-text="btn"></span>
                        </p>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex justify-start space-x-3">
            <button type="button" id="cancelJob"
                class="border text-base border-gray-300 min-w-[200px] text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition"
                style="display: none;">
                Cancel
            </button>
            <button type="button" id="saveJob"
                class="bg-primary-color text-base min-w-[200px] text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                + Add More
            </button>
        </div>

    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        const startYearSelect = $('#startYear');
        const endYearSelect = $('#endYear');
        const currentYear = new Date().getFullYear();
        const startYear = 1980;

        for (let year = currentYear; year >= startYear; year--) {
            const option = `<option value="${year}">${year}</option>`;
            startYearSelect.append(option);
            endYearSelect.append(option);
        }
    });
</script>
<script>
    $(document).ready(function() {
        const jobs = [];

        updateFormVisibility();

        $('#saveJob').click(function() {
            const experiencedWith = $('.experience-btn.bg-blue-600').map(function() {
                return $(this).data('value');
            }).get().join(", ");

            const formData = {
                job_title: $('#jobTitle').val(),
                employer: $('#employer').val(),
                location: $('#location').val(),
                remote: $('#isRemote').is(':checked') ? 1 : 0,
                currently_work: $('#currentJob').is(':checked') ? 1 : 0,
                start_date: $('#startMonth').val() + ' ' + $('#startYear').val(),
                end_date: $('#currentJob').is(':checked') ? 'Present' : $('#endMonth').val() + ' ' + $('#endYear').val(),
                experienced_with: experiencedWith
            };

            if (!formData.job_title || !formData.employer || !$('#startMonth').val() || !$('#startYear').val() || (!formData.currently_work && (!$('#endMonth').val() || !$('#endYear').val()))) { alert('Please fill all required fields'); return; }

            const url = editingIndex !== null ? "{{ route('user.resume.updateJob') }}" : "{{ route('user.resume.saveJob') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    ...formData,
                    index: editingIndex,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        updateJobsSummary(response.jobs);
                        resetJobForm();
 
                        $('#jobForm').hide();
                        $('#cancelJob').hide();
 
                        $('#saveJob').text('+ Add More');
                        editingIndex = null;
                    }
                }

            });
        });

        $(document).on('click', '#addAnotherJob', function() {
            resetJobForm();
            $('#jobForm').show();
            $(this).hide();
            $('#cancelJob').show();
        });

        $('#cancelJob').click(function() {
            resetJobForm();
            updateFormVisibility();
        });

        $(document).on('click', '.delete-job', function() {
            const index = $(this).data('index');

            if (!confirm("Are you sure you want to delete this job?")) return;

            $.ajax({
                url: "{{ route('user.resume.deleteJob') }}",
                type: "POST",
                data: {
                    index: index,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        updateJobsSummary(response.jobs);
                        updateFormVisibility();
                    }
                }
            });
        });

        function updateJobsSummary(jobs) {
            const $summary = $('#jobsSummary');
            $summary.empty();

            if (jobs.length === 0) return;

            $summary.append(`
                <div class="flex justify-between items-center gap-3">
                    <h3 class="text-2xl text-white font-bold ">Jobs Summary</h3>
                    <button type="button" id="addAnotherJob" class="bg-primary-color py-2 px-3 rounded-lg">
                        + Add Another Job
                    </button>
                </div>
            `);

            jobs.forEach((job, index) => {
                $summary.append(`
                    <div class="job-item bg-secondary-color p-4 rounded-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-base text-white mb-2 font-semibold">
                                    ${job.job_title} at ${job.employer}${job.remote ? ' (Remote)' : ''}
                                </h4>
                                <p class="text-sm text-white">${job.location} | ${job.start_date} - ${job.end_date}</p>
                                ${job.experienced_with ? `
                                <div class="mt-2 flex flex-wrap gap-2">
                                    ${job.experienced_with.split(",").map(exp => 
                                        `<span class="px-2 py-1 bg-blue-900 text-blue-100 text-xs rounded">${exp.trim()}</span>`
                                    ).join('')}
                                </div>` : ''}
                            </div>
                            <div class="flex space-x-3">
                                <!-- edit icon -->
                                <button type="button" class="edit-job text-yellow-400 hover:text-yellow-600" data-index="${index}">
                                    ✏️
                                </button>
                                <!-- delete icon -->
                                <button type="button" class="delete-job text-red-400 hover:text-red-600" data-index="${index}">
                                    🗑️
                                </button>
                            </div>
                        </div>
                    </div>
                `);
            });

            $('#jobForm').hide();
        }

        function resetJobForm() {
            $('#jobTitle').val('');
            $('#employer').val('');
            $('#location').val('');

            $('#isRemote').prop('checked', false);
            $('#currentJob').prop('checked', false);

            $('#startMonth').val('');
            $('#startYear').val('');
            $('#endMonth').val('');
            $('#endYear').val('');

            $('.experience-btn').removeClass('bg-blue-600 text-white border-gray-500');

            $('#endDateSection').show();
        }

        function updateFormVisibility() {
            if ($('#jobsSummary .job-item').length === 0) {
                $('#jobForm').show();
                $('#addAnotherJob').hide();
                $('#cancelJob').hide();
            } else {
                $('#jobForm').hide();
                $('#addAnotherJob').show();
                $('#cancelJob').hide();
            }
        }

        let editingIndex = null;

        $(document).on('click', '.edit-job', function() {
            const index = $(this).data('index');
            editingIndex = index;

            $.ajax({
                url: "{{ route('user.resume.getJobs') }}",
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        const job = response.jobs[index];
                        if (!job) return;

                        $('#jobTitle').val(job.job_title);
                        $('#employer').val(job.employer);
                        $('#location').val(job.location);
                        $('#isRemote').prop('checked', job.remote == 1);
                        $('#currentJob').prop('checked', job.currently_work == 1);

                        const [startMonth, startYear] = job.start_date.split(' ');
                        $('#startMonth').val(startMonth);
                        $('#startYear').val(startYear);

                        if (job.end_date !== "Present") {
                            const [endMonth, endYear] = job.end_date.split(' ');
                            $('#endMonth').val(endMonth);
                            $('#endYear').val(endYear);
                        }

                        $('.experience-btn').removeClass('bg-blue-600 text-white');
                        if (job.experienced_with) {
                            job.experienced_with.split(",").forEach(exp => {
                                $(`.experience-btn[data-value="${exp.trim()}"]`)
                                    .addClass('bg-blue-600 text-white');
                            });
                        }

                        $('#saveJob').text('Done');
                        $('#jobForm').show();
                        $('#cancelJob').show();
                        $('#addAnotherJob').hide();
                    }
                }
            });
        });

        $(document).on('click', '#addAnotherJob', function() {
            resetJobForm();
            $('#jobForm').show();
            $('#cancelJob').show();
            $(this).hide();
        });

        $('#cancelJob').click(function() {
            $('#jobForm').hide();

            $('#addAnotherJob').show();
            $('#cancelJob').hide();

            $.ajax({
                url: "{{ route('user.resume.getJobs') }}",
                type: "GET",
                success: function(response) {
                    if (response.success) {
                        updateJobsSummary(response.jobs);
                    }
                }
            });
        });
    });
</script>