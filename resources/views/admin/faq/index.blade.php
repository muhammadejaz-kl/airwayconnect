@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary"><i class="fas fa-question-circle me-2"></i> FAQ Management</h4>
        <button class="btn btn-primary" id="addFaqBtn">
            <i class="fas fa-plus"></i> Add FAQ
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
        </div>
    </div>
</div>

<div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="faqForm">
            @csrf
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="faqModalTitle"></h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <input type="hidden" name="faq_id" id="faq_id">

                    <div class="mb-3">
                        <label for="question" class="form-label fw-semibold">Question<span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg rounded-3" name="question" id="question" placeholder="Enter question">
                    </div>

                    <div class="mb-3">
                        <label for="answer" class="form-label fw-semibold">Answer<span class="text-danger">*</span></label>
                        <textarea class="form-control rounded-3" name="answer" id="answer" rows="4" placeholder="Enter answer"></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3" id="faqModalFooter">
                    <button type="submit" class="btn btn-primary px-4" id="saveFaqBtn">
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
@endsection

    @push('scripts')
    {!! $dataTable->scripts() !!}

<script>
    $('#addFaqBtn').on('click', function() {
        $('#faqModalTitle').text('Add New FAQ');
        $('#faqForm').attr('action', "{{ route('admin.faqs.store') }}");
        $('#faqForm').attr('method', 'POST');
        $('#faqForm')[0].reset();
        $('#faq_id').val('');
        $('#question, #answer').prop('readonly', false);
        $('#saveFaqBtn').show();
        $('#faqModal').modal('show');
    });

    $(document).on('click', '.viewFaqBtn', function() {
        const question = $(this).data('question');
        const answer = $(this).data('answer');

        $('#faqModalTitle').text('View FAQ');
        $('#faqForm').attr('action', '#');
        $('#question').val(question).prop('readonly', true);
        $('#answer').val(answer).prop('readonly', true);
        $('#saveFaqBtn').hide();
        $('#faqModal').modal('show');
    });

    $('#faqForm').on('submit', function() {
        showPreloader();
    });

    $(document).on('click', '.editFaqBtn', function() {
        const id = $(this).data('id');
        const question = $(this).data('question');
        const answer = $(this).data('answer');

        $('#faqModalTitle').text('Edit FAQ');
        $('#faqForm').attr('action', "{{ url('admin/faqs/update') }}/" + id);
        $('#faqForm').attr('method', 'POST');
        $('#faq_id').val(id);
        $('#question').val(question).prop('readonly', false);
        $('#answer').val(answer).prop('readonly', false);
        $('#saveFaqBtn').show();
        $('#faqModal').modal('show');
    });
</script>
@endpush