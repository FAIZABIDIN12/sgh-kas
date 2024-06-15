<aside class="left-sidebar">
    <div>
        <div class="brand-logo pt-3 d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="w-100 logo-img">
                <img class="w-100" src="{{ asset('assets/images/logos/logo-main.png') }}" width="" height="" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Laporan Aliran Kas</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/kas-masuk') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-arrow-bar-to-down"></i>
                        </span>
                        <span class="hide-menu">Tambah Kas Masuk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/kas-keluar') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-arrow-bar-up"></i>
                        </span>
                        <span class="hide-menu">Tambah Kas Keluar</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/lap-akun') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-file-invoice"></i>
                        </span>
                        <span class="hide-menu">Laporan Akun</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Invoice & Grup</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/invoice') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-file-invoice"></i>
                        </span>
                        <span class="hide-menu">Invoice</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/kas-masuk-group') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-businessplan"></i>
                        </span>
                        <span class="hide-menu">Kas Tamu Grup</span>
                    </a>
                </li>
                @auth
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Admin</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('jenis-kas') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-file-invoice"></i>
                        </span>
                        <span class="hide-menu">Jenis Kas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('form-import-cashflow') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-file-invoice"></i>
                        </span>
                        <span class="hide-menu">Import Data Excel</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/manage-user') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">Kelola User</span>
                    </a>
                </li>
                @endif
                @endauth
            </ul>
        </nav>
    </div>
</aside>