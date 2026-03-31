<div class="header">

    <div class="header-left">
        <a href="{{route('admin.dashboard')}}" class="logo">
            <img src="{{ asset('admin/assets/img/logo.png')}}" alt="Logo">
        </a>
        <a href="{{route('admin.dashboard')}}" class="logo logo-small">
            <img src="{{ asset('admin/assets/img/logo-small.jpg')}}" alt="Logo" width="30" height="30">
        </a>
    </div>
    <div class="menu-toggle">
        <a href="javascript:void(0);" id="toggle_btn">
            <i class="fas fa-bars"></i>
        </a>
    </div>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>
    </a>

    <ul class="nav user-menu">
         
        <li class="nav-item zoom-screen me-2">
            <a href="#" class="nav-link header-nav-list win-maximize">
                <img src="{{ asset('admin/assets/img/icons/header-icon-04.svg')}}" alt="">
            </a>
        </li>

        <li class="nav-item dropdown has-arrow new-user-menus">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img d-flex align-items-center">
                    <img class="rounded-circle" src="{{ asset('admin/assets/img/profiles/avatar-01.png') }}" width="31" alt="{{ Auth::user()->name }}">
                    <div class="user-text ms-2 lh-1">
                        <h6 class="text-white mb-0">{{ Auth::user()->name }}</h6>
                        <span class="text-white mb-0">{{ Auth::user()->email }}</span>
                    </div>
                </span>
            </a>

            <div class="dropdown-menu">
                <div class="user-header">
                    <div class="avatar avatar-sm">
                        <img src="{{ asset('admin/assets/img/profiles/avatar-01.png')}}" alt="User Image"
                            class="avatar-img rounded-circle">
                    </div>
                    <div class="user-text ms-2">
                        <h6>{{ Auth::user()->name }}</h6>
                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <!-- <a class="dropdown-item" href="{{route('admin.profile')}}">My Profile</a> -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="feather-log-out me-1"></i> Logout
                    </button>
                </form>
            </div>
        </li>

    </ul>

</div>