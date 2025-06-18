<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Shift;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -- BAGIAN 1: Mengisi data master (Posisi dan Shift) --
        $this->command->info('Mengisi data master Posisi dan Shift...');

        // Hapus data lama agar tidak duplikat
        Position::query()->delete();
        Shift::query()->delete();

        // Data Posisi
        Position::insert([
            ['department' => 'FOH', 'name' => 'Waiters / Kebersihan'],
            ['department' => 'FOH', 'name' => 'Admin / Kasir'],
            ['department' => 'FOH', 'name' => 'Kasir / Waitress'],
            ['department' => 'FOH', 'name' => 'Minuman Kopi'],
            ['department' => 'Dapur', 'name' => 'Ndeso'],
            ['department' => 'Dapur', 'name' => 'Seafood'],
            ['department' => 'Dapur', 'name' => 'Cuci Alat Dapur'],
            ['department' => 'Umum', 'name' => 'Kebersihan Umum'],
        ]);

        // Data Shift
        Shift::insert([
            ['name' => 'Shift 1 (Pagi)', 'start_time' => '10:00:00', 'end_time' => '18:00:00'],
            ['name' => 'Shift 2 (Sore)', 'start_time' => '14:00:00', 'end_time' => '22:00:00'],
        ]);

        // -- BAGIAN 2: Membuat 20 Karyawan Palsu --
        $this->command->info('Membuat 20 data karyawan...');

        // Hapus data karyawan dan absensi lama
        Employee::query()->delete();
        $employees = Employee::factory()->count(20)->create();

        // -- BAGIAN 3: Mengisi Absensi untuk Bulan Mei --
        $this->command->info('Mengisi data absensi untuk Bulan Mei 2025...');

        $startDate = Carbon::create(2025, 5, 1);
        $endDate = Carbon::create(2025, 5, 31);

        // Loop untuk setiap karyawan
        foreach ($employees as $employee) {
            // Loop untuk setiap hari di bulan Mei
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

                // Beri kemungkinan 20% karyawan libur pada hari itu
                if (rand(1, 100) <= 20) {
                    continue; // Lanjut ke hari berikutnya
                }

                // Buat data absensi menggunakan factory
                Attendance::factory()->create([
                    'employee_id' => $employee->id,
                    'date' => $date->format('Y-m-d'),
                ]);
            }
        }

        $this->command->info('Database seeding selesai!');
    }
}
