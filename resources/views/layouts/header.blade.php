<nav class="app-header navbar navbar-expand bg-body"> <!--begin::Container-->
    <div class="container-fluid"> <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
        </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
        
        <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
            <li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i class="bi bi-search"></i> </a> </li> <!--end::Navbar Search--> <!--begin::Messages Dropdown Menu-->
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li> <!--end::Fullscreen Toggle--> <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"> <img src="{{asset('AdminLTE4/dist/assets/img/user8-128x128.jpg')}}" class="user-image rounded-circle shadow" alt="User Image"> <span class="d-none d-md-inline"> {{auth()->user()->name}}</span> </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"> <!--begin::User Image-->
                    <li class="user-header text-bg-primary"> <img src="{{asset('AdminLTE4/dist/assets/img/user8-128x128.jpg')}}" class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{auth()->user()->name}}
                            <small>{{auth()->user()->role}}</small>
                        </p>
                    </li> <!--end::User Image--> <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <!-- Profile Link -->
                        <a href="{{ route('profile.edit') }}" class="btn btn-default btn-flat">Profile</a>
                        
                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                Sign out
                            </a>
                        </form>
                    </li>
                </ul>
            </li> <!--end::User Menu Dropdown-->
        </ul> <!--end::End Navbar Links-->
    </div> <!--end::Container-->
</nav> <!--end::Header--> 