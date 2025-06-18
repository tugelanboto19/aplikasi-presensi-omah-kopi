<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover table-sm">
    <thead class="table-light">
      <tr>
        <th class="text-center text-dark">No</th>
        <th class="text-dark">Nama</th>
        <th class="text-center text-dark">Masuk</th>
        <th class="text-center text-dark">Keluar</th>
        <th class="text-center text-dark">Status</th>
        <th class="text-dark">Keterangan</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($attendances as $attendance)
      <tr>
        <td class="text-center">{{ $loop->iteration }}</td>
        <td>{{ $attendance->employee->nama_lengkap }}</td>
        <td class="text-center">{{ $attendance->jam_masuk ? \Carbon\Carbon::parse($attendance->jam_masuk)->format('H:i') : '-' }}</td>
        <td class="text-center">{{ $attendance->jam_keluar ? \Carbon\Carbon::parse($attendance->jam_keluar)->format('H:i') : '-' }}</td>
        <td class="text-center"><span class="badge bg-success">{{ $attendance->status }}</span></td>
        <td>{{ $attendance->keterangan }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="text-center fst-italic">Tidak ada data.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>