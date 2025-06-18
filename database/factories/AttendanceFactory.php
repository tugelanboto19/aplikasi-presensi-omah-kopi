<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shift; // <-- Tambahkan ini
use Carbon\Carbon;    // <-- Tambahkan ini

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil satu shift secara acak
        $shift = Shift::inRandomOrder()->first();

        // Membuat jam masuk & keluar yang realistis berdasarkan shift
        $jamMulaiShift = Carbon::parse($shift->start_time);
        $jamSelesaiShift = Carbon::parse($shift->end_time);

        // Jam masuk: antara 0-15 menit setelah shift dimulai
        $jamMasuk = $jamMulaiShift->copy()->addMinutes(rand(0, 15));

        // Jam keluar: antara 0-30 menit setelah shift berakhir
        $jamKeluar = $jamSelesaiShift->copy()->addMinutes(rand(0, 30));

        // Menentukan status berdasarkan keterlambatan
        $status = $jamMasuk->gt($jamMulaiShift) ? 'Terlambat' : 'Tepat Waktu';

        return [
            // employee_id dan date akan kita isi dari seeder
            'shift_id' => $shift->id,
            'jam_masuk' => $jamMasuk->format('H:i:s'),
            'jam_keluar' => $jamKeluar->format('H:i:s'),
            'status' => $status,
        ];
    }
}
