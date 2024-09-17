<nav class="mt-2"> <!--begin::Sidebar Menu-->
    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
        <li class="nav-item"> <a href="{{ route('dashboard')}}" class="nav-link {{ request()->segment(1) == 'dashboard' ? 'active' : ''}}"> <i class="nav-icon bi bi-speedometer"></i>
            <p>Dashboard</p>
        </a> </li>


        @foreach (getMenus() as $menu)
            @can('read ' .$menu->url)        
                <li class="nav-item"> <a href="#" class="nav-link {{ request()->segment(1) == $menu->url ? 'menu-open' : ''}}"> <i class="nav-icon {{ $menu->icon }}"></i>
                        <p>
                        {{ $menu->name }}
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach ($menu->subMenus as $submenu)
                                @can('read ' .$submenu->url)
                                    <li class="nav-item">
                                        <a href="{{ url($submenu->url) }}" class="nav-link {{ request()->is($submenu->url) ? 'active' : '' }}">
                                            <i class="nav-icon bi bi-circle"></i>
                                            <p>{{ $submenu->name }}</p>
                                        </a>
                                    </li> 
                                @endcan
                            @endforeach
                            
                        </ul>
                </li>   
            @endcan
        @endforeach

        {{-- <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
            <p>
                Rekam Kegiatan
                <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item"> <a href="pendanaan" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                        <p>Pendanaan</p>
                    </a> </li>
            </ul>
        </li>

        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                <p>
                    Kelola Kegiatan
                    <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item"> <a href="kategorikegiatan" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                        <p>Kategori Kegiatan</p>
                    </a> </li>
                <li class="nav-item"> <a href="jeniskegiatan" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                        <p>Jenis Kegiatan</p>
                    </a> </li>
                <li class="nav-item"> <a href="jenistahapan" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                        <p>Jenis Tahapan</p>
                    </a> </li>
                <li class="nav-item"> <a href="buatkegiatan" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                        <p>Buat Kegiatan</p>
                    </a> </li>
            </ul>
        </li>
        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-clipboard-fill"></i>
                <p>
                   Beasiswa
                   <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                        <p>Data Beasiswa</p>
                    </a> </li>
                <li class="nav-item"> <a href="listBeasiswa" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                        <p>Daftar Beasiswa</p>
                    </a> </li>
                <li class="nav-item"> <a href="./layout/fixed-complete.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                        <p>Surat</p>
                    </a> </li>
            </ul>
        </li>
        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                <p>
                   Kelola Usulan
                    <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item"> <a href="admin/usulanPendanaan" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                        <p>Daftar Usulan</p>
                    </a> </li>
            </ul>
        </li> --}}
       
    </ul> <!--end::Sidebar Menu-->
</nav>