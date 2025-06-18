<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- TAMBAHKAN INI
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory; // <-- TAMBAHKAN INI

    protected $fillable = [
        'nama_lengkap',
        'posisi',
        'employee_id_unik',
        'email',
        'nomor_telepon',
    ];

    // Relasi: Satu Karyawan bisa memiliki banyak catatan Absensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
