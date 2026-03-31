@extends('admin.layouts.master')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary"> <i data-feather="dollar-sign"></i> All Transactions</h4>
        </div>
        <div class="card shadow-sm border-0 rounded-4 mt-4">
            <div class="card-body">
                <div id="datatable-wrapper" class="table-responsive">
                    {!! $dataTable->table(['class' => 'table table-striped table-hover w-100']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">

                {{-- Header --}}
                <div class="modal-header bg-gradient-primary text-white border-0">
                    <h5 class="modal-title"><i class="fas fa-receipt me-2"></i> Transaction Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body p-4">
                    <div class="row g-4">

                        {{-- User Info --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm text-center py-4 h-100">
                                <i class="fas fa-user-circle fa-3x text-primary mb-2"></i>
                                <h5 id="modal_username" class="fw-bold mb-1"></h5>
                                <p class="text-muted mb-0">User Info</p>
                            </div>
                        </div>

                        {{-- Plan Info --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body-ts">
                                    <h6 class="text-primary fw-bold mb-3">
                                        <i class="fas fa-layer-group me-1"></i> Plan Details
                                    </h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            Name <span id="modal_plan_name" class="fw-semibold"></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            Validity <span id="modal_plan_validity" class="fw-semibold"></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            Amount <span id="modal_plan_amount" class="fw-semibold"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Coupon Info --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body-ts">
                                    <h6 class="text-success fw-bold mb-3">
                                        <i class="fas fa-ticket-alt me-1"></i> Coupon
                                    </h6>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between">
                                            Code <span id="modal_coupon_code" class="fw-semibold"></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            Discount <span id="modal_coupon_discount" class="fw-semibold"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Transaction Info --}}
                        <div class="col-12 mt-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body-ts">
                                    <h6 class="text-warning fw-bold mb-3">
                                        <i class="fas fa-credit-card me-1"></i> Transaction Info
                                    </h6>
                                    <div class="row g-3 m-2">
                                        <div class="col-md-3">
                                            <p class="text-muted mb-1">Transaction ID</p>
                                            <p class="fw-semibold" id="modal_transaction_id"></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="text-muted mb-1">Original Amount</p>
                                            <p class="fw-semibold" id="modal_original_amount"></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="text-muted mb-1">Discount Applied</p>
                                            <p class="fw-semibold text-success" id="modal_discount_amount"></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="text-muted mb-1">Paid Amount</p>
                                            <p class="fw-semibold text-primary" id="modal_paid_amount"></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="text-muted mb-1">Payment Status</p>
                                            <span id="modal_payment_status" class="badge rounded-pill"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <p class="text-muted mb-1">Date</p>
                                            <p class="fw-semibold" id="modal_created_at"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function () {
            $(document).on('click', '.viewTransactionBtn', function () {
                $('#modal_username').text($(this).data('username'));

                // Plan info
                let planAmount = parseFloat($(this).data('plan_amount')) || 0;
                $('#modal_plan_name').text($(this).data('plan_name'));
                $('#modal_plan_validity').text($(this).data('plan_validity'));
                $('#modal_plan_amount').text('$' + planAmount.toFixed(2));

                // Coupon info
                let couponCode = $(this).data('coupon_code');
                let couponDiscount = parseFloat($(this).data('coupon_discount')) || 0;
                $('#modal_coupon_code').text(couponCode ? couponCode : 'N/A');
                $('#modal_coupon_discount').text(couponDiscount > 0 ? couponDiscount + '%' : '0%');

                // Discount calculation
                let discountAmount = couponDiscount > 0 ? (planAmount * couponDiscount / 100) : 0;
                let paidAmount = parseFloat($(this).data('paid_amount')) || (planAmount - discountAmount);

                $('#modal_original_amount').text('$' + planAmount.toFixed(2));
                $('#modal_discount_amount').text('- $' + discountAmount.toFixed(2));
                $('#modal_paid_amount').text('$' + paidAmount.toFixed(2));

                // Transaction info
                $('#modal_transaction_id').text($(this).data('transaction_id'));
                let status = $(this).data('payment_status');
                let badgeClass = status === 'paid' ? 'bg-success' : 'bg-danger';
                $('#modal_payment_status').removeClass('bg-success bg-danger').addClass(badgeClass).text(status.toUpperCase());
                $('#modal_created_at').text($(this).data('created_at'));

                $('#transactionModal').modal('show');
            });
        });
    </script>

@endpush