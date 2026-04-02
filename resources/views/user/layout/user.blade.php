<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Airways Connect User</title>

    <link rel="shortcut icon" href="{{ asset('admin/assets/img/favicons.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    .new-user-menus {
        .dropdown-toggle::after {
            vertical-align: 1.255em !important;
            color: #fff !important;
        }
    }
</style>

<body>
    <div class="min-h-screen bg-primary-dark">
        @include('user.includes.topbar')

        <div>
            @yield('content')
        </div>

        @include('components.subscription-pop')
        @include('components.subscription-pop')
    </div>

    <script src="{{ asset('admin/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('admin/assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        use Carbon\Carbon;

        $currentRoute = Route::currentRouteName();
        $user = auth()->user();
        $isPremium = $user && $user->premiun_status == 1;

        $today = Carbon::now();
        $expired = $isPremium && $user->premium_end_date && $today->gt(Carbon::parse($user->premium_end_date));
    @endphp

    @if ($expired)
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                console.log("Premium expired → updating status...");

                fetch("{{ route('user.updatePremiumStatus') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ user_id: "{{ $user->id }}" })
                })
                    .then(res => res.json())
                    .then(data => {
                        console.log("Premium status updated:", data);
                        location.reload();
                    })
                    .catch(err => console.error("Failed to update premium status", err));
            });
        </script>
    @endif

    @if (!$isPremium || $expired)
        @if (
                $currentRoute !== 'user.dashboard' &&
                $currentRoute !== 'user.resume.index' &&

                $currentRoute !== 'user.resume.saveTemplateSession' &&
                $currentRoute !== 'user.resume.parse' &&
                $currentRoute !== 'user.resume.getTemplatePreview' &&
                $currentRoute !== 'user.resume.saveJob' &&
                $currentRoute !== 'user.resume.getJobs' &&
                $currentRoute !== 'user.resume.updateJob' &&
                $currentRoute !== 'user.resume.deleteJob' &&
                $currentRoute !== 'user.resume.saveExperienceLevelSession' &&
                $currentRoute !== 'user.resume.saveBestMatchEducationSession' &&
                $currentRoute !== 'user.resume.saveEducationSession' &&
                $currentRoute !== 'user.resume.getEducations' &&
                $currentRoute !== 'user.resume.updateEducation' &&
                $currentRoute !== 'user.resume.deleteEducation' &&
                $currentRoute !== 'user.resume.store' &&
                $currentRoute !== 'user.resume.delete' &&
                $currentRoute !== 'user.resume.searchSkills' &&
                $currentRoute !== 'user.resume.finalize.template' &&
                $currentRoute !== 'user.resume.save.image' &&
                $currentRoute !== 'user.resume.clearSession' &&
                $currentRoute !== 'user.resume.clearSession' &&
                $currentRoute !== 'user.profile.index' &&
                $currentRoute !== 'user.airlineDirectory.index' &&
                $currentRoute !== 'user.premium.index' &&
                $currentRoute !== 'user.interview.index' &&
                $currentRoute !== 'user.interview.show'
            )
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const popup = document.getElementById("subscriptionPopup");
                    const closeBtn = document.getElementById("closeSubscriptionPopup");

                    if (popup && closeBtn) {
                        console.log("Blocked route → redirecting to dashboard");
                        if (window.location.pathname !== "{{ route('user.dashboard', [], false) }}") {
                            window.location.href = "{{ route('user.dashboard') }}";
                        }
                    }
                });
            </script>
        @endif

        @if ($currentRoute === 'user.dashboard')
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const popup = document.getElementById("subscriptionPopup");
                    const closeBtn = document.getElementById("closeSubscriptionPopup");

                    if (popup && closeBtn) {
                        console.log("Non-premium or expired premium → popup will show 2 times only");

                        let showCount = 0;

                        function showPopup() {
                            if (showCount >= 2) return;

                            popup.classList.remove("hidden");
                            popup.style.display = "flex";
                            showCount++;

                            console.log("Popup shown → count:", showCount);
                        }

                        function hidePopup() {
                            popup.classList.add("hidden");
                            popup.style.display = "none";
                            console.log("Popup hidden");
                        }

                        closeBtn.addEventListener("click", hidePopup);

                        showPopup();

                        setTimeout(showPopup, 30000);
                    } else {
                        console.error("Popup elements not found in DOM.");
                    }
                });
            </script>
        @endif

        {{-- @if ($currentRoute === 'user.dashboard')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const popup = document.getElementById("subscriptionPopup");
                const closeBtn = document.getElementById("closeSubscriptionPopup");

                if (popup && closeBtn) {
                    console.log("Non-premium or expired premium → showing popup every 5s");

                    function showPopup() {
                        popup.classList.remove("hidden");
                        popup.style.display = "flex";
                        console.log("Popup shown");
                    }

                    function hidePopup() {
                        popup.classList.add("hidden");
                        popup.style.display = "none";
                        console.log("Popup hidden");
                    }

                    closeBtn.addEventListener("click", hidePopup);

                    showPopup();

                    setInterval(showPopup, 5000);
                } else {
                    console.error("Popup elements not found in DOM.");
                }
            });
        </script>
        @endif --}}

    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForm = document.getElementById('delete-form');

            document.addEventListener('click', function (event) {
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
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                showConfirmButton: true
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: '{{ session('warning') }}',
                showConfirmButton: true
            });
        @endif
    </script>

    <div id="global-preloader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.9); z-index: 9999;
        display: none; justify-content: center; align-items: center;
        flex-direction: column; font-family: Arial, sans-serif;">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        window.$notification = function (message, type = 'success') {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: '3000'
            };
            toastr[type](message);
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const GUARD_ENABLED = @json(
                session()->has('jobs') ||
                session()->has('educations') ||
                session()->has('best_match') ||
                session()->has('experience_level')
            );

            if (!GUARD_ENABLED) return;

            let guard = true;
            const CLEAR_URL = "{{ route('user.resume.clearSession') }}";
            const CSRF = "{{ csrf_token() }}";

            function clearSession() {
                return fetch(CLEAR_URL, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
                }).catch(() => { });
            }

            function confirmNavigate(dest = null, mode = 'leave') {
                const isReload = mode === 'reload';
                return Swal.fire({
                    title: 'Are you sure?',
                    text: isReload
                        ? 'Refreshing this page can reset your resume and lose your data.'
                        : 'Leaving this page can reset your resume and lose your data.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: isReload ? 'Yes, refresh' : 'Yes, leave',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then(res => {
                    if (!res.isConfirmed) return false;
                    return clearSession().then(() => {
                        guard = false;
                        if (isReload) {
                            location.reload();
                        } else if (dest) {
                            if (typeof dest === 'object' && dest.url) {
                                if (dest.target === '_blank') {
                                    window.open(dest.url, '_blank');
                                    return true;
                                }
                                location.href = dest.url;
                            } else {
                                location.href = dest;
                            }
                        } else {
                            history.back();
                        }
                        return true;
                    });
                });
            }

            document.addEventListener('keydown', e => {
                if (!guard) return;
                const key = e.key;
                const isReloadKey = key === 'F5' || ((e.ctrlKey || e.metaKey) && (key === 'r' || key === 'R'));
                if (isReloadKey) {
                    e.preventDefault();
                    confirmNavigate(null, 'reload');
                }
            }, true);

            document.addEventListener('click', e => {
                if (!guard) return;
                const a = e.target.closest('a[href]');
                if (!a) return;
                const href = a.getAttribute('href') || '';
                if (href.startsWith('#') || href.startsWith('javascript:')) return;
                if (a.dataset.noGuard === 'true') return;
                e.preventDefault();
                confirmNavigate({ url: a.href, target: a.getAttribute('target') || '' }, 'leave');
            }, true);

            document.addEventListener('submit', e => {
                if (!guard) return;
                const form = e.target;
                if (form?.dataset?.noGuard === 'true') return;
                e.preventDefault();
                confirmNavigate(null, 'leave').then(ok => {
                    if (ok) form.submit();
                });
            }, true);

            history.pushState({ guard: true }, '', location.href);
            window.addEventListener('popstate', () => {
                if (!guard) return;
                history.pushState({ guard: true }, '', location.href);
                confirmNavigate(document.referrer || null, 'leave');
            });

            const ENABLE_TOOLBAR_FALLBACK = true;
            if (ENABLE_TOOLBAR_FALLBACK) {
                window.addEventListener('beforeunload', e => {
                    if (!guard) return;
                    e.preventDefault();
                    e.returnValue = '';
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>