<header class="bg-secondary-color shadow-sm p-6 w-full">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo">
            </a>
        </div>

        <button id="menu-toggle"
            class="toggle-btn-menu ml-auto p-2 lg:hidden rounded-md text-gray-500 focus:outline-none">
            <svg id="menu-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        @php
            $segment = Request::segment(1);
        @endphp

        <nav id="mobile-menu" class="mobile-menu">
            <ul class="flex items-center text-gray-primary desktop-menu space-x-8 ">
                <li class="">
                    <a href="{{ route('user.dashboard') }}"
                        class="text-base {{ $segment === 'dashboard' ? 'text-[#3d5ee1] font-semibold' : '' }}">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.resume.index') }}"
                        class="text-base {{ $segment === 'resume' ? 'text-[#3d5ee1] font-semibold' : '' }}">
                        Resume Builder
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.interview.index') }}"
                        class="text-base {{ $segment === 'interview' ? 'text-[#3d5ee1] font-semibold' : '' }}">
                        Classroom
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.airlineDirectory.index') }}"
                        class="text-base {{ $segment === 'airlines-directory' ? 'text-[#3d5ee1] font-semibold' : '' }}">
                        Airlines Directory
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.job.index') }}"
                        class="text-base {{ $segment === 'job' ? 'text-[#3d5ee1] font-semibold' : '' }}">
                        Jobs
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.resource.index') }}"
                        class="text-base {{ $segment === 'resource' || $segment === 'events' || $segment === 'organizations' ? 'text-[#3d5ee1] font-semibold' : '' }}">
                        Resource Library
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.forum.index') }}"
                        class="text-base {{ $segment === 'forum' ? 'text-[#3d5ee1] font-semibold' : '' }}">
                        Forum
                    </a>
                </li>
                <!-- <li>
                    <a href="{{ route('user.organizations.index') }}"
                        class="text-base {{ $segment === 'organizations' ? 'text-[#3d5ee1] font-semibold' : '' }}">
                        Organizations
                    </a>
                </li> -->
            </ul>
        </nav>

        <div class="flex gap-4 items-center">
            <div class="relative">
                <i id="notification-bell" class="pi pi-bell text-2xl text-white cursor-pointer"></i>
                <div id="notification-count"
                    class="absolute top-[-5px] right-[-5px] w-[18px] h-[18px] flex items-center justify-center border border-white bg-red-600 text-white rounded-full text-[12px] font-semibold">
                    0
                </div>

                <div id="notification-dropdown"
                    class="hidden absolute right-0 mt-2 w-96 max-h-96 bg-white shadow-xl rounded-lg overflow-y-auto z-50 border border-gray-200">
                    <div class="px-4 py-2 border-b border-gray-200 font-semibold text-gray-700 bg-gray-50">
                        Notifications
                    </div>
                    <ul id="notification-list" class="divide-y divide-gray-200"></ul>
                    <div class="px-4 py-2 text-center bg-gray-50">
                    </div>
                </div>
            </div>

            <div class="nav-item dropdown has-arrow new-user-menus">
                <a href="#" class="dropdown-toggle relative nav-divk" data-bs-toggle="dropdown">
                    <span class="user-img">
                        <img src="{{ Auth::user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('admin/assets/img/profiles/avatar-01.png') }}"
                            alt="User Image" class="avatar-img rounded-circle">
                        <div class="user-text">
                            <h6 class="text-white text-sm">{{ Auth::user()->name ?? 'N/A' }}</h6>
                        </div>
                    </span>
                </a>
                <div class="dropdown-menu">
                    <div class="user-header">
                        <div class="avatar avatar-sm">
                            <img src="{{ Auth::user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('admin/assets/img/profiles/avatar-01.png') }}"
                                alt="User Image" class="avatar-img rounded-circle">
                        </div>
                        <div class="user-text">
                            <h6>{{ Auth::user()->name ?? 'N/A' }}</h6>
                        </div>
                    </div>
                    <a class="dropdown-item" href="{{ route('user.profile.index') }}">My Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="feather-log-out me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        menu.classList.toggle('active');

        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');

        document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bell = document.getElementById('notification-bell');
        const dropdown = document.getElementById('notification-dropdown');
        const list = document.getElementById('notification-list');
        const countEl = document.getElementById('notification-count');

        function fetchNotifications() {
            fetch("{{ route('user.notifications.myNotifications') }}", {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
                .then(res => res.json())
                .then(data => {
                    countEl.textContent = data.count > 9 ? '9+' : data.count;

                    list.innerHTML = '';
                    if (data.notifications.length > 0) {
                        data.notifications.forEach(n => {
                            const li = document.createElement('li');
                            li.className = `px-4 py-3 hover:bg-gray-100 flex justify-between items-start ${n.status !== 'seen' ? 'bg-blue-50 font-medium' : ''}`;

                            li.innerHTML = `
                        <div class="flex flex-col">
                            <span class="text-gray-500 text-xs">From (${n.type})</span>
                            <p class="text-gray-800">${n.message}</p>
                            <span class="text-gray-400 text-xs">${new Date(n.created_at).toLocaleString()}</span>
                        </div>
                        <button data-id="${n.id}" class="delete-btn text-red-500 hover:text-red-700 ml-3">
                            <i class="pi pi-trash"></i>
                        </button>
                    `;
                            list.appendChild(li);
                        });

                        document.querySelectorAll('.delete-btn').forEach(btn => {
                            btn.addEventListener('click', function (e) {
                                e.stopPropagation();
                                const id = this.dataset.id;

                                fetch("{{ url('notifications/destroy') }}/" + id, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                    .then(res => res.json())
                                    .then(resp => {
                                        if (resp.success) {
                                            fetchNotifications();
                                        }
                                    })
                                    .catch(err => console.error(err));
                            });
                        });
                    } else {
                        const li = document.createElement('li');
                        li.className = 'px-4 py-3 text-gray-500 text-center';
                        li.textContent = 'No notifications';
                        list.appendChild(li);
                    }
                })
                .catch(err => console.error(err));
        }

        fetchNotifications();

        setInterval(fetchNotifications, 30000);

        bell.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');

            if (!dropdown.classList.contains('hidden')) {
                fetch("{{ route('user.notifications.markAllSeen') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(() => fetchNotifications());
            }
        });

        document.addEventListener('click', function (event) {
            if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>