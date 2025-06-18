{{-- File: resources/views/exports/monthly_report_export_template.blade.php --}}
<table>
  <thead>
    <tr>
      <th colspan="7" style="text-align: center; font-weight: bold; font-size: 14px;">LAPORAN ABSENSI KARYAWAN</th>
    </tr>
    <tr></tr>
    <tr>
      <td colspan="2">Nama Karyawan</td>
      <td colspan="5">: {{ $employee->nama_lengkap }}</td>
    </tr>
    <tr>
      <td colspan="2">Posisi</td>
      <td colspan="5">: {{ $employee->posisi }}</td>
    </tr>
    <tr>
      <td colspan="2">Periode Laporan</td>
      <td colspan="5">: {{ $monthName }} {{ $year }}</td>
    </tr>
    <tr></tr>
    <tr>
      <th style="font-weight: bold; text-align: center;">Tanggal</th>
      <th style="font-weight: bold; text-align: center;">Jam Masuk</th>
      <th style="font-weight: bold; text-align: center;">Jam Keluar</th>
      <th style="font-weight: bold; text-align: center;">Status</th>
      <th style="font-weight: bold; text-align: center;">Total Jam Kerja</th>
      <th style="font-weight: bold; text-align: center;">Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @foreach($attendances as $attendance)
    <tr>
      <td>{{ $attendance['full_date'] }}</td>
      <td style="text-align: center;">{{ $attendance['jam_masuk'] }}</td>
      <td style="text-align: center;">{{ $attendance['jam_keluar'] }}</td>
      <td style="text-align: center;">{{ $attendance['status'] }}</td>
      <td style="text-align: center;">{{ $attendance['work_duration'] }}</td>
      <td>{{ $attendance['keterangan'] }}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr></tr>
    <tr>
      <td colspan="3" style="font-weight: bold;">RINGKASAN TOTAL</td>
    </tr>
    <tr>
      <td>Total Hari Efektif</td>
      <td colspan="2">: {{ $summary['total_hari_efektif'] }} hari</td>
    </tr>
    <tr>
      <td>Total Jam Kerja Aktual</td>
      <td colspan="2">: {{ gmdate('H\ \j\a\m i\ \m\e\n\i\t s\ \d\e\t\i\k', $summary['total_detik_kerja']) }}</td>
    </tr>
    <tr>
      <td>Jumlah Hari Hadir/Pulang</td>
      <td colspan="2">: {{ $summary['hadir_pulang'] }} hari</td>
    </tr>
    <tr>
      <td>Jumlah Hari Sakit</td>
      <td colspan="2">: {{ $summary['sakit'] }} hari</td>
    </tr>
    <tr>
      <td>Jumlah Hari Izin</td>
      <td colspan="2">: {{ $summary['izin'] }} hari</td>
    </tr>
    <tr>
      <td>Jumlah Hari Alpha</td>
      <td colspan="2">: {{ $summary['alpha'] }} hari</td>
    </tr>
    <tr>
      <td>Jumlah Hari LIBUR (Tanpa Scan)</td>
      <td colspan="2">: {{ $summary['libur'] }} hari</td>
    </tr>
  </tfoot>
</table>