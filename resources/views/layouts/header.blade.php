<header class="bg-transparent absolute header shadow-sm p-6 w-full">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo">
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <button id="menu-toggle" class="lg:hidden ml-4 p-2 rounded-md text-gray-500 focus:outline-none">
            <!-- Default Hamburger Icon -->
            <svg id="menu-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <!-- Close Icon (hidden by default) -->
            <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Navigation -->
        @if (Request::is('/') || Request::is('home') || Request::is('terms-services') || Request::is('privacy-policies') || Request::is('cookies-policies'))
            <nav id="mobile-menu" class="hidden lg:block">
                <ul class="md:flex items-center text-white desktop-menu space-y-4 md:space-y-0 md:space-x-4">

                    <li><a href="{{ route('user.resume.index') }}" class="text-lg hover:text-gray-300">Resume Builder</a>
                    </li>
                    <li><a href="{{ route('user.job.index') }}" class="text-lg hover:text-gray-300">Job Search</a></li>
                    <li><a href="{{ route('user.airlineDirectory.index') }}" class="text-lg hover:text-gray-300">Airlines
                            Directory</a></li>

                    <li class="flex items-center space-x-2">
                        @auth
                            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('user.dashboard') }}">
                                <button class="primary-button px-4 py-2 rounded">Dashboard</button>
                            </a>

                        @else
                            <a href="{{ url('login') }}">
                                <button class="primary-button px-4 py-2 rounded">Log In</button>
                            </a>
                            <a href="{{ url('register') }}">
                                <button class="outline-button px-4 py-2 rounded">Register</button>
                            </a>
                        @endauth
                    </li>

                </ul>
            </nav>
        @endif

    </div>
</header>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        menu.classList.toggle('active');
        menu.classList.toggle('hidden');

        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');

        document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
    });
</script>