@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary"><i class="fas fa-comments me-2"></i> Forum Topics</h4>
        <button class="btn btn-primary" id="addTopicBtn" data-bs-toggle="modal" data-bs-target="#topicModal">
            <i class="fas fa-plus"></i> Add Topic
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
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
    }

    $('#addTopicBtn').click(function() {
        resetModal();
        $('#topicForm').attr('action', "{{ route('admin.forum.topic.store') }}");
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
        $('#topic_status').val($(this).data('status'));

        $('#topicForm').attr('action', "{{ url('admin/forum/topic/update') }}/" + $(this).data('id'));
        $('#topicModal').modal('show');
    });

    $('#topicModal').on('hidden.bs.modal', function() {
        resetModal();
        $('#topicForm input[name="status"]').remove();
    });

    $('#topicForm').on('submit', function() {
        showPreloader();
    });
</script>
@endpush