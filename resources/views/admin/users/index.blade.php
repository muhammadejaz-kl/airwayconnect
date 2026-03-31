@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary"><i class="fas fa-user-circle me-2"></i> All Users</h4>
    </div>
    <div class="card shadow-sm border-0 rounded-4 mt-4">
        <div class="card-body">
            <div id="datatable-wrapper" class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-hover w-100']) !!}
            </div>
        </div>
    </div>
</div>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="userForm">
            @csrf
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="userModalTitle">Edit User</h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <input type="hidden" name="user_id" id="user_id">

                    <div class="mb-3">
                        <label for="user_name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="user_name" placeholder="Enter name" required>
                    </div>

                    <div class="mb-3">
                        <label for="user_email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="user_email" placeholder="Enter email" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="user_phone" class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" id="user_phone" placeholder="+91 9876543210" readonly>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveUserBtn">
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
    function resetUserModal() {
        $('#userForm')[0].reset();
        $('#user_id').val('');
        $('#userModalTitle').text('Edit User');
    }

    $(document).on('click', '.editUserBtn', function() {
        resetUserModal();

        const id = $(this).data('id');
        const name = $(this).data('name');
        const email = $(this).data('email');
        const phone_code = $(this).data('phone_code');
        const phone_number = $(this).data('phone_number');

        $('#user_id').val(id);
        $('#user_name').val(name);
        $('#user_email').val(email);
        $('#user_phone').val(`${phone_code} ${phone_number}`);

        $('#userForm').attr('action', "{{ url('admin/users/update') }}/" + id);
        $('#userModal').modal('show');
    });

    $('#userModal').on('hidden.bs.modal', function() {
        resetUserModal();
    });

    $('#userForm').on('submit', function() {
        showPreloader?.();
    });
</script>
@endpush