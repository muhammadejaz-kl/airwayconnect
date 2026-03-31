@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary"><i data-feather="award"></i> Testimonial Management</h4>
        <button class="btn btn-primary" id="addTestimonialBtn" data-bs-toggle="modal" data-bs-target="#testimonialModal">
            <i class="fas fa-plus"></i> Add Testimonial
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
        </div>
    </div>
</div>

<!-- Add/Edit Testimonial Modal -->
<div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" enctype="multipart/form-data" id="testimonialForm">
            @csrf
            <input type="hidden" id="testimonial_id" name="id">
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="testimonialModalLabel">
                        <i class="fas fa-user-plus me-2"></i> Add Testimonial
                    </h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="testimonial_name" class="form-control" placeholder="Enter Name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                            <input type="text" name="role" id="testimonial_role" class="form-control" placeholder="Enter Role" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rating (1 to 5) <span class="text-danger">*</span></label>
                            <input type="range" name="rating" id="testimonial_rating" class="form-range" min="1" max="5" step="0.1" value="3">
                            <div class="d-flex justify-content-between small">
                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                            </div>
                            <div class="mt-2 text-muted">
                                Selected: <span id="ratingValue">3.0</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Profile Image <span class="text-danger">*</span></label>
                            <input type="file" accept=".jpg, .png, .jpeg" name="profile_image" id="testimonial_image" class="form-control" required>
                            <small class="text-muted d-block mt-1">Only <strong>PNG, JPEG, JPG</strong> formats. Max 2MB.</small>
                            <div id="imageError" class="text-danger mt-1" style="display:none;"></div>
                            <div id="imagePreview" class="mt-2"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="testimonial_description" class="form-control" rows="3" placeholder="Enter Description"></textarea>
                            <div class="text-muted small mt-1"><span id="charCount">0</span>/300 characters</div>
                        </div>

                        <div class="mb-3" id="statusField" style="display:none;">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" id="testimonial_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveTestimonialBtn" disabled>
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

