<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan Absensi {{ $employee->nama_lengkap }}</title>
  <style>
    body {
      font-family: 'Helvetica', sans-serif;
      font-size: 10px;
    }

    .header-table,
    .main-table {
      width: 100%;
      border-collapse: collapse;
    }

    .header-table td {
      padding: 4px;
      vertical-align: top;
    }

    .main-table th,
    .main-table td {
      border: 1px solid #ccc;
      padding: 6px;
      text-align: left;
    }

    .main-table th {
      background-color: #f2f2f2;
      text-align: center;
    }

    .text-center {
      text-align: center;
    }

    h3,
    h4 {
      margin: 0;
    }
  </style>
</head>

<body>
  <table class="header-table">
    <tr>
      <td>
        <h3>Laporan Absensi Karyawan</h3>
        <h4>Periode: {{ $namaBulan }} {{ $tahun }}</h4>
      </td>
      <td style="text-align: right;">
        <strong>{{ $employee->nama_lengkap }}</strong><br>
        <span>Posisi: {{ $employee->posisi ?? 'N/A' }}</span>
      </td>
    </tr>
  </table>

  <hr>

  <table class="main-table">
    <thead>
      <tr>
        <th style="width: 5%;">No</th>
        <th>Tanggal</th>
        <th>Hari</th>
        <th>Jam Masuk</th>
        <th>Jam Keluar</th>
        <th>Status</th>
        <th>Total Jam</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($attendances as $key => $att)
      <tr>
        <td class="text-center">{{ $key + 1 }}</td>
        <td class="text-center">{{ \Carbon\Carbon::parse($att->tanggal)->format('d-m-Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($att->tanggal)->isoFormat('dddd') }}</td>
        <td class="text-center">{{ $att->jam_masuk ? \Carbon\Carbon::parse($att->jam_masuk)->format('H:i') : '-' }}</td>
        <td class="text-center">{{ $att->jam_keluar ? \Carbon\Carbon::parse($att->jam_keluar)->format('H:i') : '-' }}</td>
        <td class="text-center">{{ $att->status_kehadiran ?? $att->status }}</td>
        <td class="text-center">{{ $att->total_jam_kerja_str ?? '-' }}</td>
        <td>
          {{ $att->keterangan ?? '' }}
          @if(!empty($att->jam_lebih_str))
          <span>({{ $att->jam_lebih_str }})</span>
          @endif
          @if($att->jam_masuk && !$att->jam_keluar && ($att->status == 'Hadir' || $att->status == 'Masuk'))
          <strong style="color: red;">Belum Absen Keluar!</strong>
          @endif
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" class="text-center">Tidak ada data absensi untuk periode ini.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</body>

</html>