<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Tambah Karyawan Baru') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="card shadow-sm" data-bs-theme="light"> {{-- Kita buat card ini terang agar formnya kontras dg background gelap halaman --}}
        <div class="card-header bg-primary text-white"> {{-- Header card bisa tetap gelap/berwarna --}}
          <h5 class="mb-0">Formulir Data Karyawan</h5>
        </div>
        <div class="card-body">
          @if ($errors->any())
          <div class="alert alert-danger mb-4">
            <strong>Oops! Ada beberapa input yang salah:</strong>
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="nama_lengkap" class="form-label fw-semibold text-dark">Nama Lengkap:</label>
              {{-- Ganti class form-control dengan Tailwind classes --}}
              <input type="text"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('nama_lengkap') border-red-500 @enderror"
                id="nama_lengkap" name="nama_lengkap" required value="{{ old('nama_lengkap') }}" placeholder="Masukkan nama lengkap karyawan">
              @error('nama_lengkap') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="posisi" class="form-label fw-semibold text-dark">Posisi/Jabatan:</label>
              <input type="text"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('posisi') border-red-500 @enderror"
                id="posisi" name="posisi" required value="{{ old('posisi') }}" placeholder="Misal: Barista, Kasir">
              @error('posisi') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-semibold text-dark">Email (Opsional):</label>
              <input type="email"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('email') border-red-500 @enderror"
                id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com">
              @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="nomor_telepon" class="form-label fw-semibold text-dark">Nomor Telepon (Opsional):</label>
              <input type="text"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('nomor_telepon') border-red-500 @enderror"
                id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}" placeholder="08xxxxxxxxxx">
              @error('nomor_telepon') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end">
              <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
              <button type="submit" class="btn btn-primary">Simpan Karyawan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>