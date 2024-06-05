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
                    <a class="sidebar-link" href="./" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./kas-masuk" aria-expanded="false">
                        <span>
                            <i class="ti ti-arrow-bar-to-down"></i>
                        </span>
                        <span class="hide-menu">Tambah Kas Masuk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./kas-keluar" aria-expanded="false">
                        <span>
                            <i class="ti ti-arrow-bar-up"></i>
                        </span>
                        <span class="hide-menu">Tambah Kas Keluar</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./kas-masuk-group" aria-expanded="false">
                        <span>
                            <i class="ti ti-businessplan"></i>
                        </span>
                        <span class="hide-menu">Kas Masuk Tamu Group</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Invoice</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./invoice" aria-expanded="false">
                        <span>
                            <i class="ti ti-file-invoice"></i>
                        </span>
                        <span class="hide-menu">Laporan Invoice</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./lap-akun" aria-expanded="false">
                        <span>
                            <i class="ti ti-user-check"></i>
                        </span>
                        <span class="hide-menu">Laporan Akun</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>