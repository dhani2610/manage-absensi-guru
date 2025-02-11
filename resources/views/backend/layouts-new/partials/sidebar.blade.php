<style>
    .active-title {
        color: #white !important;
    }


    .menu-inner {
        background: #3da601;
    }

    .menu-vertical .menu-item .menu-link {
        color: white
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme"
    style="    border-right: 3px solid rgb(114 113 113 / 52%);">
    <div class="app-brand demo ">
        <a href="#" class="app-brand-link">
            {{-- <span class="app-brand-logo demo">

      </span> --}}
            <img src="{{ asset('assets/img/logos/logo.png') }}" style="max-width: 30%">
            <span class=" demo fw-bold ms-2" style="color: black">Dashboard</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
   

    <div class="menu-inner-shadow" style="background: #3da601!Important"></div>

    <ul class="menu-inner py-1">


        @if ($usr->can('dashboard.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        @endif
        @if ($usr->can('absensi.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('absensi') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-camera"></i>
                <div data-i18n="Kelas">Absensi</div>
            </a>
        </li>
        @endif
        @if ($usr->can('catatan.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('catatan') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="Mata Pelajaran">Catatan Pelajaran</div>
            </a>
        </li>
        @endif
        @if ($usr->can('nilai.siswa.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('nilai.siswa') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="Nilai Siswa">Nilai Siswa</div>
            </a>
        </li>
        @endif
     
        @if ($usr->can('kelas.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('kelas') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-building"></i>
                <div data-i18n="Kelas">Kelas</div>
            </a>
        </li>
        @endif
        @if ($usr->can('siswa.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('siswa') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Siswa">Siswa</div>
            </a>
        </li>
        @endif
        @if ($usr->can('guru.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('guru') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div data-i18n="Guru">Guru</div>
            </a>
        </li>
        @endif
        @if ($usr->can('mata.pelajaran.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('mata.pelajaran') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="Mata Pelajaran">Mata Pelajaran</div>
            </a>
        </li>
        @endif
        @if ($usr->can('jadwal.view'))
        <li class="menu-item mb-2">
            <a href="{{ route('jadwal') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="Jadwal">Jadwal</div>
            </a>
        </li>
        @endif

        @if ($usr->can('admin.view') || $usr->can('role.view'))
            <li
                class="menu-item {{ Request::routeIs('admin/admins') || Request::routeIs('admin/roles') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">Management Users</div>
                </a>

                <ul class="menu-sub">
                    @if ($usr->can('role.view'))
                        <li class="menu-item">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Role & Permissions">Role & Permissions</div>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item {{ Request::routeIs('admin/admins') ? 'active' : '' }}">
                        <a href="{{ route('admin.admins.index') }}" class="menu-link">
                            <div data-i18n="Without menu"
                                style="color : {{ Request::routeIs('admin/admins') ? '#3da601' : '' }}">Users
                            </div>
                        </a>
                    </li>

                </ul>
            </li>
        @endif

    </ul>
</aside>
