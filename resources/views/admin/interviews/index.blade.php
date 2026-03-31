@extends('admin.layouts.master')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="fas fa-question-circle me-2"></i> Classroom Questions
            </h4>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.interview.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i> Go Back
                </a>

                <button class="btn btn-primary" id="addQuestionBtn" data-bs-toggle="modal" data-bs-target="#questionModal">
                    <i class="fas fa-plus"></i> Add Question
                </button>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
            </div>
        </div>
    </div>

    <!-- Add/Edit Question Modal -->
    <div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="questionForm">
                @csrf
                <input type="hidden" name="id" id="question_id">

                <div class="modal-content shadow rounded-4 border-0">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title" id="questionModalLabel"><i class="fas fa-plus-circle me-2"></i> Add Question
                        </h5>
                        <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button> -->
                    </div>

                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <!-- Select Topic -->
                            <div class="col-md-6" id="topicField">
                                <label class="form-label fw-semibold">Select Topic<span class="text-danger">*</span></label>
                                <select name="topic_id" id="topic_id" class="form-control">
                                    <option value="">-- Select Topic --</option>
                                    @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->topic }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <input type="hidden" name="topic_id" id="hidden_topic_id"> -->

                            <!-- Question Type -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Question Type<span
                                        class="text-danger">*</span></label>
                                <select name="type" id="question_type" class="form-control" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="QA">Question & Answer</option>
                                    <option value="MSQ">Multiple Choice (MCQ)</option>
                                </select>
                            </div>

                            <!-- Question -->
                            <div class="col-md-12 mt-3">
                                <label class="form-label fw-semibold">Question<span class="text-danger">*</span></label>
                                <textarea name="question" id="question_text" class="form-control" rows="3"
                                    placeholder="Enter the question" required></textarea>
                            </div>

                            <!-- QA Section -->
                            <div id="qaSection" class="col-md-12 mt-3" style="display:none;">
                                <label class="form-label fw-semibold">Answer<span class="text-danger">*</span></label>
                                <textarea name="qa_answer" id="qa_answer" class="form-control" rows="3"
                                    placeholder="Enter the answer"></textarea>
                            </div>

                            <!-- MCQ Section -->
                            <div id="mcqSection" class="col-md-12 mt-3" style="display:none;">
                                <label class="form-label fw-semibold">Options<span class="text-danger">*</span></label>
                                <div class="row g-3">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <label for="option_a" class="me-2 fw-bold">A:<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="option_a" id="option_a" class="form-control"
                                            placeholder="Option A">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <label for="option_b" class="me-2 fw-bold">B:<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="option_b" id="option_b" class="form-control"
                                            placeholder="Option B">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <label for="option_c" class="me-2 fw-bold">C:<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="option_c" id="option_c" class="form-control"
                                            placeholder="Option C">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <label for="option_d" class="me-2 fw-bold">D:<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="option_d" id="option_d" class="form-control"
                                            placeholder="Option D">
                                    </div>
                                </div>


                                <div class="mt-3">
                                    <label class="form-label fw-semibold">Correct Answer<span
                                            class="text-danger">*</span></label>
                                    <select name="mcq_answer" id="mcq_answer" class="form-control">
                                        <option value="a">Option A</option>
                                        <option value="b">Option B</option>
                                        <option value="c">Option C</option>
                                        <option value="d">Option D</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mt-3" id="statusField" style="display:none;">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" id="question_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 py-3">
                        <button type="submit" class="btn btn-primary px-4" id="saveQuestionBtn">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- View Question Modal -->
    <div class="modal fade" id="viewQuestionModal" tabindex="-1" aria-labelledby="viewQuestionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow rounded-4 border-0">
                <!-- Header -->
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title">
                        <i class="fas fa-eye me-2"></i> View Question Details
                    </h5>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 py-4">
                    <!-- Topic & Type -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <h6 class="mb-1 text-muted"><i class="fas fa-book me-1"></i> Topic</h6>
                                <p class="fw-bold mb-0 text-primary" id="view_topic"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded shadow-sm">
                                <h6 class="mb-1 text-muted"><i class="fas fa-tags me-1"></i> Type</h6>
                                <p class="fw-bold mb-0 text-primary" id="view_type"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Question -->
                    <div class="mb-4">
                        <div class="p-3 bg-white rounded shadow-sm border">
                            <h6 class="mb-2 text-muted"><i class="fas fa-question-circle me-1"></i> Question</h6>
                            <p class="fw-semibold fs-6 mb-0" id="view_question"></p>
                        </div>
                    </div>

                    <!-- QA Section -->
                    <div id="view_qa_section" class="mb-3" style="display:none;">
                        <div class="p-3 bg-light rounded shadow-sm">
                            <h6 class="mb-2 text-success"><i class="fas fa-check-circle me-1"></i> Answer</h6>
                            <p class="fw-bold mb-0 text-dark" id="view_qa_answer"></p>
                        </div>
                    </div>

                    <!-- MCQ Section -->
                    <div id="view_mcq_section" class="mb-3" style="display:none;">
                        <div class="p-3 bg-light rounded shadow-sm">
                            <h6 class="mb-2 text-muted"><i class="fas fa-list-ul me-1"></i> Options</h6>
                            <ul class="list-group mb-2">
                                <li class="list-group-item"><strong>A:</strong> <span id="view_option_a"></span></li>
                                <li class="list-group-item"><strong>B:</strong> <span id="view_option_b"></span></li>
                                <li class="list-group-item"><strong>C:</strong> <span id="view_option_c"></span></li>
                                <li class="list-group-item"><strong>D:</strong> <span id="view_option_d"></span></li>
                            </ul>
                            <div>
                                <h6 class="mb-1 text-success"><i class="fas fa-check me-1"></i> Correct Answer:</h6>
                                <span class="badge bg-success fs-6 px-3 py-2" id="view_mcq_answer"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Section -->
                    <div id="view_status_section" class="mb-3">
                        <div class="p-3 bg-light rounded shadow-sm">
                            <h6 class="mb-2 text-muted"><i class="fas fa-info-circle me-1"></i> Status</h6>
                            <span id="view_topic_status" class="badge fs-6 px-3 py-2"></span>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 px-4 py-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        function resetModal() {
            $('#questionForm')[0].reset();
            $('#question_id').val('');
            $('#statusField').hide();
            $('#qaSection, #mcqSection').hide();
            $('#topicField').hide();
            $('#hidden_topic_id').val('');
            $('#questionModalLabel').text('Add Question');
            $('#saveQuestionBtn').text('Save');
        }

        $('#addQuestionBtn').click(function () {
            resetModal();

            let topicId = new URLSearchParams(window.location.search).get('topic_id');
            $('#topic_id').val(topicId);

            $('#questionForm').attr('action', "{{ route('admin.interview.store') }}");
        });

        $('#question_type').on('change', function () {
            if ($(this).val() === 'QA') {
                $('#qaSection').show();
                $('#mcqSection').hide();
            } else if ($(this).val() === 'MSQ') {
                $('#mcqSection').show();
                $('#qaSection').hide();
            } else {
                $('#qaSection, #mcqSection').hide();
            }
        });

        $(document).on('click', '.editQuestionBtn', function () {
            resetModal();

            $('#questionModalLabel').text('Edit Question');
            $('#saveQuestionBtn').text('Update');

            $('#question_id').val($(this).data('id'));
            $('#topicField').show();
            $('#topic_id').val($(this).data('topic'));
            $('#question_type').val($(this).data('type')).trigger('change');
            $('#question_text').val($(this).data('question'));
            $('#question_status').val($(this).data('status'));
            $('#statusField').show();

            if ($(this).data('type') === 'QA') {
                $('#qa_answer').val($(this).data('answer'));
            } else if ($(this).data('type') === 'MSQ') {
                let options = $(this).data('options');
                if (typeof options === 'string') {
                    options = JSON.parse(options);
                }
                $('#option_a').val(options.a);
                $('#option_b').val(options.b);
                $('#option_c').val(options.c);
                $('#option_d').val(options.d);
                $('#mcq_answer').val($(this).data('answer'));
            }

            let updateUrl = "{{ url('admin/interview/update') }}/" + $(this).data('id');
            $('#questionForm').attr('action', updateUrl);

            $('#questionModal').modal('show');
        });

        $('#questionForm').on('submit', function () {
            showPreloader();
        });

        $(document).on('click', '.viewQuestionBtn', function () {
            $('#view_topic').text($(this).data('topicname'));
            $('#view_type').text($(this).data('type') === 'QA' ? 'Question & Answer' : 'Multiple Choice');
            $('#view_question').text($(this).data('question'));

            // Show correct status with badge color
            if ($(this).data('status') == 1) {
                $('#view_topic_status').text('Active').removeClass().addClass('badge bg-success fs-6 px-3 py-2');
            } else {
                $('#view_topic_status').text('Inactive').removeClass().addClass('badge bg-danger fs-6 px-3 py-2');
            }

            if ($(this).data('type') === 'QA') {
                $('#view_qa_section').show();
                $('#view_mcq_section').hide();
                $('#view_qa_answer').text($(this).data('answer'));
            } else {
                $('#view_mcq_section').show();
                $('#view_qa_section').hide();
                let options = $(this).data('options');
                if (typeof options === 'string') {
                    options = JSON.parse(options);
                }
                $('#view_option_a').text(options.a);
                $('#view_option_b').text(options.b);
                $('#view_option_c').text(options.c);
                $('#view_option_d').text(options.d);
                $('#view_mcq_answer').text($(this).data('answer').toUpperCase());
            }

            $('#viewQuestionModal').modal('show');
        });
    </script>
@endpush