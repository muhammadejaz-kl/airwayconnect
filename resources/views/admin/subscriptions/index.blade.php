@extends('admin.layouts.master')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary">
                <i class="fas fa-bookmark me-2"></i> Subscription Plans
            </h4>
            <button class="btn btn-primary" id="addPlanBtn" data-bs-toggle="modal" data-bs-target="#planModal">
                <i class="fas fa-plus"></i> Add Plan
            </button>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
            </div>
        </div>
    </div>

    <!-- Add/Edit Plan Modal -->
    <div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" enctype="multipart/form-data" id="planForm"
                action="{{ route('admin.subscriptions.store') }}">
                @csrf
                <input type="hidden" id="plan_id" name="id">
                <div class="modal-content shadow rounded-4 border-0">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title fw-bold" id="planModalLabel">
                            <i class="fas fa-plus me-2"></i> Add Plan
                        </h5>
                    </div>

                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Plan Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="plan_name" class="form-control"
                                    placeholder="Enter Plan Name" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Validity <span class="text-danger">*</span></label>
                                <select name="validity" id="plan_validity" class="form-select" required>
                                    <option value="">Select Validity</option>
                                    <option value="1_month">Per Month</option>
                                    <option value="1_year">Per Year</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Amount ($) <span class="text-danger">*</span></label>
                                <input type="number" name="amount" id="plan_amount" class="form-control"
                                    placeholder="Enter Amount" required step="0.01" min="0">
                            </div>

                            <div class="col-md-6" id="statusField" style="display:none;">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" id="plan_status" class="form-select" style="height: 45px;">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Features</label>
                                <small class="text-muted d-block mb-2">Add highlights for this plan</small>
                                <div id="featuresWrapper">
                                    <div class="input-group mb-2 feature-input">
                                        <span class="input-group-text bg-info text-white feature-number">1</span>
                                        <input type="text" name="features[]" class="form-control"
                                            placeholder="Enter Feature">
                                        <button type="button" class="btn btn-success addFeatureBtn"><i
                                                class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 py-3">
                        <button type="submit" class="btn btn-primary px-4" id="savePlanBtn">
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

    <!-- View Plan Modal -->
    <div class="modal fade" id="viewPlanModal" tabindex="-1" aria-labelledby="viewPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" id="viewPlanModalLabel">
                        <i class="fas fa-eye me-2"></i> View Plan
                    </h5>
                </div>

                <div class="modal-body px-4">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-3 p-2">
                                <h6 class="fw-semibold text-muted">Plan Name</h6>
                                <p class="fw-bold mb-0" id="view_plan_name"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-3 p-2">
                                <h6 class="fw-semibold text-muted">Validity</h6>
                                <p class="fw-bold mb-0" id="view_plan_validity"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-3 p-2">
                                <h6 class="fw-semibold text-muted">Amount ($)</h6>
                                <p class="fw-bold mb-0" id="view_plan_amount"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-3 p-2">
                                <h6 class="fw-semibold text-muted">Status</h6>
                                <p class="fw-bold mb-0" id="view_plan_status"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-3 p-2">
                                <h6 class="fw-semibold text-muted">Features</h6>
                                <ul id="view_plan_features" class="list-group list-group-flush mt-2"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4">
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
        function updateFeatureNumbers() {
            $('#featuresWrapper .feature-number').each(function (index) {
                $(this).text(index + 1);
            });
        }

        $('#addPlanBtn').on('click', function () {
            $('#planForm').attr('action', "{{ route('admin.subscriptions.store') }}");
            $('#planModalLabel').html('<i class="fas fa-plus me-2"></i> Add Plan');
            $('#savePlanBtn').html('<i class="fas fa-save me-1"></i> Save');
            $('#plan_id').val('');
            $('#plan_name').val('');
            $('#plan_validity').val('');
            $('#plan_amount').val('');
            $('#statusField').hide();
            $('#featuresWrapper').html(`
                        <div class="input-group mb-2 feature-input">
                            <span class="input-group-text bg-info text-white feature-number">1</span>
                            <input type="text" name="features[]" class="form-control" placeholder="Enter Feature">
                            <button type="button" class="btn btn-success addFeatureBtn"><i class="fas fa-plus"></i></button>
                        </div>
                        `);
            updateFeatureNumbers();
        });

        $(document).on('click', '.addFeatureBtn', function () {
            $('#featuresWrapper').append(`
                        <div class="input-group mb-2 feature-input">
                            <span class="input-group-text bg-info text-white feature-number"></span>
                            <input type="text" name="features[]" class="form-control" placeholder="Enter Feature">
                            <button type="button" class="btn btn-danger removeFeatureBtn"><i class="fas fa-minus"></i></button>
                        </div>
                        `);
            updateFeatureNumbers();
        });

        $(document).on('click', '.removeFeatureBtn', function () {
            $(this).closest('.feature-input').remove();
            updateFeatureNumbers();
        });

        $(document).on('click', '.editForumBtn', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let validity = $(this).data('description');
            let amount = $(this).data('banner');
            let features = $(this).data('topics') || [];
            let status = $(this).data('status');

            $('#planForm').attr('action', `/admin/subscriptions/update/${id}`);
            $('#planModalLabel').html('<i class="fas fa-edit me-2"></i> Edit Plan');
            $('#savePlanBtn').html('<i class="fas fa-save me-1"></i> Update');
            $('#plan_id').val(id);
            $('#plan_name').val(name);
            $('#plan_validity').val(validity);
            $('#plan_amount').val(amount);
            $('#plan_status').val(status);
            $('#statusField').show();

            let featuresHtml = '';
            if (features.length > 0) {
                features.forEach((feature, index) => {
                    let removeBtn = index === 0
                        ? `<button type="button" class="btn btn-success addFeatureBtn"><i class="fas fa-plus"></i></button>`
                        : `<button type="button" class="btn btn-danger removeFeatureBtn"><i class="fas fa-minus"></i></button>`;
                    featuresHtml += `
                                <div class="input-group mb-2 feature-input">
                                    <span class="input-group-text bg-info text-white feature-number"></span>
                                    <input type="text" name="features[]" class="form-control" value="${feature}" placeholder="Enter Feature">
                                    ${removeBtn}
                                </div>
                            `;
                });
            } else {
                featuresHtml = `
                            <div class="input-group mb-2 feature-input">
                                <span class="input-group-text bg-info text-white feature-number">1</span>
                                <input type="text" name="features[]" class="form-control" placeholder="Enter Feature">
                                <button type="button" class="btn btn-success addFeatureBtn"><i class="fas fa-plus"></i></button>
                            </div>
                        `;
            }

            $('#featuresWrapper').html(featuresHtml);
            updateFeatureNumbers();

            $('#planModal').modal('show');
        });

        $(document).on('click', '.editCategoryBtn', function () {
            let name = $(this).data('name');
            let validity = $(this).data('description');
            let amount = $(this).data('banner');
            let features = $(this).data('topics') || [];
            let status = $(this).data('status') == 1 ? 'Active' : 'Inactive';

            $('#view_plan_name').text(name);
            $('#view_plan_validity').text(validity === '1_month' ? 'Per Month' : 'Per Year');
            $('#view_plan_amount').text(amount);
            $('#view_plan_status').text(status);

            let featuresHtml = '';
            if (features.length > 0) {
                features.forEach((feature, index) => {
                    featuresHtml += `
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="badge bg-info me-3">${index + 1}</span>
                                    <span>${feature}</span>
                                </li>`;
                });
            } else {
                featuresHtml = '<li class="list-group-item text-muted">No features added</li>';
            }

            $('#view_plan_features').html(featuresHtml);

            $('#viewPlanModal').modal('show');
        });

        updateFeatureNumbers();

        $('#planForm').on('submit', function () {
            showPreloader();
        });
    </script>
@endpush