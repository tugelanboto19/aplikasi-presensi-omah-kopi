<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id'); // Penghubung ke tabel karyawan
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable(); // Bisa kosong saat baru dibuat
            $table->time('jam_keluar')->nullable(); // Bisa kosong saat baru masuk
            $table->enum('status', ['Hadir', 'Pulang', 'Izin', 'Sakit', 'Alpha'])->default('Alpha');
            $table->text('keterangan')->nullable(); // Untuk catatan tambahan (misal: alasan izin/sakit)
            $table->timestamps();

            // Ini membuat hubungan antar tabel
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
