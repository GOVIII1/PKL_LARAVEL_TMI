<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('home.dosen')}}" class="nav-link {{request ()->routeIs('home.dosen') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('dosen.kelas.index') }}" class="nav-link {{ request()->routeIs('dosen.kelas.*','dosen.detail.kelas.*','dosen.pertemuan.*','dosen.presensi.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                Kelas Mata Kuliah
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('dosen.ganti.password.index') }}" class="nav-link {{ request()->routeIs('dosen.ganti.password.*') ? 'active' : '' }}">
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