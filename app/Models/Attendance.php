<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- TAMBAHKAN INI
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory; // <-- TAMBAHKAN INI

    protected $fillable = [
        'employee_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan', // <-- TAMBAHKAN INI
    ];

    // Menambahkan relasi agar mudah ambil data karyawan dari absensi
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
