<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use App\Exports\MonthlyAttendanceReportExport;
use Maatwebsite\Excel\Facades\Excel;

class MonthlyReportController extends Controller
{
  /**
   * Menampilkan halaman laporan bulanan beserta datanya.
   */
  public function index(Request $request)
  {
    $filters = [
      'bulan'       => $request->input('bulan', date('m')),
      'tahun'       => $request->input('tahun', date('Y')),
      'employee_id' => $request->input('employee_id'),
    ];

    $query = Attendance::with('employee')
      ->whereYear('tanggal', $filters['tahun'])
      ->whereMonth('tanggal', $filters['bulan']);

    if (!empty($filters['employee_id'])) {
      $query->where('employee_id', $filters['employee_id']);
    }

    $attendances = $query->orderBy('tanggal', 'asc')->get();

    foreach ($attendances as $attendance) {
      if ($attendance->jam_masuk && $attendance->jam_keluar) {
        $jamMasuk = Carbon::parse($attendance->jam_masuk);
        $jamKeluar = Carbon::parse($attendance->jam_keluar);
        // *** PERUBAHAN FORMAT DI SINI ***
        $attendance->work_duration = $jamKeluar->diff($jamMasuk)->format('%H jam %I menit %S detik');
      } else {
        $attendance->work_duration = '-';
      }
    }

    $employees = Employee::orderBy('nama_lengkap')->get();

    // *** PERBAIKAN DI SINI: Mengarahkan ke view yang benar ***
    return view('reports.monthly_form', compact('attendances', 'employees', 'filters'));
  }

  /**
   * Fungsi untuk mengekspor laporan bulanan ke Excel.
   */
  public function export(Request $request)
  {
    $filters = [
      'bulan'       => $request->input('bulan'),
      'tahun'       => $request->input('tahun'),
      'employee_id' => $request->input('employee_id'),
    ];

    // Cek jika employee_id kosong, redirect dengan pesan error
    if (empty($filters['employee_id'])) {
      return redirect()->back()->with('error', 'Harap pilih salah satu karyawan untuk mengekspor laporan.');
    }

    $employeeName = 'Karyawan';
    $employee = Employee::find($filters['employee_id']);
    if ($employee) {
      $employeeName = str_replace(' ', '_', $employee->nama_lengkap);
    }

    $fileName = 'Laporan_Bulanan_' . $employeeName . '_' . $filters['bulan'] . '_' . $filters['tahun'] . '.xlsx';

    // Mengirimkan filter sebagai argumen terpisah
    return Excel::download(new MonthlyAttendanceReportExport($filters['bulan'], $filters['tahun'], $filters['employee_id']), $fileName);
  }
}
