@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary"><i class="fas fa-cogs me-2"></i> Skills Categories</h4>
        <button class="btn btn-primary" id="addCategoryBtn" data-bs-toggle="modal" data-bs-target="#categoryModal">
            <i class="fas fa-plus"></i> Add Category
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
        </div>
    </div>
</div>
 
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="categoryForm">
            @csrf
            <input type="hidden" id="category_id" name="id">

            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="categoryModalLabel"><i class="fas fa-plus-circle me-2"></i> Add Category</h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" name="name" id="category_name" class="form-control" placeholder="Enter Category Name" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveCategoryBtn">
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
        $('#categoryForm')[0].reset();
        $('#category_id').val('');
        $('#categoryModalLabel').text('Add Category');
        $('#saveCategoryBtn').text('Save');
    }
 
    $('#addCategoryBtn').click(function() {
        resetModal();
        $('#categoryForm').attr('action', "{{ route('admin.resumeSkill.category.store') }}");
    });
 
    $(document).on('click', '.editCategoryBtn', function() {
        resetModal();
        $('#categoryModalLabel').text('Edit Category');
        $('#saveCategoryBtn').text('Update Category');

        $('#category_id').val($(this).data('id'));
        $('#category_name').val($(this).data('name'));

        $('#categoryForm').attr('action', "{{ url('admin/resume-skills/category/update') }}/" + $(this).data('id'));

        $('#categoryModal').modal('show');
    });

    $('#categoryModal').on('hidden.bs.modal', function() {
        resetModal();
    });

    $('#categoryForm').on('submit', function() {
        showPreloader();
    });
</script>
@endpush