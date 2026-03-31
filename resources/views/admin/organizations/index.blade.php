@extends('admin.layouts.master')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="fas fa-globe"></i> Organizations
            </h4>
            <button class="btn btn-primary" id="addOrganizationBtn" data-bs-toggle="modal"
                data-bs-target="#organizationModal">
                <i class="fas fa-plus"></i> Add Organization
            </button>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
            </div>
        </div>
    </div>

    <!-- Organization Modal -->
    <div class="modal fade" id="organizationModal" tabindex="-1" aria-labelledby="organizationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" enctype="multipart/form-data" id="organizationForm"
                action="{{ route('admin.organizations.store') }}">
                @csrf
                <input type="hidden" id="organization_id" name="id">
                <div class="modal-content shadow rounded-4 border-0">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title" id="organizationModalLabel">
                            <i class="fas fa-building me-2"></i> Add Organization
                        </h5>
                    </div>

                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="organization_name" class="form-control"
                                    placeholder="Enter Organization Name" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                                <input type="text" name="type" id="organization_type" class="form-control"
                                    placeholder="E.g. NGO, Private, Government" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sector</label>
                                <input type="text" name="sector" id="organization_sector" class="form-control"
                                    placeholder="E.g. Healthcare, Education, IT">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Established</label>
                                <input type="text" name="established" id="organization_established" class="form-control"
                                    placeholder="Select Established Date">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Logo</label>
                                <input type="file" accept=".jpg, .png, .jpeg" name="logo" id="organization_logo"
                                    class="form-control">
                                <small class="text-muted d-block mt-1">Only PNG, JPEG, JPG. Max 2MB.</small>
                                <div id="logoPreview" class="mt-2"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Link <span class="text-danger">*</span></label>
                                <input type="text" name="link" id="organization_link" class="form-control"
                                    placeholder="Enter Organization Link" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Purpose</label>
                                <input type="text" name="purpose" id="organization_purpose" class="form-control"
                                    placeholder="Enter Purpose of Organization">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Description / About</label>
                                <textarea name="description" id="organization_description" class="form-control" rows="3"
                                    placeholder="Enter Description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 py-3">
                        <button type="submit" class="btn btn-primary px-4" id="saveOrganizationBtn">
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

    <!-- View Modal -->
    <div class="modal fade" id="viewOrganizationModal" tabindex="-1">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header bg-info text-white border-0 rounded-top-4">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-building me-2"></i> Organization Details
                    </h5>
                </div>
                <div class="modal-body text-center px-4 py-4">
                    <div class="mb-3">
                        <img id="viewOrganizationLogo" src="" alt="Logo" class="rounded-circle border shadow-sm" width="150"
                            height="150">
                    </div>
                    <h4 class="fw-bold text-dark mb-2" id="viewOrganizationName"></h4>
                    <p id="viewOrganizationType" class="mb-1"></p>
                    <p id="viewOrganizationSector" class="mb-1"></p>
                    <p id="viewOrganizationLink" class="mb-1"></p>
                    <p id="viewOrganizationPurpose" class="mb-1"></p>
                    <p id="viewOrganizationEstablished" class="mb-1"></p>
                    <p id="viewOrganizationDescription" class="mb-0 text-muted"></p>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        let descriptionEditor;

        ClassicEditor.create(document.querySelector('#organization_description'))
            .then(editor => descriptionEditor = editor)
            .catch(error => console.error(error));

        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#organization_established", {
                dateFormat: "Y-m-d",
                maxDate: "today",
                altInput: true,
                altFormat: "F j, Y",
                allowInput: true,
                defaultDate: "today"
            });
        });

        $('#addOrganizationBtn').on('click', function () {
            $('#organizationForm').attr('action', "{{ route('admin.organizations.store') }}");
            $('#organizationModalLabel').html('<i class="fas fa-building me-2"></i> Add Organization');
            $('#saveOrganizationBtn').html('<i class="fas fa-save me-1"></i> Save');
            $('#organizationForm')[0].reset();
            $('#organization_id').val('');
            $('#logoPreview').html('');
            if (descriptionEditor) descriptionEditor.setData('');
        });

        $(document).on('click', '.editOrganizationBtn', function () {
            $('#organizationModalLabel').html('<i class="fas fa-edit me-2"></i> Edit Organization');
            $('#saveOrganizationBtn').html('<i class="fas fa-sync-alt me-1"></i> Update');
            $('#organization_id').val($(this).data('id'));
            $('#organization_name').val($(this).data('name'));
            $('#organization_type').val($(this).data('type'));
            $('#organization_sector').val($(this).data('sector'));
            $('#organization_link').val($(this).data('link'));
            $('#organization_purpose').val($(this).data('purpose'));
            $('#organization_established').val($(this).data('established'));

            if (descriptionEditor) descriptionEditor.setData($(this).data('description') || '');

            if ($(this).data('logo')) {
                $('#logoPreview').html('<img src="/storage/' + $(this).data('logo') + '" width="100" class="rounded mt-2"/>');
            }

            $('#organizationForm').attr('action', "{{ url('admin/organizations/update') }}/" + $(this).data('id'));
            new bootstrap.Modal(document.getElementById('organizationModal')).show();
        });

        $('#organizationForm').on('submit', function () {
            if (descriptionEditor) {
                $('#organization_description').val(descriptionEditor.getData());
            }
            showPreloader();
        });

        $(document).on('click', '.viewOrganizationBtn', function () {
            $('#viewOrganizationName').text($(this).data('name'));
            $('#viewOrganizationType').text('Type: ' + ($(this).data('type') || 'N/A'));
            $('#viewOrganizationSector').text('Sector: ' + ($(this).data('sector') || 'N/A'));
            $('#viewOrganizationLink').text('Link: ' + ($(this).data('link') || 'N/A'));
            $('#viewOrganizationPurpose').text('Purpose: ' + ($(this).data('purpose') || 'N/A'));
            $('#viewOrganizationEstablished').text('Established: ' + ($(this).data('established') || 'N/A'));
            $('#viewOrganizationDescription').html($(this).data('description') || 'No description available');

            if ($(this).data('logo')) {
                $('#viewOrganizationLogo').attr('src', '/storage/' + $(this).data('logo'));
            } else {
                $('#viewOrganizationLogo').attr('src', '/images/no-logo.png');
            }

            new bootstrap.Modal(document.getElementById('viewOrganizationModal')).show();
        });
    </script>
@endpush