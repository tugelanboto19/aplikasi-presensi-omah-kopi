<?php
/* ============================================================
  File: routes/web.php
  Deskripsi: File routing utama yang sudah lengkap.
============================================================
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceScannerController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\MonthlyReportController;
use App\Http\Controllers\ProfileController;

// Rute untuk halaman utama, mengarahkan ke dashboard jika sudah login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// Rute dashboard yang memerlukan autentikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Rute untuk manajemen profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute resource untuk manajemen karyawan
    Route::resource('employees', EmployeeController::class);
    Route::get('employees/{employee}/qrcode', [EmployeeController::class, 'showQrCode'])->name('employees.qrcode');

    // Rute fungsionalitas absensi
    Route::get('/scan', [AttendanceScannerController::class, 'index'])->name('attendance.scan');
    Route::post('/scan/process', [AttendanceScannerController::class, 'processScan'])->name('attendance.process');
    Route::get('/attendances/today', [AttendanceController::class, 'getTodaysAttendance'])->name('attendances.today');
    Route::get('/attendances/manual/create', [AttendanceController::class, 'createManualForm'])->name('attendances.manual.create');
    Route::post('/attendances/manual', [AttendanceController::class, 'storeManualAttendance'])->name('attendances.manual.store');

    // Grup rute untuk laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        // Rute Laporan Harian
        Route::get('/harian', [DailyReportController::class, 'index'])->name('harian');
        Route::get('/harian/ekspor', [DailyReportController::class, 'export'])->name('harian.ekspor');

        // Rute Laporan Bulanan
        Route::get('/bulanan', [MonthlyReportController::class, 'index'])->name('bulanan');
        Route::get('/bulanan/ekspor', [MonthlyReportController::class, 'export'])->name('bulanan.ekspor');
    });
});

// Memuat rute autentikasi dari file auth.php
require __DIR__ . '/auth.php';
