<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DailyAttendanceReportExport;

class DailyReportController extends Controller
{
  public function index(Request $request)
  {
    $request->validate(['tanggal' => 'nullable|date', 'employee_id' => 'nullable|integer|exists:employees,id']);
    $filters = ['tanggal' => $request->input('tanggal', Carbon::today()->toDateString()), 'employee_id' => $request->input('employee_id')];
    $query = Attendance::with('employee')->whereDate('tanggal', $filters['tanggal']);
    if ($filters['employee_id']) {
      $query->where('employee_id', $filters['employee_id']);
    }
    $attendances = $query->orderBy('jam_masuk', 'asc')->get();
    $employees = Employee::orderBy('nama_lengkap')->get();
    return view('reports.daily', compact('attendances', 'employees', 'filters'));
  }

  public function export(Request $request)
  {
    $validated = $request->validate(['tanggal' => 'required|date', 'employee_id' => 'required|integer|exists:employees,id']);
    $employee = Employee::find($validated['employee_id']);
    $fileName = 'Laporan_Harian_' . str_replace(' ', '_', $employee->nama_lengkap) . '_' . $validated['tanggal'] . '.xlsx';
    return Excel::download(new DailyAttendanceReportExport($validated['tanggal'], $validated['employee_id']), $fileName);
  }
}
