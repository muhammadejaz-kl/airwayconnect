@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid" style="height: fit-content;"> 
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-calendar-alt me-2"></i> Event Details</h2>
        <a href="{{ route('admin.events.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4 align-items-stretch"> 
        
        <div class="col-md-6 d-flex">
            <div class="card event-details shadow-sm border-0 w-100">
                
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="feather-info me-2 text-primary"></i> Event Information
                    </h5>
                </div>

                <div class="card-body pt-3">

                    <div class="rounded-3 mb-3"
                        style="height:250px; background-size:cover; background-position:center; 
                        background-image: url('{{ $event->banner ? asset('storage/'.$event->banner) : asset('images/default-banner.jpg') }}');">
                    </div>

                    <div class="row g-3">

                        <div class="col-12">
                            <label class="fw-bold text-dark mb-1">Title</label>
                            <div class="form-control-plaintext text-white">{{ $event->title ?? 'N/A' }}</div>
                        </div>

                        <div class="col-12">
                            <label class="fw-bold text-dark mb-1">Description</label>
                            <div class="form-control-plaintext text-white">{{ $event->description ?? 'N/A' }}</div>
                        </div>

                        <div class="col-12">
                            <label class="fw-bold text-dark mb-1">Link</label>
                            <div class="form-control-plaintext text-white">{{ $event->link ?? 'N/A' }}</div>
                        </div>

                        <div class="col-12">
                            <label class="fw-bold text-dark mb-1">Location</label>
                            <div class="form-control-plaintext text-white">{{ $event->location ?? 'N/A' }}</div>
                        </div>

                        <div class="col-12">
                            <label class="fw-bold text-dark mb-1">Date</label>
                            <div class="form-control-plaintext text-white">{{ $event->date ?? 'N/A' }}</div>
                        </div>

                        <div class="col-12">
                            <label class="fw-bold text-dark mb-1">Timing</label>
                            <div class="form-control-plaintext text-white">{{ $event->timing ?? 'N/A' }}</div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-6 d-flex">
            <div class="card event-details shadow-sm border-0 w-100">
                
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="feather-info me-2 text-primary"></i> About the Event
                    </h5>
                </div>

                <div class="card-body pt-3">
                    <div class="p-3 rounded-3 border bg-light text-dark" style="min-height: 300px;">
                        {!! $event->about !!}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
