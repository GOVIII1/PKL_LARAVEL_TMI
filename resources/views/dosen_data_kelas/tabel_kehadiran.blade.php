<table id="example1" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th width="5%">No</th>
      <th>Mahasiswa</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($presensi as $data)
      <tr>
        <td>{{ $loop->iteration }}</td>
        
        <td>{{ $data->mahasiswa->nama ?? 'Nama Tidak Ditemukan' }}</td>
        
        <td>
          @if ($data->status_kehadiran == '1')
            Alpha
          @elseif ($data->status_kehadiran == '2')
            Hadir
          @elseif ($data->status_kehadiran == '3')
            Sakit
          @elseif ($data->status_kehadiran == '4')
            Izin
          @else
            Dispen
          @endif
        </td>
        
        <td>
          <button type="button" class="btn btn-success btn-sm" data-toggle="modal" 
                  data-target="#modal-edit" 
                  data-id="{{ $data->id }}"
                  data-status_kehadiran="{{ $data->status_kehadiran }}">
            <i class="fas fa-edit"></i> 
          </button>                                   
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="4" class="text-center">Belum ada data mahasiswa.</td>
      </tr>
    @endforelse
  </tbody>
</table>