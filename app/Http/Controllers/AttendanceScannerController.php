<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel; // Pastikan use statement ini ada
use App\Exports\DailyAttendanceReportExport; // Pastikan use statement ini ada

class AttendanceScannerController extends Controller
{
    /**
     * Menampilkan halaman scanner QR Code.
     */
    public function index()
    {
        return view('attendance.scan');
    }

    /**
     * Memproses hasil scan QR Code untuk absen masuk atau keluar.
     */
    public function processScan(Request $request)
    {
        $validatedData = $request->validate([
            'qr_code' => 'required|string',
            'action' => 'required|string|in:in,out',
        ]);

        $employee = \App\Models\Employee::where('employee_id_unik', $validatedData['qr_code'])->first();

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'QR Code Karyawan Tidak Dikenali!'], 404);
        }

        $today = \Carbon\Carbon::today();
        $now = \Carbon\Carbon::now();
        $action = $validatedData['action'];

        // Cari record absensi yang sudah ada untuk karyawan ini pada hari ini
        $attendance = \App\Models\Attendance::where('employee_id', $employee->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($action === 'in') {
            // Validasi: Karyawan hanya boleh absen masuk 1x sehari jika siklus masuk-keluar sudah lengkap.
            if ($attendance && $attendance->jam_masuk && !is_null($attendance->jam_keluar)) {
                return response()->json([
                    'success' => false,
                    'message' => $employee->nama_lengkap . ' sudah menyelesaikan absensi (masuk & keluar) hari ini. Tidak bisa absen masuk lagi.'
                ], 400);
            }

            // Validasi: Cek apakah sedang dalam status "Hadir" (sudah masuk, belum keluar)
            if ($attendance && $attendance->jam_masuk && is_null($attendance->jam_keluar)) {
                return response()->json(['success' => false, 'message' => $employee->nama_lengkap . ' sudah absen masuk hari ini dan belum absen keluar. Pilih "Absen Pulang" jika ingin keluar.'], 400);
            }

            // Lanjutkan proses absen masuk
            \App\Models\Attendance::updateOrCreate(
                ['employee_id' => $employee->id, 'tanggal' => $today], // Kunci untuk mencari/membuat
                [ // Data untuk diisi/diupdate
                    'jam_masuk' => $now->toTimeString(),
                    'jam_keluar' => null,
                    'status' => 'Hadir',
                    'keterangan' => $attendance->keterangan ?? null
                ]
            );
            return response()->json(['success' => true, 'message' => 'BERHASIL MASUK: ' . $employee->nama_lengkap . ' (' . $now->format('H:i') . ')']);
        } elseif ($action === 'out') {
            // Logika untuk Absen Pulang
            if (!$attendance || is_null($attendance->jam_masuk)) {
                return response()->json(['success' => false, 'message' => $employee->nama_lengkap . ' belum melakukan absen masuk hari ini.'], 400);
            }
            if ($attendance && !is_null($attendance->jam_keluar)) {
                return response()->json(['success' => false, 'message' => $employee->nama_lengkap . ' sudah melakukan absen keluar hari ini.'], 400);
            }

            $attendance->update([
                'jam_keluar' => $now->toTimeString(),
                'status' => 'Pulang'
            ]);
            return response()->json(['success' => true, 'message' => 'BERHASIL PULANG: ' . $employee->nama_lengkap . ' (' . $now->format('H:i') . ')']);
        }

        return response()->json(['success' => false, 'message' => 'Aksi tidak valid.'], 400);
    }



    /**
     * Mengambil data absensi hari ini untuk ditampilkan secara real-time.
     */
    public function getTodaysAttendance()
    {
        $today = Carbon::today();
        $attendances = Attendance::with('employee')
            ->whereDate('tanggal', $today)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json($attendances);
    }
}
