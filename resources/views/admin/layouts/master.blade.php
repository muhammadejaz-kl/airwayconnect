<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NNPNRSFM');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Airway Connect Admin</title>
    <link rel="shortcut icon" href="{{asset('admin/assets/img/favicons.png')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/icons/flags/flags.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/datatables/datatables.min.css')}}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{asset('admin/assets/css/custom.css')}}">

</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NNPNRSFM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="main-wrapper">
        @include('admin.includes.header')
        @include('admin.includes.sidebar')
        <div class="page-wrapper">
            @yield('content')
            <form id="delete-form" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
            @include('admin.includes.footer')
        </div>
    </div>

    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/feather.min.js')}}"></script>
    <script src="{{ asset('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{ asset('admin/assets/plugins/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{ asset('admin/assets/plugins/apexchart/chart-data.js')}}"></script>
    <script src="{{ asset('admin/assets/js/script.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForm = document.getElementById('delete-form');

            document.addEventListener('click', function(event) {
                if (event.target.closest('.delete-btn')) {
                    event.preventDefault();
                    const button = event.target.closest('.delete-btn');
                    const name = button.dataset.name || '';
                    const role = button.dataset.role || 'User';
                    const url = button.dataset.url;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You want to delete ${name}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteForm.action = url;
                            deleteForm.submit();
                        }
                    });
                }
            });
        });
    </script>

    <script>
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('
            success ') }}',
            timer: 2000,
            showConfirmButton: false
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('
            error ') }}',
            showConfirmButton: true
        });
        @endif

        @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: '{{ session('
            warning ') }}',
            showConfirmButton: true
        });
        @endif
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#date", {
                dateFormat: "Y-m-d",
                minDate: "today",
                allowInput: true
            });
        });
    </script>

    <div id="global-preloader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.9); z-index: 9999; display: none; justify-content: center; align-items: center; flex-direction: column; font-family: Arial, sans-serif;">
        <i class="fas fa-plane-departure airplane-icon" style="font-size: 4rem; color: #007bff;"></i>
        <p style="margin-top: 15px; font-weight: bold; color: #333;">Loading... Please wait</p>
    </div>

    <style>
        .airplane-icon {
            animation: fly 1.5s linear infinite;
        }

        @keyframes fly {
            0% {
                transform: translateX(-50px) translateY(0) rotate(-10deg);
                opacity: 0.5;
            }

            50% {
                transform: translateX(0) translateY(-10px) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateX(50px) translateY(0) rotate(10deg);
                opacity: 0.5;
            }
        }
    </style>
    <script>
        function showPreloader() {
            document.getElementById('global-preloader').style.display = 'flex';
        }

        function hidePreloader() {
            document.getElementById('global-preloader').style.display = 'none';
        }
    </script>

    <script>
        $(document).on('change', '.toggle-status', function(e) {
            e.preventDefault();

            let checkbox = $(this);
            let userId = checkbox.data('id');
            let newStatus = checkbox.prop('checked') ? 1 : 0;
 
            checkbox.prop('checked', !checkbox.prop('checked'));

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update this user's status?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/users/status') }}/" + userId,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: newStatus
                        },
                        success: function(response) {
                            if (response.success) {
                                checkbox.prop('checked', newStatus);
                                Swal.fire('Updated!', 'User status has been updated.', 'success');
                            } else {
                                Swal.fire('Error!', 'Something went wrong.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to update status.', 'error');
                        }
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>