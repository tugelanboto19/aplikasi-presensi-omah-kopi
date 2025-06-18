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
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // ID Otomatis
            $table->string('nama_lengkap');
            $table->string('posisi');
            $table->string('employee_id_unik')->unique(); // Ini untuk QR Code!
            $table->string('email')->unique()->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->timestamps(); // Waktu dibuat & diupdate
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
