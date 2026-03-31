@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary"><i class="fas fa-layer-group me-2"></i> Resource Category Management</h4>
        <button class="btn btn-primary" id="addCategoryBtn" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="fas fa-plus"></i> Add Resource Category
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
        </div>
    </div>
</div>

<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" enctype="multipart/form-data" id="categoryForm">
            @csrf
            <input type="hidden" id="category_id" name="id">
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="categoryModalLabel"><i class="fas fa-plus-circle me-2"></i> Add Resource Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                <input type="text" name="title" id="category_title" class="form-control" placeholder="Enter Category Title" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Description<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="description" id="category_description" class="form-control" rows="3" placeholder="Enter Description"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold">Banner<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                                <input type="file" accept=".jpg, .png, .JPEG" name="banner" id="category_banner" class="form-control">
                            </div>
                            <small class="text-muted d-block mt-1">
                                Only <strong>PNG, JPEG, JPG</strong> formats are allowed.
                            </small>
                            <div id="bannerError" class="text-danger mt-1" style="display:none;"></div>
                            <div id="bannerPreview" class="mt-2"></div>

                            <div id="bannerPreview" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveCategoryBtn" disabled>
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

<div class="modal fade" id="viewCategoryModal" tabindex="-1" aria-labelledby="viewCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow rounded-4 border-0">

            <div class="modal-header bg-info text-white rounded-top-4">
                <h5 class="modal-title" id="viewCategoryModalLabel">
                    <i class="fas fa-eye me-2"></i> View Resource Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">

                <div class="position-relative" style="height:300px; overflow:hidden;">
                    <img id="viewCategoryBanner" src="" class="w-100 h-100" style="object-fit:cover;" alt="Category Banner">

                    <div class="position-absolute bottom-0 start-0 w-100 p-3"
                        style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">
                        <h3 id="viewCategoryTitle" class="fw-bold text-white mb-1"></h3>
                        <p id="viewCategoryDescription" class="text-white small mb-0" style="white-space: pre-line;"></p>
                    </div>
                </div>
            </div>

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
<script>
    function resetModal() {
        $('#categoryForm')[0].reset();
        $('#category_id').val('');
        $('#bannerPreview').html('');
        $('#categoryModalLabel').text('Add Resource Category');
        $('#saveCategoryBtn').text('Save');
    }

    $(document).on('click', '#addCategoryBtn', function() {
        resetModal();
        $('#categoryForm').attr('action', "{{ route('admin.resources.category.store') }}");
    });

    $(document).on('click', '.editCategoryBtn', function() {
        resetModal();
        $('#categoryModalLabel').text('Edit Resource Category');
        $('#saveCategoryBtn').text('Update');

        $('#category_id').val($(this).data('id'));
        $('#category_title').val($(this).data('title'));
        $('#category_description').val($(this).data('description'));
        if ($(this).data('banner')) {
            $('#bannerPreview').html('<img src="/storage/' + $(this).data('banner') + '" width="250" class="rounded mt-2"/>');
        }

        $('#categoryForm').attr('action', "{{ url('admin/resources/category/update') }}/" + $(this).data('id'));
        $('#categoryModal').modal('show');
        $('#saveCategoryBtn').prop('disabled', false)
    });

    $(document).on('click', '.viewCategoryBtn', function() {
        const title = $(this).data('title');
        const description = $(this).data('description');
        const banner = $(this).data('banner');

        $('#viewCategoryTitle').text(title);
        $('#viewCategoryDescription').text(description || 'No description available');

        if (banner) {
            $('#viewCategoryBanner').attr('src', '/storage/' + banner).show();
        } else {
            $('#viewCategoryBanner').attr('src', '/images/no-image.png');
        }

        $('#viewCategoryModal').modal('show');
    });

    $('#categoryForm').on('submit', function() {
        showPreloader();
    });

    function validateBanner() {
        let file = $('#category_banner')[0].files[0];
        let errorDiv = $('#bannerError');
        let previewDiv = $('#bannerPreview');
        let saveBtn = $('#saveCategoryBtn');

        errorDiv.hide().text('');
        previewDiv.html('');
        saveBtn.prop('disabled', false);  

        if (file) {
            let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                errorDiv.text('Invalid file type! Only JPEG, PNG, JPG are allowed.').show();
                $('#category_banner').val('');
                return;
            }

            if (file.size > 2 * 1024 * 1024) {  
                errorDiv.text('File size must not exceed 2MB.').show();
                $('#category_banner').val('');
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

    $('#category_banner').on('change', validateBanner);
</script>
@endpush