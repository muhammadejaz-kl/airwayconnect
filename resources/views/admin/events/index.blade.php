@extends('admin.layouts.master')

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-primary"><i class="fas fa-calendar-alt me-2"></i> Event Management</h4>
            <button class="btn btn-primary" id="addEventBtn" data-bs-toggle="modal" data-bs-target="#EventModal">
                <i class="fas fa-plus"></i> Add Event
            </button>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped align-middle w-100']) !!}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="EventModal" tabindex="-1" aria-labelledby="EventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" id="EventForm">
                @csrf
                <input type="hidden" id="event_id" name="id">

                <div class="modal-content shadow rounded-4 border-0">
                    <div class="modal-header bg-info text-white rounded-top-4">
                        <h5 class="modal-title" id="EventModalLabel"><i class="fas fa-plus-circle me-2"></i> Add Event</h5>
                    </div>

                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <!-- Title -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Title<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                    <input type="text" name="title" id="event_title" class="form-control"
                                        placeholder="Enter Event Title" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Link<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                    <input type="text" name="link" id="event_link" class="form-control"
                                        placeholder="Enter Event Link" required>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                    <textarea name="description" id="event_description" class="form-control" rows="3"
                                        placeholder="Enter Event Description" required></textarea>
                                </div>
                            </div>

                            <!-- About -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">About<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    <textarea name="about" id="event_about" class="form-control" rows="1"
                                        placeholder="About the Event"></textarea>
                                </div>
                            </div>

                            <!-- Banner -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-semibold">Banner<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    <input type="file" accept=".jpg, .png, .JPEG" name="banner" id="event_banner"
                                        class="form-control">
                                </div>
                                <small class="text-muted">Only JPEG, PNG, JPG formats allowed (Max 2MB).</small>
                                <div id="bannerError" class="text-danger mt-1" style="display:none;"></div>
                                <div id="bannerPreview" class="mt-2"></div>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6 position-relative">
                                <label class="form-label fw-semibold">Location<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" name="location" id="event_location" class="form-control"
                                        placeholder="Enter Event Location" autocomplete="off" required>
                                </div>
                                <div id="locationSuggestions" class="list-group mt-1"
                                    style="display:none; max-height:200px; overflow-y:auto; position:absolute; z-index:999; width:100%;">
                                </div>
                            </div>

                            <!-- Map -->
                            <!-- <div class="col-md-12 mt-6">
                                <h6 class="text-dark mb-2 d-flex justify-content-between align-items-center" style="cursor:pointer;" id="toggleMapBtn">
                                    <span><i class="feather-map me-2 text-primary"></i> Event Location Map</span>
                                    <i id="mapToggleIcon" class="fas fa-chevron-down"></i>
                                </h6>
                                <div id="mapContainer" style="display:none;">
                                    <div id="event-location-map" class="rounded-3 border shadow-sm" style="height:300px;"></div>
                                </div>
                            </div> -->

                            <!-- Date -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-semibold">Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="date" name="date" id="date" class="form-control" required>
                                </div>
                            </div>

                            <!-- Timing -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-semibold">Timings (From - To)<span
                                        class="text-danger">*</span></label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        <input type="text" id="time_from" class="form-control" placeholder="From" required>
                                    </div>
                                    <span class="fw-bold">to</span>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        <input type="text" id="time_to" class="form-control" placeholder="To" required>
                                    </div>
                                </div>
                                <input type="hidden" name="timing" id="timing">
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 py-3">
                        <button type="submit" class="btn btn-primary px-4" id="saveEventBtn" disabled>
                            <i class="fas fa-save me-1"></i> Save Event
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
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>

    <script>
        let autocompleteService, geocoder, map, marker, aboutEditor;

        function initAutocomplete() {
            autocompleteService = new google.maps.places.AutocompleteService();
            geocoder = new google.maps.Geocoder();

            const locationInput = document.getElementById('event_location');
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
                map = new google.maps.Map(document.getElementById("event-location-map"), {
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
        //         let location = $('#event_location').val();
        //         if (location) {
        //             setTimeout(() => initMap(location), 400);
        //         }
        //     }
        // });

        ClassicEditor.create(document.querySelector('#event_about'))
            .then(editor => {
                aboutEditor = editor;
            })
            .catch(error => console.error(error));

        $('#EventForm').on('submit', function () {
            $('#event_about').val(aboutEditor.getData());
        });

        $('#addEventBtn').click(function () {
            $('#EventModalLabel').html('<i class="fas fa-plus-circle me-2"></i> Add Event');
            $('#EventForm').attr('action', '{{ route("admin.events.store") }}');
            $('#EventForm')[0].reset();
            $('#bannerPreview').html('');
            $('#bannerError').hide();
            $('#saveEventBtn').prop('disabled', false);
            if (aboutEditor) aboutEditor.setData('');
        });

        $(document).on('click', '.editEventBtn', function () {
            let event = $(this).data();

            $('#EventModalLabel').html('<i class="fas fa-edit me-2"></i> Edit Event');
            $('#EventForm').attr('action', '/admin/events/update/' + event.id);

            $('#event_id').val(event.id);
            $('#event_title').val(event.title);
            $('#event_link').val(event.link);
            $('#event_description').val(event.description);
            $('#event_location').val(event.location);
            $('#date').val(event.date);

            if (event.about && aboutEditor) aboutEditor.setData(event.about);

            if (event.timing) {
                let times = event.timing.split('-');
                if (times.length === 2) {
                    $('#time_from').val(times[0].trim());
                    $('#time_to').val(times[1].trim());
                    $('#timing').val(event.timing);
                }
            }

            if (event.banner) {
                let imageUrl = `/storage/${event.banner}`;
                $('#bannerPreview').html(`<img src="${imageUrl}" class="img-thumbnail mt-2" width="200">`);
            }

            $('#saveEventBtn').prop('disabled', false);
            $('#EventModal').modal('show');
        });


        $('#EventForm').on('submit', function () {
            showPreloader();
        });

        $('#event_banner').on('change', function () {
            let file = this.files[0];
            let errorDiv = $('#bannerError');
            let previewDiv = $('#bannerPreview');
            let saveBtn = $('#saveEventBtn');

            errorDiv.hide().text('');
            previewDiv.html('');
            saveBtn.prop('disabled', false);

            if (file) {
                let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!allowedTypes.includes(file.type)) {
                    errorDiv.text('Invalid file type! Only JPEG, PNG, JPG are allowed.').show();
                    $(this).val('');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    errorDiv.text('File size must not exceed 2MB.').show();
                    $(this).val('');
                    return;
                }

                let reader = new FileReader();
                reader.onload = function (e) {
                    previewDiv.html('<img src="' + e.target.result + '" class="img-thumbnail mt-2" width="200">');
                }
                reader.readAsDataURL(file);

                saveBtn.prop('disabled', false);
            }
        });
    </script>
    <script>
        $(document).ready(function () {

            function validateTime() {
                let selectedDate = $('#date').val();
                let fromTime = $('#time_from').val();
                let toTime = $('#time_to').val();

                if (!selectedDate) return;

                let today = new Date();
                let currentDate = today.toISOString().split('T')[0];

                if (selectedDate === currentDate) {
                    let now = today.getHours() * 60 + today.getMinutes();
                    let fromMinutes = convertToMinutes(fromTime);
                    let toMinutes = convertToMinutes(toTime);

                    if (fromTime && fromMinutes < now) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Invalid Time',
                            text: 'You cannot select a past time for "From".',
                            confirmButtonColor: '#3085d6'
                        });
                        $('#time_from').val('');
                    }

                    if (toTime && (toMinutes < now || (fromTime && toMinutes <= fromMinutes))) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Invalid Time',
                            text: 'Please select a valid "To" time.',
                            confirmButtonColor: '#3085d6'
                        });
                        $('#time_to').val('');
                    }
                }

                if (fromTime && toTime) {
                    $('#timing').val(fromTime + ' - ' + toTime);
                }
            }

            function convertToMinutes(time) {
                if (!time) return 0;
                let [hours, minutes] = time.replace(/[^0-9:]/g, '').split(':').map(Number);
                let isPM = time.toLowerCase().includes('pm');
                if (isPM && hours !== 12) hours += 12;
                if (!isPM && hours === 12) hours = 0;
                return hours * 60 + minutes;
            }

            $('#date, #time_from, #time_to').on('change', validateTime);
        });
    </script>
    <script>
        let timeFromPicker, timeToPicker;

        function initTimePickers(minTime = null) {
            timeFromPicker = flatpickr("#time_from", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                time_24hr: false,
                minTime: minTime,
                onChange: updateTiming
            });

            timeToPicker = flatpickr("#time_to", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K",
                time_24hr: false,
                minTime: minTime,
                onChange: updateTiming
            });
        }

        function updateTiming() {
            const from = document.getElementById("time_from").value;
            const to = document.getElementById("time_to").value;
            document.getElementById("timing").value = `${from} - ${to}`;
        }

        $(document).ready(function () {
            initTimePickers();

            $('#date').on('change', function () {
                const selectedDate = this.value;
                const today = new Date().toISOString().split('T')[0];

                if (selectedDate === today) {
                    const now = new Date();
                    const hours = now.getHours();
                    const minutes = now.getMinutes();
                    const formattedTime = `${hours}:${minutes < 10 ? '0' + minutes : minutes}`;

                    timeFromPicker.set('minTime', formattedTime);
                    timeToPicker.set('minTime', formattedTime);
                } else {
                    timeFromPicker.set('minTime', null);
                    timeToPicker.set('minTime', null);
                }
            });
        });


        document.getElementById("time_from").addEventListener("change", updateTiming);
        document.getElementById("time_to").addEventListener("change", updateTiming);

        function updateTiming() {
            const from = document.getElementById("time_from").value;
            const to = document.getElementById("time_to").value;
            document.getElementById("timing").value = `${from} - ${to}`;
        }
    </script>

@endpush