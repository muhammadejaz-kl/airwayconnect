@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">
            <i class="fas fa-layer-group me-2"></i> Resource Management
        </h4>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" id="addResourceBtn" data-bs-toggle="modal" data-bs-target="#resourceModal">
                <i class="fas fa-plus"></i> Add Resource
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
        </div>
    </div>
</div>

<div class="modal fade" id="resourceModal" tabindex="-1" aria-labelledby="resourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" enctype="multipart/form-data" id="resourceForm" action="{{ route('admin.resources.resourceStore') }}">
            @csrf 
            <input type="hidden" id="resource_id" name="id">

            <div class="modal-content shadow-lg rounded-3 border-0 overflow-hidden">
                <div class="modal-header bg-primary-color text-white py-3">
                    <h5 class="modal-title" id="resourceModalLabel">
                        <i class="fas fa-plus-circle"></i> Add Resource
                    </h5>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="resource_title" class="form-control rounded-pill" placeholder="Enter Resource Title" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="resource_description" class="form-control rounded-3" rows="3" placeholder="Enter Description"></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">About <span class="text-danger">*</span></label>
                            <textarea name="about" id="resource_about" class="form-control rounded-3" rows="3" placeholder="Enter About"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Banner <span class="text-danger">*</span></label>
                            <input type="file" name="banner" id="resource_banner" class="form-control rounded-pill">
                            <small class="text-muted d-block mt-1">
                                Only <strong>PNG, JPEG, JPG</strong> formats allowed. Max size: 2MB.
                            </small>
                            <div id="resourceBannerError" class="text-danger mt-1" style="display:none;"></div>
                            <div id="bannerPreview" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveResourceBtn" disabled>
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- View Resource Modal -->
<div class="modal fade" id="viewResourceModal" tabindex="-1" aria-labelledby="viewResourceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow rounded-4 border-0">

            <!-- Header -->
            <div class="modal-header bg-info text-white rounded-top-4">
                <h5 class="modal-title" id="viewResourceModalLabel">
                    <i class="fas fa-eye me-2"></i> View Resource
                </h5>
            </div>

            <!-- Body -->
            <div class="modal-body p-0">

                <!-- Banner Image -->
                <div class="position-relative" style="height:300px; overflow:hidden;">
                    <img id="view_banner" src="" class="w-100 h-100" style="object-fit:cover;" alt="Resource Banner">

                    <!-- Overlay Title + Description -->
                    <div class="position-absolute bottom-0 start-0 w-100 p-3"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">
                        <h3 id="view_title" class="fw-bold text-white mb-1"></h3>
                        <p id="view_description" class="text-white small mb-0" style="white-space: pre-line;"></p>
                    </div>
                </div>


                <!-- About Section -->
                <div class="p-4" style="max-height:250px; overflow-y:auto;">
                    <h5 class="fw-bold mb-2">About</h5>
                    <div id="view_about" class="small text-muted" style="white-space: pre-line;"></div>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 px-3 py-2">
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
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
<script>
    let aboutEditor;
    ClassicEditor
        .create(document.querySelector('#resource_about'))
        .then(editor => {
            aboutEditor = editor;
        })
        .catch(error => console.error(error));

    // Add Resource
    $('#addResourceBtn').click(function() {
        $('#resourceModalLabel').html('<i class="fas fa-plus-circle me-2"></i> Add Resource');
        $('#resourceForm').attr('action', '{{ route("admin.resources.resourceStore") }}');
        $('#resourceForm')[0].reset();
        $('#saveResourceBtn').text('Save').prop('disabled', true);
        $('#bannerPreview').html('');
        if (aboutEditor) aboutEditor.setData('');
    });

    // View Resource
    $(document).on('click', '.viewResourceBtn', function() {
        let data = $(this).data();

        $('#view_title').text(data.title);
        $('#view_description').text(data.description);
        $('#view_about').html(data.about);

        if (data.banner) {
            $('#view_banner').attr('src', '/storage/' + data.banner).show();
        } else {
            $('#view_banner').attr('src', '').hide();
        }

        $('#viewResourceModal').modal('show');
    });


    // Edit Resource
    $(document).on('click', '.editResourceBtn', function() {
        let resource = $(this).data();
        $('#resourceModalLabel').html('<i class="fas fa-edit me-2"></i> Edit Resource');
        let updateUrl = "{{ route('admin.resources.resourceUpdate', ':id') }}".replace(':id', resource.id);
        $('#resourceForm').attr('action', updateUrl);
        $('#resource_id').val(resource.id);
        $('#resource_title').val(resource.title);
        $('#resource_description').val(resource.description);
        if (aboutEditor) aboutEditor.setData(resource.about);
        $('#bannerPreview').html(
            resource.banner ? `<img src="/storage/${resource.banner}" class="img-fluid rounded mt-2" style="max-height:150px;">` :
            `<p class="text-muted mt-2">No banner available</p>`
        );
        $('#saveResourceBtn').text('Update').prop('disabled', false);
        $('#resourceModal').modal('show');
    });

    // On Submit - set about value
    $('#resourceForm').on('submit', function() {
        $('#resource_about').val(aboutEditor.getData());
        showPreloader();
    });

    // Banner validation
    function validateResourceBanner() {
        let file = $('#resource_banner')[0].files[0];
        let errorDiv = $('#resourceBannerError');
        let previewDiv = $('#bannerPreview');
        let saveBtn = $('#saveResourceBtn');

        errorDiv.hide().text('');
        previewDiv.html('');
        saveBtn.prop('disabled', true);

        if (file) {
            let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                errorDiv.text('Invalid file type! Only JPEG, PNG, JPG allowed.').show();
                $('#resource_banner').val('');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                errorDiv.text('File size must not exceed 2MB.').show();
                $('#resource_banner').val('');
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
    $('#resource_banner').on('change', validateResourceBanner);
</script>
@endpush