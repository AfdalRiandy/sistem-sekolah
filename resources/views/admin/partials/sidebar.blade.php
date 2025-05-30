<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">admin</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen
    </div>

    <!-- Nav Item - User Management -->
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>User Management</span></a>
    </li>

    <!-- Nav Item - Acara Management -->
    <li class="nav-item {{ request()->routeIs('admin.acara.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.acara.index') }}">
            <i class="fas fa-solid fa-calendar-plus"></i>
            <span>Acara Management</span></a>
    </li>

    <!-- Nav Item - Participants -->
    <li class="nav-item {{ request()->routeIs('admin.peserta.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.peserta.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Event Participants</span>
        </a>
    </li>
    
    <!-- Nav Item - Scoring -->
    <li class="nav-item {{ request()->routeIs('admin.penilaian.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.penilaian.index') }}">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Participant Scoring</span>
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