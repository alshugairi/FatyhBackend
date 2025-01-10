<nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
        </ul>
        <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
            <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i class="bi bi-search"></i> </a> </li> <!--end::Navbar Search--> <!--begin::Messages Dropdown Menu-->
            <li class="nav-item dropdown"> <a class="nav-link" data-bs-toggle="dropdown" href="#"> <i class="bi bi-bell-fill"></i> <span class="navbar-badge badge text-bg-warning">15</span> </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span> </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-people-fill me-2"></i> 8 friend requests
                        <span class="float-end text-secondary fs-7">12 hours</span> </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"> <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                        <span class="float-end text-secondary fs-7">2 days</span> </a>
                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item dropdown-footer">
                        See All Notifications
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="bi bi-translate"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('language.switch', 'en') }}" data-language="en" data-text-direction="ltr">
                            <span class="align-middle">{{ __('admin.english') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('language.switch', 'ar') }}" data-language="ar" data-text-direction="rtl">
                            <span class="align-middle">{{ __('admin.arabic') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.pos.index') }}">
                    <i class="fas fa-cash-register"></i>
                </a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->

            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/admin') }}/images/avatar.png" class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end w-auto">
                    <li>
                        <a class="dropdown-item" href="">
                            <i class="ti ti-user-check me-2 ti-sm"></i>
                            <span class="align-middle">{{ __('admin.profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout me-2 ti-sm"></i>
                            <span class="align-middle">{{ __('admin.logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
    </div> <!--end::Container-->
</nav> <!--end::Header-->
