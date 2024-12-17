<nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        
        <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <!--end::Navbar Search-->
        
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
        
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ asset('AdminLTE4/dist/assets/img/user8-128x128.jpg') }}" class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end" style="background-color: #ffffff; border: 1px solid #FF9800;">
                    <!--begin::User Header-->
                    <li class="user-header text-center" style="background: #FF9800; color: #ffffff;">
                        <img src="{{ asset('AdminLTE4/dist/assets/img/user8-128x128.jpg') }}" class="rounded-circle shadow mb-2" alt="User Image">
                        <p>
                            <strong>{{ auth()->user()->name }}</strong>
                            <small class="text-light">{{ auth()->user()->getRoleNames()->join(', ') }}</small>
                        </p>
                    </li>
                    <!--end::User Header-->
        
                    <!--begin::Logout-->
                    <li class="user-footer text-center" style="padding: 10px; background-color: #f9f9f9; border-top: 1px solid #FF9800;">
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn btn-danger px-4 py-2" style="border-radius: 20px;">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                    <!--end::Logout-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        
    </div> <!--end::Container-->
</nav> <!--end::Header--> 