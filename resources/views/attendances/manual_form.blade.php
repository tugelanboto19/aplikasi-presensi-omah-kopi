{{-- resources/views/attendances/manual-input.blade.php --}}
{{-- Perubahan:
- Mengganti semua kelas Bootstrap (card, form-label, btn) dengan kelas Tailwind CSS.
- Menerapkan tema visual yang konsisten (bg-stone-800, text-orange-200, dll) seperti halaman lain.
- Menyederhanakan struktur HTML agar lebih rapi.
--}}
<x-app-layout>
  <x-slot name="header">
    <div class="bg-stone-800 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-3 shadow">
      <h2 class="font-semibold text-xl text-orange-100 leading-tight">
        {{ __('Input Absensi Manual (Izin/Sakit/Alpha)') }}
      </h2>
    </div>
  </x-slot>

  <div class="py-12 bg-orange-50 dark:bg-stone-900">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-yellow-700 dark:bg-yellow-800 bg-opacity-80 dark:bg-opacity-70 backdrop-blur-sm shadow-2xl sm:rounded-xl p-1 overflow-hidden">
        <div class="bg-orange-50 dark:bg-stone-800 overflow-hidden shadow-inner sm:rounded-lg">
          <div class="p-6 md:p-8">

            <h3 class="text-2xl font-bold text-stone-700 dark:text-orange-200 mb-2">Formulir Absensi Manual</h3>
            <p class="text-sm text-stone-500 dark:text-orange-300 mb-6">
              Gunakan formulir ini untuk mencatat ketidakhadiran karyawan karena izin, sakit, atau alpha.
            </p>

            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-100 rounded-md shadow-sm text-sm">
              <strong>Oops! Ada beberapa input yang salah:</strong>
              <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-100 rounded-md shadow-sm text-sm">
              {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('attendances.manual.store') }}" method="POST" class="space-y-6">
              @csrf

              {{-- Pilihan Karyawan --}}
              <div>
                <label for="employee_id" class="block text-sm font-medium text-stone-700 dark:text-orange-200 mb-1">Pilih Karyawan</label>
                <select name="employee_id" id="employee_id" class="form-input @error('employee_id') border-red-500 @enderror" required>
                  <option value="">-- Pilih Karyawan --</option>
                  @foreach ($employees as $employee)
                  <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                    {{ $employee->nama_lengkap }} ({{ $employee->posisi }})
                  </option>
                  @endforeach
                </select>
                @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Pilihan Tanggal --}}
              <div>
                <label for="tanggal" class="block text-sm font-medium text-stone-700 dark:text-orange-200 mb-1">Tanggal Absensi</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="form-input @error('tanggal') border-red-500 @enderror">
                @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Pilihan Status --}}
              <div>
                <label for="status" class="block text-sm font-medium text-stone-700 dark:text-orange-200 mb-1">Status Kehadiran</label>
                <select name="status" id="status" class="form-input @error('status') border-red-500 @enderror" required>
                  <option value="">-- Pilih Status --</option>
                  <option value="Izin" {{ old('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                  <option value="Sakit" {{ old('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                  <option value="Alpha" {{ old('status') == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Input Keterangan --}}
              <div>
                <label for="keterangan" class="block text-sm font-medium text-stone-700 dark:text-orange-200 mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="3" placeholder="Isi keterangan jika ada..." class="form-input @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
              </div>

              {{-- Garis Pemisah --}}
              <hr class="border-orange-200 dark:border-stone-700">

              {{-- Tombol Aksi --}}
              <div class="flex justify-end space-x-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-stone-200 hover:bg-stone-300 dark:bg-stone-600 dark:hover:bg-stone-500 text-stone-700 dark:text-orange-100 font-semibold text-sm rounded-lg shadow-md transition-colors duration-300">
                  Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-semibold text-sm rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-75">
                  Simpan Absensi
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <style>
    .form-input {
      @apply mt-1 block w-full border-orange-200 dark:border-stone-600 bg-orange-50 dark:bg-stone-700 text-stone-700 dark:text-orange-200 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-orange-500 dark:focus:ring-orange-400 rounded-md shadow-sm transition-colors duration-300;
    }
  </style>
</x-app-layout>