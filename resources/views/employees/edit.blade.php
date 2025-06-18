<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Edit Data Karyawan: ') }} {{ $employee->nama_lengkap }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- Card ini akan ikut tema gelap global dari <html data-bs-theme="dark"> --}}
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Formulir Edit Data Karyawan</h5>
        </div>
        <div class="card-body"> {{-- Latar belakang card body akan gelap, teks defaultnya terang --}}
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

          <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Penting untuk update --}}

            <div class="mb-3">
              {{-- Label dengan warna terang --}}
              <label for="nama_lengkap" class="form-label fw-semibold text-light">Nama Lengkap:</label>
              {{-- Input dengan styling Tailwind untuk dark mode --}}
              <input type="text"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('nama_lengkap') border-red-500 @enderror"
                id="nama_lengkap" name="nama_lengkap" required value="{{ old('nama_lengkap', $employee->nama_lengkap) }}" placeholder="Masukkan nama lengkap karyawan">
              @error('nama_lengkap') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="posisi" class="form-label fw-semibold text-light">Posisi/Jabatan:</label>
              <input type="text"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('posisi') border-red-500 @enderror"
                id="posisi" name="posisi" required value="{{ old('posisi', $employee->posisi) }}" placeholder="Misal: Barista, Kasir">
              @error('posisi') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-semibold text-light">Email (Opsional):</label>
              <input type="email"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('email') border-red-500 @enderror"
                id="email" name="email" value="{{ old('email', $employee->email) }}" placeholder="contoh@email.com">
              @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label for="nomor_telepon" class="form-label fw-semibold text-light">Nomor Telepon (Opsional):</label>
              <input type="text"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('nomor_telepon') border-red-500 @enderror"
                id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $employee->nomor_telepon) }}" placeholder="08xxxxxxxxxx">
              @error('nomor_telepon') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <hr class="my-4 border-secondary">

            <div class="d-flex justify-content-end">
              <a href="{{ route('employees.index') }}" class="btn btn-outline-light me-2">Batal</a>
              <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>