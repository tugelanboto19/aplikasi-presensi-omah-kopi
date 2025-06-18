<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Position; // <-- Tambahkan ini

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan Anda sudah punya data di tabel 'positions'
        // Jika belum, seeder akan mengisinya nanti
        $position = Position::inRandomOrder()->first();

        return [
            'name' => fake()->name(),
            'position_id' => $position ? $position->id : null, // Mengambil ID posisi secara acak
            'qr_code' => Str::uuid(), // Membuat QR code unik
        ];
    }
}
