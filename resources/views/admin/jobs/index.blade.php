@extends('admin.layouts.master')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary"><i class="fas fa-briefcase me-2"></i> Job Management</h4>
            <button class="btn btn-primary" id="addJobBtn" data-bs-toggle="modal" data-bs-target="#jobModal">
                <i class="fas fa-plus"></i> Add Job
            </button>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
            </div>
        </div>
    </div>

    <!-- Add/Edit Job Modal -->
    <div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form method="POST" enctype="multipart/form-data" id="jobForm">
                @csrf
                <input type="hidden" id="job_id" name="id">

                <div class="modal-content shadow rounded-4 border-0">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title" id="jobModalLabel"><i class="fas fa-plus-circle me-2"></i> Add Job</h5>
                    </div>

                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Title<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                    <input type="text" name="title" id="job_title" class="form-control"
                                        placeholder="Enter Job Title" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Type<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                    <select name="type" id="job_type" class="form-control" required>
                                        <option value="">Select Job Type</option>
                                        <option value="FullTime">Full Time</option>
                                        <option value="PartTime">Part Time</option>
                                        <option value="Remote">Remote</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">For Airlines<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-plane"></i></span>
                                    <select name="for_airlines" id="for_airlines" class="form-control" required>
                                        <option value="">Select Airlines(From Airline Directory Shown Here)</option>
                                        @foreach($airlines as $airline)
                                            <option value="{{ $airline->name }}">{{ $airline->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description<span class="text-danger">*</span></label>
                                <textarea name="description" id="job_description" class="form-control" rows="3"
                                    placeholder="Enter Job Description" required></textarea>
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label fw-semibold">Location<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" name="location" id="job_location" class="form-control"
                                        placeholder="Enter Job Location" autocomplete="off" required>
                                </div>
                                <div id="locationSuggestions" class="list-group mt-1"
                                    style="display:none; max-height:200px; overflow-y:auto; position:absolute; z-index:999; width:100%;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Experience (Years)<span
                                        class="text-danger">*</span></label>
                                <input type="number" name="experience" id="job_experience" class="form-control"
                                    placeholder="Enter Experience in Years" required min="1">
                            </div>


                            <!-- <div class="col-md-12 mt-2">
                                <h6 class="text-dark mb-2 d-flex justify-content-between align-items-center" style="cursor:pointer;" id="toggleMapBtn">
                                    <span><i class="feather-map me-2 text-primary"></i> Job Location Map</span>
                                    <i id="mapToggleIcon" class="fas fa-chevron-down"></i>
                                </h6>
                                <div id="mapContainer" style="display:none;">
                                    <div id="job-location-map" class="rounded-3 border shadow-sm" style="height:300px;"></div>
                                </div>
                            </div> -->

                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-semibold">Last Date<span class="text-danger">*</span></label>
                                <input type="date" name="last_date" id="date" class="form-control"
                                    placeholder="Select Last Date" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Job External Link<span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    <input type="text" name="link" id="job_link" class="form-control"
                                        placeholder="Enter Job External Link" required>
                                </div>
                            </div>

                            <div class="col-md-6 mt-3" id="statusField">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" id="job_status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 py-3">
                        <button type="submit" class="btn btn-primary px-4" id="saveJobBtn">
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
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&loading=async&callback=initAutocomplete"
        async defer></script>

    <script>
        let autocompleteService, geocoder, map, marker;

        function initAutocomplete() {
            autocompleteService = new google.maps.places.AutocompleteService();
            geocoder = new google.maps.Geocoder();

            const locationInput = document.getElementById('job_location');
            const suggestionsContainer = document.getElementById('locationSuggestions');

            locationInput.addEventListener('input', function () {
                const query = this.value;

                if (query.length > 2) {
                    autocompleteService.getPlacePredictions({
                        input: query,
                        componentRestrictions: {
                            country: 'in'
                        }
                    }, function (predictions, status) {
                        suggestionsContainer.innerHTML = '';
                        if (status === google.maps.places.PlacesServiceStatus.OK && predictions) {
                            predictions.forEach(prediction => {
                                const item = document.createElement('div');
                                item.classList.add('list-group-item', 'list-group-item-action');
                                item.style.cursor = 'pointer';
                                item.textContent = prediction.description;

                                item.addEventListener('click', function () {
                                    locationInput.value = prediction.description;
                                    suggestionsContainer.style.display = 'none';
                                    initMap(prediction.description);
                                });

                                suggestionsContainer.appendChild(item);
                            });
                            suggestionsContainer.style.display = 'block';
                        } else {
                            suggestionsContainer.style.display = 'none';
                        }
                    });
                } else {
                    suggestionsContainer.style.display = 'none';
                }
            });

            document.addEventListener('click', function (event) {
                if (!suggestionsContainer.contains(event.target) && event.target !== locationInput) {
                    suggestionsContainer.style.display = 'none';
                }
            });
        }

        function initMap(address) {
            if (!address) return;

            if (!map) {
                map = new google.maps.Map(document.getElementById("job-location-map"), {
                    zoom: 14,
                    center: {
                        lat: 20.5937,
                        lng: 78.9629
                    }
                });
                marker = new google.maps.Marker({
                    map: map
                });
            }

            geocoder.geocode({
                address: address
            }, function (results, status) {
                if (status === "OK" && results[0]) {
                    map.setCenter(results[0].geometry.location);
                    marker.setPosition(results[0].geometry.location);
                }
            });
        }

        // $(document).on('click', '#toggleMapBtn', function() {
        //     const mapContainer = $('#mapContainer');
        //     const icon = $('#mapToggleIcon');

        //     if (mapContainer.is(':visible')) {
        //         mapContainer.slideUp();
        //         icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        //     } else {
        //         mapContainer.slideDown();
        //         icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');

        //         let location = $('#job_location').val();
        //         if (location) {
        //             setTimeout(() => initMap(location), 400);
        //         }
        //     }
        // });

        function resetModal() {
            $('#jobForm')[0].reset();
            $('#job_id').val('');
            $('#jobModalLabel').text('Add Job');
            $('#saveJobBtn').text('Save');
            $('#statusField').hide();
        }

        $('#addJobBtn').click(function () {
            resetModal();
            $('#jobForm').attr('action', "{{ route('admin.jobs.store') }}");
            if (!$('#jobForm input[name="status"]').length) {
                $('#jobForm').append('<input type="hidden" name="status" value="1">');
            }
        });

        $(document).on('click', '.editjobBtn', function () {
            resetModal();
            $('#jobModalLabel').text('Edit Job');
            $('#saveJobBtn').text('Update Job');
            $('#statusField').show();

            $('#job_id').val($(this).data('id'));
            $('#job_title').val($(this).data('title'));
            $('#job_type').val($(this).data('type'));
            $('#for_airlines').val($(this).data('for_airlines'));
            $('#job_description').val($(this).data('description'));
            $('#job_location').val($(this).data('location'));
            $('#job_experience').val($(this).data('experience'));
            $('#date').val($(this).data('last_date'));
            $('#job_link').val($(this).data('link'));
            $('#job_status').val($(this).data('status'));

            $('#jobForm').attr('action', "{{ url('admin/jobs/update') }}/" + $(this).data('id'));
            $('#jobModal').modal('show');
        });

        $('#jobModal').on('hidden.bs.modal', function () {
            resetModal();
            $('#jobForm input[name="status"]').remove();
        });

        $('#jobForm').on('submit', function () {
            showPreloader();
        });
    </script>
    <script>
        document.getElementById('job_experience').addEventListener('input', function () {
            if (this.value < 1) this.value = '';
        });
    </script>

@endpush