<nav class="mt-2"> <!--begin::Sidebar Menu-->
    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        <!-- Dashboard Menu -->
        <li class="nav-item">
            <a href="{{ route('dashboard')}}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : ''}}">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard</p>
            </a>
        </li>

       <!-- Dynamic Menus Based on Permissions -->
        @php
        $menus = getMenus();
        @endphp

        @if($menus && $menus->isNotEmpty())
        @foreach ($menus as $menu)
            @can('read ' . $menu->url)
                <li class="nav-item {{ request()->segment(1) == $menu->url ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->segment(1) == $menu->url ? 'active' : ''}}">
                        <i class="nav-icon {{ $menu->icon }}"></i>
                        <p>
                            {{ $menu->name }}
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <!-- Loop through Submenus -->
                        @foreach ($menu->subMenus as $submenu)
                            @can('read ' . $submenu->url)
                                <li class="nav-item">
                                    <a href="{{ url($submenu->url) }}" class="nav-link {{ request()->is($submenu->url) ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>{{ str_replace('_', ' ', $submenu->name) }}</p>
                                    </a>
                                </li>
                            @endcan
                        @endforeach
                    </ul>
                </li>
            @endcan
        @endforeach
        @else
        <p>No menus available.</p>
        @endif
    </ul> <!--end::Sidebar Menu-->
</nav>
