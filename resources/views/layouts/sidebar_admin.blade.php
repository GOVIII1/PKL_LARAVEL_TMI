<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('home.admin')}}" class="nav-link {{request ()->routeIs('home.admin') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Beranda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.data_administrator')}}" class="nav-link {{request ()->routeIs('admin.data_administrator') ? 'active' : ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Data Administrator
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.mahasiswa.index')}}" class="nav-link {{request()->routeIs('admin.mahasiswa.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                Data Mahasiswa
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.dosen.index')}}" class="nav-link {{request()->routeIs('admin.dosen.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Data Dosen
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.matkul.index')}}" class="nav-link {{request ()->routeIs('admin.matkul.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Data Mata Kuliah
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.perak.index')}}" class="nav-link {{request ()->routeIs('admin.perak.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Data Periode Akademik
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.jurusan.index')}}" class="nav-link {{request ()->routeIs('admin.jurusan.*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Data Jurusan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.kelas.index') }}" class="nav-link {{ request()->routeIs('admin.kelas.*','admin.detail.kelas.*','admin.pertemuan.*','admin.presensi.*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>
                Kelas Mata Kuliah
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.ganti.password.index') }}" class="nav-link {{ request()->routeIs('admin.ganti.password.*') ? 'active' : '' }}">
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