@extends('admin.layouts.master')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="fas fa-tags me-2"></i> Coupons
            </h4>
            <button class="btn btn-primary" id="addCouponBtn" data-bs-toggle="modal" data-bs-target="#couponModal">
                <i class="fas fa-plus"></i> Add Coupon
            </button>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
            </div>
        </div>
    </div>

    <!-- Add/Edit Coupon Modal -->
    <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="couponForm" action="{{ route('admin.coupons.store') }}">
                @csrf
                <input type="hidden" id="coupon_id" name="id">
                <div class="modal-content shadow rounded-4 border-0">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title fw-bold" id="couponModalLabel">
                            <i class="fas fa-plus me-2"></i> Add Coupon
                        </h5>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Coupon Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="coupon_name" class="form-control"
                                    placeholder="Enter Coupon Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Coupon Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="coupon_code" class="form-control"
                                    placeholder="Enter Coupon Code" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Discount (%) <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="discount" id="coupon_discount" class="form-control"
                                    placeholder="Enter Discount %" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" id="coupon_description" class="form-control"
                                    placeholder="Enter Description"></textarea>
                            </div>
                            <div class="col-md-6" id="statusField" style="display:none;">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" id="coupon_status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 py-3">
                        <button type="submit" class="btn btn-primary px-4" id="saveCouponBtn">
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
        $('#addCouponBtn').on('click', function () {
            $('#couponForm').attr('action', "{{ route('admin.coupons.store') }}");
            $('#couponModalLabel').html('<i class="fas fa-plus me-2"></i> Add Coupon');
            $('#saveCouponBtn').html('<i class="fas fa-save me-1"></i> Save');
            $('#coupon_id').val('');
            $('#coupon_name').val('');
            $('#coupon_code').val('');
            $('#coupon_discount').val('');
            $('#coupon_description').val('');
            $('#statusField').hide();
        });

        $(document).on('click', '.editCouponBtn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let code = $(this).data('code');
            let discount = $(this).data('discount');
            let description = $(this).data('description');
            let status = $(this).data('status');

            $('#couponForm').attr('action', `/admin/coupons/update/${id}`);
            $('#couponModalLabel').html('<i class="fas fa-edit me-2"></i> Edit Coupon');
            $('#saveCouponBtn').html('<i class="fas fa-save me-1"></i> Update');
            $('#coupon_id').val(id);
            $('#coupon_name').val(name);
            $('#coupon_code').val(code);
            $('#coupon_discount').val(discount);
            $('#coupon_description').val(description);
            $('#coupon_status').val(status);
            $('#statusField').show();

            $('#couponModal').modal('show');
        });

        $('#couponForm').on('submit', function () {
            showPreloader();
        });
    </script>
@endpush