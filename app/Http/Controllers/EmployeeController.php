<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data karyawan dari database, urutkan berdasarkan nama
        $employees = \App\Models\Employee::orderBy('nama_lengkap', 'asc')->get();
        // Tampilkan view 'employees.index' dan kirim data '$employees' ke sana
        return view('employees.index', compact('employees'));
    }

    public function showQrCode(\App\Models\Employee $employee)
    {
        // Cukup tampilkan view 'employees.qrcode' dan kirim data $employee
        return view('employees.qrcode', compact('employee'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cukup tampilkan view form tambah
        return view('employees.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi: Pastikan nama dan posisi diisi
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'posisi' => 'required|string|max:100',
            'email' => 'nullable|email|unique:employees,email', // Email boleh kosong, tapi jika diisi harus unik
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        // 2. Buat ID Unik untuk QR Code
        $validatedData['employee_id_unik'] = 'OKM-' . now()->timestamp . '-' . Str::random(6);

        // 3. Simpan ke Database pakai Model
        \App\Models\Employee::create($validatedData);

        // 4. Kembali ke halaman daftar + kasih pesan sukses
        return redirect()->route('employees.index')->with('success', 'Karyawan baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Employee $employee) // Pakai Route Model Binding
    {
        // Tampilkan view 'edit' dan kirim data karyawan yang mau diedit
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, \App\Models\Employee $employee)
    {
        // 1. Validasi Input (mirip store, tapi perhatikan 'unique')
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'posisi' => 'required|string|max:100',
            // Apakah baris 'unique' ini sudah BENAR?
            // Pastikan ada tanda kutip, titik untuk menggabung, dan $employee->id
            'email' => 'nullable|email|unique:employees,email,' . $employee->id,
            'nomor_telepon' => 'nullable|string|max:20',
        ]);

        // 2. Update data di database
        $employee->update($validatedData);

        // 3. Kembali ke halaman daftar + kasih pesan sukses
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Employee $employee)
    {
        try {
            // Hapus data karyawan
            $employee->delete();
            // Kembali ke halaman daftar + kasih pesan sukses
            return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi error (misal karena relasi database yg kompleks)
            return redirect()->route('employees.index')->with('error', 'Gagal menghapus data karyawan. Error: ' . $e->getMessage());
        }
    }
}
