<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="{{route('home.mahasiswa')}}" class="nav-link {{request()->routeIs('home.mahasiswa') ? 'active' : ''}}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Beranda
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('mahasiswa.presensi')}}" class="nav-link {{request()->routeIs('mahasiswa.presensi') ? 'active' : ''}}">
        <i class="nav-icon fas fa-qrcode"></i>
        <p>
          Presensi
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('mahasiswa.ganti.password.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.ganti.password.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-key"></i>
        <p>
          Ganti Password
        </p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{route('logout')}}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>
          Keluar
        </p>
      </a>
    </li>
  </ul>
</nav>