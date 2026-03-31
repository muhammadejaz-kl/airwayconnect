@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary"><i class="fas fa-comments me-2"></i> Forum Management</h4>
        <button class="btn btn-primary" id="addForumBtn" data-bs-toggle="modal" data-bs-target="#forumModal">
            <i class="fas fa-plus"></i> Add Forum
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
        </div>
    </div>
</div>

<!-- Add/Edit Forum Modal -->
<div class="modal fade" id="forumModal" tabindex="-1" aria-labelledby="forumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" enctype="multipart/form-data" id="forumForm">
            @csrf
            <input type="hidden" id="forum_id" name="id">
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="forumModalLabel"><i class="fas fa-plus-circle me-2"></i> Add Forum</h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Forum Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="forum_name" class="form-control" placeholder="Enter Forum Name" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Description<span class="text-danger">*</span></label>
                            <textarea name="description" id="forum_description" class="form-control" rows="3" placeholder="Enter Description" required></textarea>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold">Banner<span class="text-danger">*</span></label>
                            <input type="file" accept=".jpg, .png, .jpeg" name="banner" id="forum_banner" class="form-control" required>
                            <small class="text-muted d-block mt-1">Only PNG, JPEG, JPG formats are allowed.</small>
                            <div id="bannerError" class="text-danger mt-1" style="display:none;"></div>
                            <div id="bannerPreview" class="mt-2"></div>
                        </div>

                        <!-- Status Field for Edit -->
                        <div class="col-md-6 mt-3" id="statusField" style="display:none;">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" id="forum_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="form-label fw-semibold">Select Topics<span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($topics as $topic)
                                <div class="form-check">
                                    <input class="form-check-input topic-checkbox" type="checkbox" name="topics[]" value="{{ $topic->id }}" id="topic-{{ $topic->id }}">
                                    <label class="form-check-label" for="topic-{{ $topic->id }}">{{ $topic->topic }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveForumBtn" disabled>
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
        $('#forumForm')[0].reset();
        $('#forum_id').val('');
        $('#bannerPreview').html('');
        $('.topic-checkbox').prop('checked', false);
        $('#statusField').hide();
        $('#forumModalLabel').text('Add Forum');
        $('#saveForumBtn').text('Save');
    }

    $(document).on('click', '#addForumBtn', function() {
        resetModal();
        $('#forumForm').attr('action', "{{ route('admin.forum.store') }}");
    });

    $(document).on('click', '.editForumBtn', function() {
        resetModal();
        $('#forumModalLabel').text('Edit Forum');
        $('#saveForumBtn').text('Update');

        $('#forum_id').val($(this).data('id'));
        $('#forum_name').val($(this).data('name'));
        $('#forum_description').val($(this).data('description'));

        if ($(this).data('banner')) {
            $('#bannerPreview').html('<img src="/storage/' + $(this).data('banner') + '" width="250" class="rounded mt-2"/>');
        }

        let topics = $(this).data('topics');
        if (topics && Array.isArray(topics)) {
            topics.forEach(id => $('#topic-' + id).prop('checked', true));
        }

        $('#statusField').show();
        $('#forum_status').val($(this).data('status'));

        let actionUrl = "{{ route('admin.forum.forumUpdate', ':id') }}".replace(':id', $(this).data('id'));
        $('#forumForm').attr('action', actionUrl);
        $('#forumModal').modal('show');
        $('#saveForumBtn').prop('disabled', false);
    });

    $(document).on('click', '.viewForumBtn', function() {
        $('#viewForumName').text($(this).data('name'));
        $('#viewForumDescription').text($(this).data('description') || 'No description');
        $('#viewForumTopics').text($(this).data('topicsnames') || 'None');
        $('#viewForumStatus').text('Status: ' + ($(this).data('status') == 1 ? 'Active' : 'Inactive'));

        if ($(this).data('banner')) {
            $('#viewForumBanner').attr('src', '/storage/' + $(this).data('banner'));
        } else {
            $('#viewForumBanner').attr('src', '/images/no-image.png');
        }
        $('#viewForumModal').modal('show');
    });

    $('#forumForm').on('submit', function() {
        showPreloader();
    });

    $('#forum_banner').on('change', function() {
        let file = this.files[0];
        let errorDiv = $('#bannerError');
        let previewDiv = $('#bannerPreview');
        let saveBtn = $('#saveForumBtn');

        errorDiv.hide().text('');
        previewDiv.html('');
        saveBtn.prop('disabled', true);

        if (file) {
            let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                errorDiv.text('Invalid file type! Only JPEG, PNG, JPG allowed.').show();
                $(this).val('');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                errorDiv.text('File size must not exceed 2MB.').show();
                $(this).val('');
                return;
            }

            let reader = new FileReader();
            reader.onload = e => previewDiv.html('<img src="' + e.target.result + '" class="img-thumbnail mt-2" width="200">');
            reader.readAsDataURL(file);

            saveBtn.prop('disabled', false);
        } else {
            saveBtn.prop('disabled', false);
        }
    });
</script>
@endpush