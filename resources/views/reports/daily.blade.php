{{-- resources/views/reports/daily-report.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <div class="bg-stone-800 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-3 shadow">
      <h2 class="font-semibold text-xl text-orange-100 leading-tight">
        Laporan Absensi Harian
      </h2>
    </div>
  </x-slot>

  <div class="py-12 bg-orange-50 dark:bg-stone-900">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-yellow-700 dark:bg-yellow-800 bg-opacity-80 dark:bg-opacity-70 backdrop-blur-sm shadow-2xl sm:rounded-xl p-1 overflow-hidden">
        <div class="bg-orange-50 dark:bg-stone-800 overflow-hidden shadow-inner sm:rounded-lg">
          <div class="p-6 md:p-8">

            {{-- Form Filter --}}
            <div class="mb-6">
              <h3 class="text-xl font-bold text-stone-700 dark:text-orange-200 mb-2">Filter Laporan</h3>
              <form action="{{ route('laporan.harian') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                  {{-- Filter Tanggal --}}
                  <div>
                    <label for="tanggal" class="block text-sm font-medium text-stone-700 dark:text-orange-200 mb-1">Pilih Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ $filters['tanggal'] ?? '' }}" class="form-input">
                  </div>

                  {{-- Filter Karyawan --}}
                  <div>
                    <label for="employee_id" class="block text-sm font-medium text-stone-700 dark:text-orange-200 mb-1">Pilih Karyawan</label>
                    <select id="employee_id" name="employee_id" class="form-input">
                      <option value="">-- Semua Karyawan --</option>
                      @foreach($employees as $employee)
                      <option value="{{ $employee->id }}" {{ ($filters['employee_id'] ?? '') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->nama_lengkap }}
                      </option>
                      @endforeach
                    </select>
                  </div>

                  {{-- Tombol Tampilkan --}}
                  <div class="md:col-start-3 lg:col-start-auto">
                    <button type="submit" class="w-full justify-center px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-semibold text-sm rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-75">
                      Tampilkan
                    </button>
                  </div>
                </div>
              </form>
            </div>

            <hr class="border-orange-200 dark:border-stone-700 my-6">

            {{-- Header Hasil Laporan --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
              <h3 class="text-xl font-bold text-stone-700 dark:text-orange-200">
                Hasil Laporan:
                <span class="font-medium">{{ \Carbon\Carbon::parse($filters['tanggal'])->isoFormat('dddd, D MMMM Y') }}</span>
              </h3>
            </div>


            {{-- Tabel Hasil Laporan --}}
            <div class="overflow-x-auto shadow-md rounded-lg">
              <table class="min-w-full divide-y divide-yellow-700 dark:divide-stone-700">
                <thead class="bg-yellow-800 dark:bg-stone-700">
                  <tr>
                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">No</th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Masuk</th>
                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Keluar</th>
                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Total Jam</th>
                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Keterangan</th>
                  </tr>
                </thead>
                <tbody class="bg-orange-50 dark:bg-stone-800 divide-y divide-orange-200 dark:divide-stone-700">
                  @forelse ($attendances as $key => $attendance)
                  <tr class="hover:bg-orange-100 dark:hover:bg-stone-700/50 transition-colors duration-150">
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm font-medium text-stone-900 dark:text-orange-100 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm text-stone-700 dark:text-orange-200">{{ $attendance->employee->nama_lengkap ?? 'Karyawan dihapus' }}</td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm text-stone-600 dark:text-orange-300 text-center font-mono">{{ $attendance->jam_masuk ? \Carbon\Carbon::parse($attendance->jam_masuk)->format('H:i') : '-' }}</td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm text-stone-600 dark:text-orange-300 text-center font-mono">{{ $attendance->jam_keluar ? \Carbon\Carbon::parse($attendance->jam_keluar)->format('H:i') : '-' }}</td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm text-stone-600 dark:text-orange-300 text-center font-mono">{{ $attendance->work_duration ?? '-' }}</td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm text-center">
                      @php
                      $statusText = $attendance->status;
                      $badgeClass = 'px-2 py-1 text-xs font-semibold leading-5 rounded-full ';
                      if ($statusText === 'Hadir' || $statusText === 'Masuk') $badgeClass .= 'text-green-800 bg-green-100 dark:bg-green-700 dark:text-green-100';
                      elseif ($statusText === 'Pulang') $badgeClass .= 'text-blue-800 bg-blue-100 dark:bg-blue-700 dark:text-blue-100';
                      elseif ($statusText === 'Izin') $badgeClass .= 'text-sky-800 bg-sky-100 dark:bg-sky-700 dark:text-sky-100';
                      elseif ($statusText === 'Sakit') $badgeClass .= 'text-yellow-800 bg-yellow-100 dark:bg-yellow-700 dark:text-yellow-100';
                      elseif ($statusText === 'Alpha') $badgeClass .= 'text-red-800 bg-red-100 dark:bg-red-700 dark:text-red-100';
                      else $badgeClass .= 'text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-100';
                      @endphp
                      <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                    </td>
                    <td class="px-4 py-2.5 text-sm text-stone-600 dark:text-orange-300">{{ $attendance->keterangan ?: '-' }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-sm text-stone-500 dark:text-orange-300 italic">
                      Tidak ada data absensi untuk filter yang dipilih.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
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