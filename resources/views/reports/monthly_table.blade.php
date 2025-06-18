<div class="card mt-4">
  <div class="card-header">
    <h5 class="mb-0">
      Hasil Laporan:
      {{ \Carbon\Carbon::createFromDate($selectedCriteria['tahun'], $selectedCriteria['bulan'], 1)->isoFormat('MMMM YYYY') }}
      @if($selectedCriteria['employee_id'] && isset($employees))
      @php
      $selectedEmployee = $employees->firstWhere('id', $selectedCriteria['employee_id']);
      @endphp
      - {{ $selectedEmployee ? $selectedEmployee->nama_lengkap : 'Karyawan Terpilih' }}
      @else
      - Semua Karyawan
      @endif
    </h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-sm table-bordered table-striped table-hover">
        <thead class="table-light"> {{-- Header tabel terang agar teks gelap kontras --}}
          <tr>
            <th class="text-center text-dark" style="width: 5%;">No</th>
            @if(!$selectedCriteria['employee_id'])
            <th class="text-dark">Nama Karyawan</th>
            @endif
            <th class="text-center text-dark">Tanggal</th>
            <th class="text-center text-dark">Jam Masuk</th>
            <th class="text-center text-dark">Jam Keluar</th>
            <th class="text-center text-dark">Status</th>
            <th class="text-center text-dark">Total Jam Kerja</th>
            <th class="text-dark">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($attendances as $key => $att)
          <tr class="text-light"> {{-- Teks isi tabel terang --}}
            <td class="text-center">{{ $key + 1 }}</td>
            @if(!$selectedCriteria['employee_id'])
            <td>{{ $att->employee ? $att->employee->nama_lengkap : 'N/A' }}</td>
            @endif
            {{-- POIN 1: Format Tanggal (Hari, DD-MM-YYYY) --}}
            <td class="text-center">{{ \Carbon\Carbon::parse($att->tanggal)->isoFormat('dddd, DD-MM-YYYY') }}</td>
            <td class="text-center">{{ $att->jam_masuk ? \Carbon\Carbon::parse($att->jam_masuk)->format('H:i') : '-' }}</td>
            <td class="text-center">{{ $att->jam_keluar ? \Carbon\Carbon::parse($att->jam_keluar)->format('H:i') : '-' }}</td>
            <td class="text-center">
              @php
              $statusUntukCek = $att->status_kehadiran ?? $att->status;
              @endphp
              @if($statusUntukCek == 'Hadir')
              <span class="badge bg-success">Hadir</span>
              @elseif($statusUntukCek == 'Pulang')
              <span class="badge bg-primary">Pulang</span>
              @elseif($statusUntukCek == 'Izin')
              <span class="badge bg-info text-dark">Izin</span>
              @elseif($statusUntukCek == 'Sakit')
              <span class="badge bg-warning text-dark">Sakit</span>
              @elseif($statusUntukCek == 'Alpha')
              <span class="badge bg-danger">Alpha</span>
              @else
              <span class="badge bg-secondary">{{ $statusUntukCek }}</span>
              @endif
            </td>
            {{-- POIN 2: Total Jam Kerja --}}
            <td class="text-center">{{ $att->total_jam_kerja_str ?? '-' }}</td>
            <td>
              {{ $att->keterangan ?? '' }}
              {{-- POIN 2: Jam Lebih --}}
              @if(!empty($att->jam_lebih_str))
              <span class="text-warning d-block fw-semibold">({{ $att->jam_lebih_str }})</span>
              @endif
              {{-- POIN 4: Lupa Absen Keluar --}}
              @if($att->jam_masuk && !$att->jam_keluar && ($statusUntukCek == 'Hadir' || $statusUntukCek == 'Masuk'))
              <span class="text-danger d-block fw-bold">Belum Absen Keluar!</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            {{-- Sesuaikan colspan berdasarkan apakah nama karyawan ditampilkan --}}
            <td colspan="{{ !$selectedCriteria['employee_id'] ? '8' : '7' }}" class="text-center fst-italic text-light">
              Tidak ada data absensi untuk kriteria yang dipilih.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>