@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="fas fa-user-circle me-2"></i> User Details
        </h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- <div class="card shadow-sm rounded-4 border-0 mb-4">
        <ul class="nav nav-tabs nav-tabs-solid nav-justified bg-light rounded-top-4" role="tablist" style="border-bottom: 2px solid #dee2e6;">
            <li class="nav-item">
                <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#tab-info" role="tab">
                    <i class="fas fa-info-circle me-1"></i> Information
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#tab-interview" role="tab">
                    <i class="fas fa-clipboard-list me-1"></i> Interviews
                </a>
            </li>
        </ul>
    </div> -->

    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">

                <div class="relative w-00" style="height: 350px; background: #f5f5f5;">
                    @if($user->cover_image)
                    <img src="{{ asset('storage/' . $user->cover_image) }}"
                        alt="Cover Image"
                        class="w-100 h-100 object-fit-cover">
                    @else
                    <img src="{{ asset('assets/images/default-cover.jpg') }}"
                        alt="Cover Image"
                        class="w-100 h-100 object-fit-cover">
                    @endif
                </div>

                <div class="bg-light px-4 py-5 position-relative">
                    <div class="row align-items-center">
                        <div class="col-lg-3 text-center mb-4">
                            @php
                            $avatar = $user->profile_image
                            ? asset('storage/' . $user->profile_image)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random';
                            @endphp
                            <img src="{{ $avatar }}" alt="Profile"
                                class="rounded-circle border border-4 border-white shadow"
                                style="width: 140px; height: 140px; object-fit: cover; margin-top: -90px;">
                            <h4 class="fw-bold mt-3">{{ $user->name }}</h4>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-envelope text-primary fs-5 me-3"></i>
                                        <div>
                                            <div class="fw-semibold">Email</div>
                                            <div class="text-muted">{{ $user->email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-phone text-success fs-5 me-3"></i>
                                        <div>
                                            <div class="fw-semibold">Phone</div>
                                            <div class="text-muted">
                                                {{ $user->phone_code && $user->phone_number
                                                    ? $user->phone_code . ' ' . $user->phone_number
                                                    : 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-calendar-alt text-info fs-5 me-3"></i>
                                        <div>
                                            <div class="fw-semibold">Joined</div>
                                            <div class="text-muted">{{ $user->created_at->format('d M Y, H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-user-check text-warning fs-5 me-3"></i>
                                        <div>
                                            <div class="fw-semibold">Status</div>
                                            <span class="badge bg-{{ $user->status == 1 ? 'success' : 'danger' }}">
                                                {{ $user->status == 1 ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tab-interview" role="tabpanel">
            <div class="card shadow-sm rounded-4 border-0 p-4">
                <h5 class="fw-bold mb-3"><i class="fas fa-clipboard-list me-2"></i> Interview Details</h5>
                <p class="text-muted">No interview details available yet.</p>
            </div>
        </div>
    </div>
</div>
@endsection