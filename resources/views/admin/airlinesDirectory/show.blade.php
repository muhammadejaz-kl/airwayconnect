@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ $airline->logo ? asset('storage/' . $airline->logo) : asset('images/no-logo.png') }}"
                alt="Logo"
                class="rounded-circle border shadow-sm me-3"
                style="width:80px; height:80px; object-fit:cover;">
            <h4 class="fw-bold text-primary mb-0">{{ $airline->name }}</h4>
            <h4 class="fw-bold text-dark mb-0">/Details</h4>
        </div>

        <div class="d-flex gap-2">
            @if($airline->details->isEmpty())
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDetailsModal">
                <i class="fas fa-plus me-1"></i> Add Details
            </button>
            @endif

            <a href="{{ route('admin.airlinesDirectory.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
        </div>
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="addDetails" action="{{ route('admin.airlinesDirectory.storeDetails') }}">
            @csrf
            <input type="hidden" name="airline_id" value="{{ $airline->id }}">
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i> Add Airline Details</h5>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Part <span class="text-danger">*</span></label>
                            <input type="text" name="part" class="form-control" placeholder="Enter Part" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Airlines Type <span class="text-danger">*</span></label>
                            <select name="airlines_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="Cargo">Cargo</option>
                                <option value="Passenger">Passenger</option>
                                <option value="Combi">Combi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Job Type <span class="text-danger">*</span></label>
                            <select name="job_type" class="form-control" required>
                                <option value="">Select Job Type</option>
                                <option value="FullTime">Full-Time</option>
                                <option value="PartTime">Part-Time</option>
                                <option value="Remote">Remote</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Schedule Type <span class="text-danger">*</span></label>
                            <input type="text" name="schedule_type" class="form-control" placeholder="Enter Schedule type" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">401k Option <span class="text-danger">*</span></label>
                            <select name="option_401k" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Flight Benefits <span class="text-danger">*</span></label>
                            <select name="flight_benefits" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" id="descriptionEditor" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Save</button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="editDetailForm">
            @csrf
            @method('POST')
            <input type="hidden" name="detail_id" id="editDetailId">
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-dark">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i> Edit Airline Detail</h5>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Part</label>
                        <input type="text" name="part" id="editPart" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Airlines Type</label>
                        <select name="airlines_type" id="editAirlinesType" class="form-control" required>
                            <option value="Cargo">Cargo</option>
                            <option value="Passenger">Passenger</option>
                            <option value="Combi">Combi</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Job Type</label>
                        <select name="job_type" id="editJobType" class="form-control" required>
                            <option value="FullTime">Full-Time</option>
                            <option value="PartTime">Part-Time</option>
                            <option value="Remote">Remote</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Schedule Type</label>
                        <input type="text" name="schedule_type" id="editScheduleType" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>401k Option</label>
                        <select name="option_401k" id="edit401k" class="form-control" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Flight Benefits</label>
                        <select name="flight_benefits" id="editFlight" class="form-control" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label>Description</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Update</button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i> Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- View Modal --}}
<div class="modal fade" id="viewDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow rounded-4 border-0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-eye me-2"></i> Airline Detail</h5>
            </div>
            <div class="modal-body">
                <p><strong>Part:</strong> <span id="detailPart"></span></p>
                <p><strong>Airlines Type:</strong> <span id="detailType"></span></p>
                <p><strong>Job Type:</strong> <span id="detailJob"></span></p>
                <p><strong>Schedule Type:</strong> <span id="detailSchedule"></span></p>
                <p><strong>401k Option:</strong> <span id="detail401k"></span></p>
                <p><strong>Flight Benefits:</strong> <span id="detailFlight"></span></p>
                <p><strong>Description:</strong></p>
                <div id="detailDescription"></div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let addEditor, editEditor;

    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor.create(document.querySelector('#descriptionEditor')).then(editor => addEditor = editor);
        ClassicEditor.create(document.querySelector('#editDescription')).then(editor => editEditor = editor);

        // View Detail
        $(document).on('click', '.viewDetailBtn', function() {
            $('#detailPart').text($(this).data('part'));
            $('#detailType').text($(this).data('airlines_type'));
            $('#detailJob').text($(this).data('job_type'));
            $('#detailSchedule').text($(this).data('schedule_type'));
            $('#detail401k').text($(this).data('option_401k'));
            $('#detailFlight').text($(this).data('flight_benefits'));
            $('#detailDescription').html($(this).data('description'));
            $('#viewDetailModal').modal('show');
        });

        // Edit Detail
        $(document).on('click', '.editDetailBtn', function() {
            $('#editDetailId').val($(this).data('id'));
            $('#editPart').val($(this).data('part'));
            $('#editAirlinesType').val($(this).data('airlines_type'));
            $('#editJobType').val($(this).data('job_type'));
            $('#editScheduleType').val($(this).data('schedule_type'));
            $('#edit401k').val($(this).data('option_401k'));
            $('#editFlight').val($(this).data('flight_benefits'));
            if (editEditor) editEditor.setData($(this).data('description'));
            $('#editDetailForm').attr('action', '/admin/airlines-directory/updateDetails/' + $(this).data('id'));
            $('#editDetailModal').modal('show');
        });

        $('#addDetails').on('submit', function(e) {
            let part = $('input[name="part"]').val().trim();
            let schedule_type = $('input[name="schedule_type"]').val().trim();
            let description = addEditor ? addEditor.getData().trim() : '';

            if (part === '' || description === '' || schedule_type === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Cannot save empty or just spaces.'
                });
                return false;
            }

            showPreloader();
        });

        $('#editDetailForm').on('submit', function(e) {
            let part = $('#editPart').val().trim();
            let schedule_type = $('#editScheduleType').val().trim();
            let description = editEditor ? editEditor.getData().trim() : '';

            if (part === '' || description === '' || schedule_type === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Cannot update empty or just spaces.'
                });
                return false;
            }

            showPreloader();
        });

    });
</script>
@endpush