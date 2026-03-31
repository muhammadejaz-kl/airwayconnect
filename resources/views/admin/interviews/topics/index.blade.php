@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary"><i class="fas fa-clipboard-list me-2"></i> Classroom Topics</h4>
        <button class="btn btn-primary" id="addTopicBtn" data-bs-toggle="modal" data-bs-target="#topicModal">
            <i class="fas fa-plus"></i> Add Topic
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped'], true) !!}
        </div>
    </div>
</div>

<!-- Add/Edit Topic Modal -->
<div class="modal fade" id="topicModal" tabindex="-1" aria-labelledby="topicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="topicForm">
            @csrf
            <input type="hidden" id="topic_id" name="id">

            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="topicModalLabel"><i class="fas fa-plus-circle me-2"></i> Add Topic</h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-heading"></i></span>
                            <input type="text" name="topic" id="topic_title" class="form-control" placeholder="Enter Topic Title" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description (Max 300 characters)<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                            <textarea name="description" id="topic_description" class="form-control" placeholder="Enter Topic Description" rows="3" required></textarea>
                        </div>
                        <small class="text-muted" id="charCount">0 / 300 characters</small>
                    </div>

                    <div class="mb-3" id="statusField" style="display:none;">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" id="topic_status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveTopicBtn">
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

<!-- View Topic Modal -->
<div class="modal fade" id="viewTopicModal" tabindex="-1" aria-labelledby="viewTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow rounded-4 border-0">
            <div class="modal-header bg-info text-white rounded-top-4">
                <h5 class="modal-title" id="viewTopicModalLabel"><i class="fas fa-eye me-2"></i> View Interview Topic</h5>
            </div>
            <div class="modal-body px-4 py-4">
                <p><strong>Title:</strong> <span id="view_topic_title"></span></p>
                <p><strong>Description:</strong></p>
                <div class="border rounded p-2 bg-light" id="view_topic_description"></div>
                <p class="mt-3"><strong>Status:</strong> <span id="view_topic_status"></span></p>
                <p><strong>Added On:</strong> <span id="view_topic_created"></span></p>
            </div>
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
        $('#topicForm')[0].reset();
        $('#topic_id').val('');
        $('#topicModalLabel').text('Add Topic');
        $('#saveTopicBtn').text('Save');
        $('#statusField').hide();
        $('#wordCount').text('0 / 50 words');
    }

    $('#addTopicBtn').click(function() {
        resetModal();
        $('#topicForm').attr('action', "{{ route('admin.interview.topic.store') }}");
        if (!$('#topicForm input[name="status"]').length) {
            $('#topicForm').append('<input type="hidden" name="status" value="1">');
        }
    });

    $(document).on('click', '.editTopicBtn', function() {
        resetModal();
        $('#topicModalLabel').text('Edit Topic');
        $('#saveTopicBtn').text('Update Topic');
        $('#statusField').show();

        $('#topic_id').val($(this).data('id'));
        $('#topic_title').val($(this).data('title'));
        $('#topic_description').val($(this).data('description'));
        $('#topic_status').val($(this).data('status'));

        $('#topicForm').attr('action', "{{ url('admin/interview/topics/update') }}/" + $(this).data('id'));
        $('#topicModal').modal('show');
    });

    $(document).on('click', '.viewTopicBtn', function() {
        $('#view_topic_title').text($(this).data('title'));
        $('#view_topic_description').text($(this).data('description'));
        $('#view_topic_status').html($(this).data('status') == 1 ?
            '<span class="badge bg-success">Active</span>' :
            '<span class="badge bg-danger">Inactive</span>');
        $('#view_topic_created').text($(this).data('created'));
        $('#viewTopicModal').modal('show');
    });

    $('#topicModal').on('hidden.bs.modal', function() {
        resetModal();
        $('#topicForm input[name="status"]').remove();
    });

    $('#topic_description').on('input', function() {
        let text = $(this).val();
        let length = text.length;

        if (length > 300) {
            $(this).val(text.substring(0, 300));
            length = 300;
        }

        $('#charCount').text(length + ' / 300 characters');
    });


    $('#topicForm').on('submit', function() {
        showPreloader();
    });
</script>
@endpush