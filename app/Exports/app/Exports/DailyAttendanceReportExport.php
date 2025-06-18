<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class DailyAttendanceReportExport implements FromCollection, WithHeadings, WithMapping
{
  protected $tanggal;
  protected $employeeId;
  public function __construct(string $tanggal, int $employeeId)
  {
    $this->tanggal = $tanggal;
    $this->employeeId = $employeeId;
  }
  public function collection()
  {
    return Attendance::with('employee')->where('employee_id', $this->employeeId)->whereDate('tanggal', $this->tanggal)->get();
  }
  public function headings(): array
  {
    return ['Nama Karyawan', 'Tanggal', 'Hari', 'Jam Masuk', 'Jam Keluar', 'Status', 'Keterangan'];
  }
  public function map($attendance): array
  {
    return [
      $attendance->employee->nama_lengkap,
      Carbon::parse($attendance->tanggal)->format('d-m-Y'),
      Carbon::parse($attendance->tanggal)->isoFormat('dddd'),
      $attendance->jam_masuk ? Carbon::parse($attendance->jam_masuk)->format('H:i') : '-',
      $attendance->jam_keluar ? Carbon::parse($attendance->jam_keluar)->format('H:i') : '-',
      $attendance->status,
      $attendance->keterangan ?? ''
    ];
  }
}
