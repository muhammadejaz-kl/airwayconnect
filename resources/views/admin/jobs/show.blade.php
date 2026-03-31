@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary"><i class="fas fa-briefcase me-2"></i> Job Details</h2>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4 align-items-stretch">
        
        <div class="col-md-6 d-flex">
            <div class="card shadow-sm border-0 w-100 d-flex flex-column">
                <div class="card-header bg-info border-bottom">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="feather-info me-2 text-primary"></i> Job Information
                    </h5>
                </div>
                <div class="card-body pt-3 flex-grow-1">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-heading me-1 text-white"></i> Title</label>
                            <div class="form-control-plaintext">{{ $job->title }}</div>
                        </div>

                        <div class="col-12">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-align-left me-1 text-white"></i> Description</label>
                            <div class="form-control-plaintext">{{ $job->description }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-briefcase me-1 text-white"></i> Type</label>
                            <div class="form-control-plaintext">{{ $job->type }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-map-marker-alt me-1 text-white"></i> Location</label>
                            <div class="form-control-plaintext">{{ $job->location }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-user-tie me-1 text-white"></i> Experience</label>
                            <div class="form-control-plaintext">{{ $job->experience }} Years</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-plane me-1 text-white"></i> For Airlines</label>
                            <div class="form-control-plaintext">{{ $job->for_airlines }}</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-link me-1 text-white"></i> External Job Link</label>
                            <div class="form-control-plaintext"><a href="{{ Str::startsWith($job->link, ['http://', 'https://']) ? $job->link : 'https://' . $job->link }}" target="_blank">{{ $job->link }}</a></div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-calendar-alt me-1 text-white"></i> Last Date</label>
                            <div class="form-control-plaintext">{{ $job->last_date }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold text-dark mb-1"><i class="fas fa-toggle-on me-1 text-white"></i> Status</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-{{ $job->status ? 'success' : 'danger' }}">
                                    {{ $job->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
        <div class="col-md-6 d-flex">
            <div class="card shadow-sm border-0 w-100">
                <div class="card-header bg-info border-bottom">
                    <h5 class="card-title mb-0 text-dark">
                        <i class="feather-map me-2 text-primary"></i> Job Location Map
                    </h5>
                </div>
                <div class="card-body">
                    <div id="job-location-map" class="rounded-3 border shadow-sm" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts') 
<script async
    defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">
</script>

<script>
function initMap() {
    const address = @json($job->location);

    if (!address || address.trim() === '') {
        console.error("Job location is missing.");
        return;
    }

    const map = new google.maps.Map(document.getElementById("job-location-map"), {
        zoom: 14,
        mapTypeControl: false,
        streetViewControl: false
    });

    const geocoder = new google.maps.Geocoder();

    geocoder.geocode({ address: address }, function(results, status) {
        if (status === "OK" && results[0]) {
            map.setCenter(results[0].geometry.location);

            new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                title: address
            });
        } else {
            console.error("Geocode failed: " + status);
        }
    });
}
</script>
@endpush
