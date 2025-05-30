<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">panitia</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('panitia.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('panitia.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('panitia.peserta.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('panitia.peserta.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Manage Participants</span>
        </a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

        <!-- Nav Item - Return to Home -->
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>Kembali ke Beranda</span></a>
        </li>
</ul>