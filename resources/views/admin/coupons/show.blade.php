@extends('admin.layouts.master')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary mb-0">
                <i class="fas fa-tags me-2"></i> Coupon Details
            </h4>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary px-4">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

        {{-- Coupon Information --}}
        <div class="coupon-info card border-0 rounded-4 shadow-sm mb-4" style="background:#fff;">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Coupon Information</h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button"
                            class="btn btn-sm btn-primary rounded-3 editCouponBtn"
                            data-id="{{ $coupon->id }}"
                            data-name="{{ $coupon->name }}"
                            data-code="{{ $coupon->code }}"
                            data-discount="{{ $coupon->discount }}"
                            data-description="{{ $coupon->description }}"
                            data-status="{{ $coupon->status }}"
                            data-bs-toggle="modal"
                            data-bs-target="#couponModal"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button"
                            class="btn btn-sm btn-danger rounded-3 delete-btn"
                            data-url="{{ route('admin.coupons.destroy', $coupon->id) }}"
                            data-name="{{ $coupon->name }}"
                            title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Coupon Name:</div>
                        <div class="fw-semibold">{{ $coupon->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Coupon Code:</div>
                        <div class="fw-semibold">{{ $coupon->code }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Discount %:</div>
                        <div class="fw-semibold">{{ number_format($coupon->discount, 2) }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Status:</div>
                        <span class="badge rounded-pill px-3 py-2 {{ $coupon->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $coupon->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Created On:</div>
                        <div class="fw-semibold">{{ $coupon->created_at ? $coupon->created_at->format('d M Y H:i') : 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Last Used:</div>
                        <div class="fw-semibold">
                            {{ $lastUsedAt ? \Carbon\Carbon::parse($lastUsedAt)->format('d M Y H:i') : 'Never' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Growth Trend --}}
        <div class="row">
            <div class="col-lg-7 growth-trend">
                <div class="card border-0 rounded-4 shadow-sm" style="background:#fff;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Growth Trend</h6>
                            <div class="coupon-toggle-group">
                                <button id="weekBtn" class="toggle-btn active" onclick="switchPeriod('week')">Week</button>
                                <button id="monthBtn" class="toggle-btn" onclick="switchPeriod('month')">Month</button>
                            </div>
                        </div>
                        <div style="position:relative; height:300px;">
                            <canvas id="growthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="couponForm" action="{{ route('admin.coupons.store') }}">
                @csrf
                <div class="modal-content shadow rounded-4 border-0">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title fw-bold" id="couponModalLabel">
                            <i class="fas fa-edit me-2"></i> Edit Coupon
                        </h5>
                    </div>
                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Coupon Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="coupon_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Coupon Code <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="coupon_code" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Discount (%) <span class="text-danger">*</span></label>
                                <input type="number" name="discount" id="coupon_discount" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" id="coupon_status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" id="coupon_description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 py-3">
                        <button type="submit" class="btn btn-primary px-4" id="saveCouponBtn">
                            <i class="fas fa-save me-1"></i> Update
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<style>
    .coupon-toggle-group {
        display: inline-flex;
        background: #f1f3f8;
        border-radius: 50px;
        padding: 4px;
        gap: 2px;
    }
    .coupon-toggle-group .toggle-btn {
        border: none;
        background: transparent;
        color: #888;
        font-size: 13px;
        font-weight: 600;
        padding: 5px 18px;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .coupon-toggle-group .toggle-btn.active {
        background: #fff;
        color: #3B64E3;
        box-shadow: 0 1px 6px rgba(0,0,0,0.12);
    }
</style>
<script>
    Chart.register(ChartDataLabels);

    const weekData  = @json($weeklyData);
    const monthData = @json($monthlyData);
    let growthChart;

    function buildChart(labels, data) {
        const ctx = document.getElementById('growthChart').getContext('2d');
        if (growthChart) growthChart.destroy();
        growthChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Coupon Uses',
                    data: data,
                    backgroundColor: '#3B64E3',
                    borderRadius: 4,
                    barPercentage: 0.5,
                    categoryPercentage: 0.7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: { padding: { top: 24 } },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'rect',
                            boxWidth: 12,
                            boxHeight: 12,
                            padding: 20,
                            color: '#555',
                            font: { size: 12 }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        offset: 0,
                        color: '#333',
                        font: { size: 11, weight: '600' },
                        formatter: function(value) { return value > 0 ? value : ''; }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e3e7ef',
                            lineWidth: 1,
                        },
                        border: { dash: [5, 5], display: false },
                        ticks: { stepSize: 20, color: '#aaa', font: { size: 11 } }
                    },
                    x: {
                        grid: {
                            color: '#e3e7ef',
                            lineWidth: 1,
                        },
                        border: { dash: [5, 5], display: false },
                        ticks: { color: '#aaa', font: { size: 11 } }
                    }
                }
            }
        });
    }

    function switchPeriod(period) {
        document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
        if (period === 'week') {
            document.getElementById('weekBtn').classList.add('active');
            buildChart(weekData.labels, weekData.data);
        } else {
            document.getElementById('monthBtn').classList.add('active');
            buildChart(monthData.labels, monthData.data);
        }
    }

    buildChart(weekData.labels, weekData.data);

    $(document).on('click', '.editCouponBtn', function () {
        const id = $(this).data('id');
        $('#couponForm').attr('action', `/admin/coupons/update/${id}`);
        $('#coupon_name').val($(this).data('name'));
        $('#coupon_code').val($(this).data('code'));
        $('#coupon_discount').val($(this).data('discount'));
        $('#coupon_description').val($(this).data('description'));
        $('#coupon_status').val($(this).data('status'));
    });

    $('#couponForm').on('submit', function () {
        showPreloader();
    });
</script>
@endpush
