@extends('admin.layouts.master')
@section('content')

<div class="content container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-sub-header">
                    <h3 class="page-title text-primary">Welcome Admin!</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Users --}}
        <div class="col-xl-3 col-sm-6 col-12">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-dark">
                <div class="dashboard-card d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Total Users</h6>
                        <h3>{{ $totalUsers }}</h3>
                        <div class="d-flex flex-wrap gap-2 text-sm" style="font-size: 13px; color: #1E40AF;">
                            <span>Active: <strong>{{ $activeUsers }}</strong></span>
                            <span>Inactive: <strong>{{ $inactiveUsers }}</strong></span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-2 text-sm" style="font-size: 13px; color: #1E40AF;">
                            <span>Subscribers: <strong>{{ $subscribers }}</strong></span>
                        </div>
                    </div>
                    <div class="dashboard-icon">
                        <img src="{{ asset('admin/assets/img/icons/user.png') }}" alt="Users Icon">
                    </div>
                </div>
            </a>
        </div>

        {{-- Jobs --}}
        <div class="col-xl-3 col-sm-6 col-12">
            <a href="{{ route('admin.jobs.index') }}" class="text-decoration-none text-dark">
                <div class="dashboard-card d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Total Jobs</h6>
                        <h3>{{ $totaljobs }}</h3>
                        <div class="stat-line"><span>Active:</span> <strong>{{ $activejobs }}</strong></div>
                        <div class="stat-line"><span>Inactive:</span> <strong>{{ $inactivejobs }}</strong></div>
                    </div>
                    <div class="dashboard-icon">
                        <img src="{{ asset('admin/assets/img/icons/jobs.png') }}" alt="Jobs Icon">
                    </div>
                </div>
            </a>
        </div>

        {{-- Events --}}
        <div class="col-xl-3 col-sm-6 col-12">
            <a href="{{ route('admin.events.index') }}" class="text-decoration-none text-dark">
                <div class="dashboard-card d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Total Events</h6>
                        <h3>{{ $totalevents }}</h3>
                        <div class="d-flex flex-wrap gap-2 text-sm" style="font-size: 13px; color: #1E40AF;">
                            <span>Upcoming: <strong>{{ $upcomingEvents }}</strong></span>
                            <span>Today: <strong>{{ $todayEvents }}</strong></span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-2 text-sm" style="font-size: 13px; color: #1E40AF;">
                            <span>Past: <strong>{{ $pastEvents }}</strong></span>
                        </div>
                    </div>
                    <div class="dashboard-icon">
                        <img src="{{ asset('admin/assets/img/icons/events.png') }}" alt="Events Icon">
                    </div>
                </div>
            </a>
        </div>

        {{-- Forum Posts --}}
        <div class="col-xl-3 col-sm-6 col-12">
            <a href="{{ route('admin.forum.forumIndex') }}" class="text-decoration-none text-dark">
                <div class="dashboard-card d-flex justify-content-between align-items-start">
                    <div>
                        <h6>Forum Posts</h6>
                        <h3>{{ $totalForums }}</h3>
                        <div class="stat-line"><span>Active:</span> <strong>{{ $activeForums }}</strong></div>
                        <div class="stat-line"><span>Inactive:</span> <strong>{{ $inactiveForums }}</strong></div>
                    </div>
                    <div class="dashboard-icon">
                        <img src="{{ asset('admin/assets/img/icons/blogs.png') }}" alt="Forum Icon">
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mt-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Latest Users</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">View All</a>
            </div>
            <div id="datatable-wrapper" class="table-responsive">
                {!! $dataTable->table(['class' => 'table table-striped table-hover w-100 mb-0']) !!}
            </div>
        </div>
    </div>



</div>
@endsection
@push('scripts')
{!! $dataTable->scripts() !!}
@endpush