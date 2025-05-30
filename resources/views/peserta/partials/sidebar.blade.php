<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">peserta</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('peserta.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('peserta.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('peserta.acara.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('peserta.acara.index') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Available Events</span>
        </a>
    </li>
    
    <li class="nav-item {{ request()->routeIs('peserta.riwayat.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('peserta.riwayat.index') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>My Registrations</span>
        </a>
    </li>
    
    <li class="nav-item {{ request()->routeIs('peserta.pengumuman.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('peserta.pengumuman.index') }}">
            <i class="fas fa-fw fa-trophy"></i>
            <span>Event Results</span>
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