<!-- View Testimonial Modal -->
<div class="modal fade" id="viewTestimonialModal" tabindex="-1" aria-labelledby="viewTestimonialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow-lg">

            <div class="modal-header bg-gradient-primary text-white border-0 rounded-top-3">
                <h5 class="modal-title fw-bold" id="viewTestimonialModalLabel">
                    <i class="fas fa-comment-dots me-2"></i> Testimonial Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body bg-light">
                <div class="bg-white p-4 rounded-3 shadow-sm">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                        <div class="d-flex align-items-center gap-3">
                            <img id="viewTestimonialImage" src="" alt="User"
                                class="rounded-circle border shadow-sm" width="80" height="80">
                            <div>
                                <h5 class="mb-0 fw-semibold" id="viewTestimonialName"></h5>
                                <small class="text-muted" id="viewTestimonialRole"></small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <div id="viewTestimonialRating" class="text-warning fs-5"></div>
                            <span class="fw-semibold text-dark" id="viewTestimonialRatingValue"></span>
                        </div>
                    </div>

                    <p class="text-muted fst-italic mb-4 text-center" id="viewTestimonialDescription" style="white-space: pre-line;"></p>

                    <div class="mt-4 text-center">
                        <span id="viewTestimonialStatus" class="badge px-3 py-2 fs-6 rounded-pill"></span>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
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
    function resetTestimonialModal() {
        $('#testimonialForm')[0].reset();
        $('#testimonial_id').val('');
        $('#imagePreview').html('');
        $('#testimonialModalLabel').text('Add Testimonial');
        $('#saveTestimonialBtn').text('Save').prop('disabled', true);
        $('#ratingValue').text(parseFloat($('#testimonial_rating').val()).toFixed(1));
        $('#statusField').hide();
        $('#wordCount').text(0);
    }

    $(document).on('click', '#addTestimonialBtn', function() {
        resetTestimonialModal();
        $('#testimonialForm').attr('action', "{{ route('admin.testimony.store') }}");
    });

    $(document).on('click', '.editTestimonyBtn', function(e) {
        e.preventDefault();
        resetTestimonialModal();
        $('#testimonialModalLabel').text('Edit Testimonial');
        $('#saveTestimonialBtn').text('Update');

        $('#testimonial_id').val($(this).data('id'));
        $('#testimonial_name').val($(this).data('name'));
        $('#testimonial_role').val($(this).data('role'));
        $('#testimonial_rating').val($(this).data('rating'));
        $('#testimonial_description').val($(this).data('description'));
        $('#testimonial_status').val($(this).data('status'));
        $('#ratingValue').text(parseFloat($(this).data('rating')).toFixed(1));

        $('#statusField').show();
        $('#testimonial_status').val($(this).data('status'));

        if ($(this).data('image')) {
            $('#imagePreview').html('<img src="/storage/' + $(this).data('image') + '" width="100" class="rounded-circle mt-2"/>');
        }

        $('#testimonialForm').attr('action', "{{ url('admin/testimony/update') }}/" + $(this).data('id'));

        let words = $('#testimonial_description').val().trim().split(/\s+/).filter(w => w.length > 0);
        $('#wordCount').text(words.length);

        new bootstrap.Modal(document.getElementById('testimonialModal')).show();
        $('#saveTestimonialBtn').prop('disabled', false);
    });

    $(document).on('click', '.viewTestimonialBtn', function() {
        $('#viewTestimonialName').text($(this).data('name'));
        $('#viewTestimonialRole').text($(this).data('role'));
        $('#viewTestimonialDescription').text($(this).data('description') || 'No description provided.');

        let status = $(this).data('status');
        let statusBadge = status == 1 ?
            '<span class="badge bg-success px-3 py-2 rounded-pill">Active</span>' :
            '<span class="badge bg-danger px-3 py-2 rounded-pill">Inactive</span>';
        $('#viewTestimonialStatus').html(statusBadge);

        const rating = parseFloat($(this).data('rating')) || 0;
        const fullStars = Math.floor(rating);
        const starsHtml = '★'.repeat(fullStars) + '☆'.repeat(5 - fullStars);
        $('#viewTestimonialRating').html(`<span class="fs-4 text-warning">${starsHtml}</span> <small class="text-muted">(${rating.toFixed(1)})</small>`);

        if ($(this).data('image')) {
            $('#viewTestimonialImage').attr('src', '/storage/' + $(this).data('image')).show();
        } else {
            $('#viewTestimonialImage').attr('src', '/images/no-user.png');
        }

        new bootstrap.Modal(document.getElementById('viewTestimonialModal')).show();
    });

    function validateImage() {
        let file = $('#testimonial_image')[0].files[0];
        let errorDiv = $('#imageError');
        let previewDiv = $('#imagePreview');
        let saveBtn = $('#saveTestimonialBtn');

        errorDiv.hide().text('');
        previewDiv.html('');
        saveBtn.prop('disabled', true);

        if (file) {
            let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                errorDiv.text('Invalid file type! Only JPEG, PNG, JPG are allowed.').show();
                $('#testimonial_image').val('');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                errorDiv.text('File size must not exceed 2MB.').show();
                $('#testimonial_image').val('');
                return;
            }

            let reader = new FileReader();
            reader.onload = function(e) {
                previewDiv.html('<img src="' + e.target.result + '" class="img-thumbnail mt-2" width="200">');
            }
            reader.readAsDataURL(file);
            saveBtn.prop('disabled', false);
        } else {
            errorDiv.text('Please select an image file.').show();
        }
    }

    $('#testimonial_image').on('change', validateImage);
    $('#testimonialForm input, #testimonialForm textarea').on('input', function() {
        $('#saveTestimonialBtn').prop('disabled', false);
    });
    $('#testimonial_rating').on('input', function() {
        $('#ratingValue').text(parseFloat($(this).val()).toFixed(1));
    });
    $('#testimonialForm').on('submit', function() {
        showPreloader();
    });

    function enforceCharLimit(textarea, countDisplay, limit) {
        textarea.on('input', function() {
            let value = $(this).val();
            if (value.length > limit) {
                $(this).val(value.substring(0, limit));
            }
            countDisplay.text($(this).val().length);
        });
    }

    enforceCharLimit($('#testimonial_description'), $('#charCount'), 300);
</script>
@endpush