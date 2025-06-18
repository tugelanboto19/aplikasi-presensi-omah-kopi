<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Menampilkan form untuk mencatat absensi manual (Izin/Sakit/Alpha).
     *
     * @return \Illuminate\View\View
     */
    public function createManualForm()
    {
        // Mengambil daftar semua karyawan untuk ditampilkan di dropdown form.
        $employees = Employee::orderBy('nama_lengkap')->get();

        // *** INI ADALAH PERBAIKANNYA ***
        // Mengubah 'attendances.manual-input' menjadi 'attendances.manual_form' agar cocok dengan nama file Anda.
        return view('attendances.manual_form', compact('employees'));
    }

    /**
     * Menyimpan data absensi manual (Izin/Sakit/Alpha) dari form ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeManualAttendance(Request $request)
    {
        // 1. Validasi input dari form
        $validatedData = $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'tanggal'     => 'required|date',
            'status'      => 'required|string|in:Izin,Sakit,Alpha',
            'keterangan'  => 'nullable|string|max:500',
        ]);

        // 2. Simpan atau Update data absensi menggunakan updateOrCreate.
        // Ini akan mencari absensi berdasarkan employee_id dan tanggal.
        // Jika ada, data akan di-update. Jika tidak, data baru akan dibuat.
        $attendance = Attendance::updateOrCreate(
            [
                'employee_id' => $validatedData['employee_id'],
                'tanggal'     => $validatedData['tanggal'],
            ],
            [
                'status'      => $validatedData['status'],
                'keterangan'  => $validatedData['keterangan'],
                'jam_masuk'   => null, // Izin/Sakit/Alpha tidak memiliki jam masuk/keluar.
                'jam_keluar'  => null,
            ]
        );

        // 3. Redirect kembali dengan pesan sukses.
        // Mengarahkan ke rute 'laporan.harian' yang sudah ada.
        return redirect()->route('laporan.harian')
            ->with('success', 'Data absensi manual untuk karyawan ' . $attendance->employee->nama_lengkap . ' berhasil disimpan!');
    }

    /**
     * Mengambil data absensi untuk hari ini.
     * Digunakan oleh halaman Scan Absensi untuk menampilkan tabel secara real-time.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTodaysAttendance()
    {
        $today = Carbon::today();

        // Mengambil data absensi hari ini, termasuk relasi ke data karyawan.
        $attendances = Attendance::with('employee')
            ->whereDate('tanggal', $today)
            ->orderBy('updated_at', 'desc') // Tampilkan yang terbaru di atas.
            ->get();

        // Mengirimkan data sebagai response JSON.
        return response()->json($attendances);
    }
}
