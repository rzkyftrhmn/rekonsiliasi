<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-handshake"></i>
        </div>
        <div class="sidebar-brand-text mx-3">REKONSILIASI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- ================= ADMIN ================= -->
    @if(auth()->user()->role === 'admin')

    <div class="sidebar-heading">
        Admin
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-user-alt"></i>
            <span>User</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster">
            <i class="fas fa-fw fa-database"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseMaster" class="collapse">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.skpd.index') }}">Instansi</a>
                <a class="collapse-item" href="{{ route('admin.periode.index') }}">Periode</a>
                <a class="collapse-item" href="{{ route('admin.rekening.index') }}">Rekening</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    @endif

    <!-- ================= REKONSILIASI ================= -->
    <div class="sidebar-heading">
        Rekonsiliasi
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('rekonsiliasi.index') }}">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Data Rekonsiliasi</span>
        </a>
    </li>
</ul>
<!-- End of Sidebar -->