<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Laporan Absensi Harian') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0">Filter Laporan Absensi</h5>
        </div>
        <div class="card-body">
          {{-- Form untuk filter dan ekspor --}}
          <form id="reportForm" action="{{ route('attendance.report') }}" method="GET">
            <div class="row g-3 align-items-end mb-4">
              {{-- Filter Tanggal --}}
              <div class="col-md-4">
                <label for="tanggal_laporan" class="form-label fw-semibold text-light">Pilih Tanggal:</label>
                <input type="date"
                  class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                  id="tanggal_laporan" name="tanggal_laporan" value="{{ $selectedDate ?? '' }}">
              </div>

              {{-- Filter Karyawan --}}
              <div class="col-md-4">
                <label for="employee_id" class="form-label fw-semibold text-light">Pilih Karyawan:</label>
                <select id="employee_id" name="employee_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                  <option value="">-- Semua Karyawan --</option>
                  {{-- Diasumsikan $employees adalah koleksi semua karyawan yang di-pass dari controller --}}
                  @foreach($employees as $employee)
                  <option value="{{ $employee->id }}" {{ (request('employee_id') ?? ($selectedCriteria['employee_id'] ?? '')) == $employee->id ? 'selected' : '' }}>
                    {{ $employee->nama_lengkap }}
                  </option>
                  @endforeach
                </select>
              </div>

              {{-- Tombol Aksi --}}
              <div class="col-md-4 d-flex align-items-end">
                <button type="submit" name="action" value="filter" class="btn btn-primary w-50 me-2">Tampilkan Laporan</button>
                <button type="submit" name="action" value="export" id="exportButton" class="btn btn-success w-50">Ekspor ke Excel</button>
              </div>
            </div>
          </form>

          <p class="mb-3 text-light">Menampilkan laporan untuk tanggal: <strong>{{ isset($selectedDate) ? \Carbon\Carbon::parse($selectedDate)->isoFormat('dddd, D MMMM YYYY') : 'Belum Dipilih' }}</strong></p>

          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
              <thead class="table-light">
                <tr>
                  <th scope="col" class="text-center text-dark" style="width: 5%;">No</th>
                  <th scope="col" class="text-dark">Nama Karyawan</th>
                  <th scope="col" class="text-center text-dark" style="width: 15%;">Tanggal</th>
                  <th scope="col" class="text-center text-dark" style="width: 10%;">Jam Masuk</th>
                  <th scope="col" class="text-center text-dark" style="width: 10%;">Jam Keluar</th>
                  <th scope="col" class="text-center text-dark" style="width: 10%;">Status</th>
                  <th scope="col" class="text-dark">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($attendances ?? [] as $key => $attendance)
                <tr class="text-light">
                  <td class="text-center">{{ $key + 1 }}</td>
                  <td>{{ $attendance->employee ? $attendance->employee->nama_lengkap : 'Karyawan Dihapus' }}</td>
                  <td class="text-center">{{ \Carbon\Carbon::parse($attendance->tanggal)->isoFormat('dddd, DD-MM-YYYY') }}</td>
                  <td class="text-center">{{ $attendance->jam_masuk ? \Carbon\Carbon::parse($attendance->jam_masuk)->format('H:i') : '-' }}</td>
                  <td class="text-center">{{ $attendance->jam_keluar ? \Carbon\Carbon::parse($attendance->jam_keluar)->format('H:i') : '-' }}</td>
                  <td class="text-center">
                    @if($attendance->status == 'Hadir')
                    <span class="badge bg-success">Hadir</span>
                    @elseif($attendance->status == 'Pulang')
                    <span class="badge bg-primary">Pulang</span>
                    @elseif($attendance->status == 'Izin')
                    <span class="badge bg-info text-dark">Izin</span>
                    @elseif($attendance->status == 'Sakit')
                    <span class="badge bg-warning text-dark">Sakit</span>
                    @elseif($attendance->status == 'Alpha')
                    <span class="badge bg-danger">Alpha</span>
                    @else
                    <span class="badge bg-secondary">{{ $attendance->status }}</span>
                    @endif
                  </td>
                  <td>{{ $attendance->keterangan ?? '' }}</td>
                </tr>
                @empty
                <tr class="text-light">
                  <td colspan="7" class="text-center fst-italic">Tidak ada data absensi untuk ditampilkan. Silakan pilih kriteria dan klik "Tampilkan Laporan".</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal Peringatan Bootstrap --}}
  <div class="modal fade" id="exportWarningModal" tabindex="-1" aria-labelledby="exportWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-dark text-light">
        <div class="modal-header border-secondary">
          <h5 class="modal-title" id="exportWarningModalLabel">Peringatan</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Harap pilih salah satu karyawan terlebih dahulu sebelum mengekspor data ke Excel.</p>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    // Pastikan file JavaScript Bootstrap sudah dimuat agar modal berfungsi.
    document.addEventListener('DOMContentLoaded', function() {
      const reportForm = document.getElementById('reportForm');
      const employeeSelect = document.getElementById('employee_id');

      // Cek apakah Bootstrap JS framework tersedia.
      if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap JS tidak ditemukan. Modal peringatan tidak akan berfungsi. Menggunakan alert bawaan sebagai fallback.');
        // Memberikan fallback (alternatif) jika Bootstrap tidak ada.
        reportForm.addEventListener('submit', function(event) {
          const submitter = event.submitter;
          if (submitter && submitter.value === 'export' && employeeSelect.value === '') {
            event.preventDefault();
            alert('Harap pilih salah satu karyawan terlebih dahulu sebelum mengekspor data ke Excel.');
          }
        });
        return; // Menghentikan eksekusi script jika Bootstrap tidak ditemukan.
      }

      // Inisialisasi modal jika Bootstrap tersedia.
      const warningModal = new bootstrap.Modal(document.getElementById('exportWarningModal'));

      // Menambahkan event listener ke form saat disubmit.
      reportForm.addEventListener('submit', function(event) {
        // 'event.submitter' adalah properti standar yang merujuk pada tombol <button> atau <input type="submit">
        // yang digunakan untuk mengirimkan formulir.
        const submitter = event.submitter;

        // Cek apakah submit dipicu oleh tombol dengan value 'export' DAN dropdown karyawan belum dipilih.
        if (submitter && submitter.value === 'export' && employeeSelect.value === '') {
          // Mencegah form dari proses submit standar.
          event.preventDefault();
          // Menampilkan modal peringatan.
          warningModal.show();
        }
        // Jika kondisi di atas tidak terpenuhi (misal, tombol filter ditekan atau karyawan sudah dipilih untuk ekspor), 
        // form akan dikirimkan secara normal.
      });
    });
  </script>
  @endpush
</x-app-layout>