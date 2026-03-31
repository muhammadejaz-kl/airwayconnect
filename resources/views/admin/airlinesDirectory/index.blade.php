@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">
            <i class="fas fa-plane me-2"></i> Airline Directory
        </h4>
        <button class="btn btn-primary" id="addAirlineBtn" data-bs-toggle="modal" data-bs-target="#airlineModal">
            <i class="fas fa-plus"></i> Add Airline
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
        </div>
    </div>
</div>

<div class="modal fade" id="airlineModal" tabindex="-1" aria-labelledby="airlineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" enctype="multipart/form-data" id="airlineForm" action="{{ route('admin.airlinesDirectory.store') }}">
            @csrf
            <input type="hidden" id="airline_id" name="id">
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="airlineModalLabel">
                        <i class="fas fa-edit me-2"></i> Add Airline
                    </h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Airline Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="airline_name" class="form-control" placeholder="Enter Airline Name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Logo</label>
                            <input type="file" accept=".jpg, .png, .jpeg" name="logo" id="airline_logo" class="form-control">
                            <small class="text-muted d-block mt-1">Only PNG, JPEG, JPG. Max 2MB.</small>
                            <div id="logoPreview" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveAirlineBtn">
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

<div class="modal fade" id="viewAirlineModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-info text-white border-0 rounded-top-4">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-plane me-2"></i> Airline Details
                </h5>
            </div>
            <div class="modal-body text-center px-4 py-4">
                <div class="mb-3">
                    <img id="viewAirlineLogo" src="" alt="Logo" class="rounded-circle border shadow-sm" width="150" height="150">
                </div>
                <h4 class="fw-bold text-dark mb-2" id="viewAirlineName"></h4>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
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
    $('#addAirlineBtn').on('click', function() {
        $('#airlineForm').attr('action', "{{ route('admin.airlinesDirectory.store') }}");
        $('#airlineModalLabel').html('<i class="fas fa-plus me-2"></i> Add Airline');
        $('#saveAirlineBtn').html('<i class="fas fa-save me-1"></i> Save');
        $('#airline_id').val('');
        $('#airline_name').val('');
        $('#airline_logo').val('');
        $('#logoPreview').html('');
    });

    $(document).on('click', '.editAirlineBtn', function() {
        $('#airlineModalLabel').html('<i class="fas fa-edit me-2"></i> Edit Airline');
        $('#saveAirlineBtn').html('<i class="fas fa-sync-alt me-1"></i> Update');
        $('#airline_id').val($(this).data('id'));
        $('#airline_name').val($(this).data('name'));
        if ($(this).data('logo')) {
            $('#logoPreview').html('<img src="/storage/' + $(this).data('logo') + '" width="100" class="rounded mt-2"/>');
        }
        $('#airlineForm').attr('action', "{{ url('admin/airlines-directory/update') }}/" + $(this).data('id'));
        new bootstrap.Modal(document.getElementById('airlineModal')).show();
    });

    $('#airlineForm').on('submit', function() {
        showPreloader();
    });

    $(document).on('click', '.viewAirlineBtn', function() {
        $('#viewAirlineName').text($(this).data('name'));
        if ($(this).data('logo')) {
            $('#viewAirlineLogo').attr('src', '/storage/' + $(this).data('logo'));
        } else {
            $('#viewAirlineLogo').attr('src', '/images/no-logo.png');
        }
        new bootstrap.Modal(document.getElementById('viewAirlineModal')).show();
    });
</script>
@endpush