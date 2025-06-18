<x-app-layout>
  <x-slot name="header">
    <div class="bg-stone-800 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-3 shadow">
      <h2 class="font-semibold text-xl text-orange-100 leading-tight">
        {{ __('Scan Absensi Karyawan') }}
      </h2>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
      <div class="bg-stone-900/70 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

          {{-- Menggunakan Flexbox Tailwind untuk layout --}}
          <div class="flex flex-col lg:flex-row gap-8">
            {{-- Kolom Kiri: Jam, Kamera, Pesan --}}
            <div class="w-full lg:w-7/12">
              <div class="text-center bg-stone-800 p-6 rounded-lg shadow-lg">
                <div id="realtime-clock" class="text-center text-5xl font-bold mb-3 text-orange-100 font-mono"></div>
                <p class="text-stone-400 mb-4">
                  Arahkan QR Code Karyawan ke Kamera di bawah ini.
                </p>
                <div id="qr-reader" style="width: 100%; max-width: 500px; margin: 0 auto 20px auto; border: 2px dashed #44403c; padding: 10px; border-radius: 8px;"></div>
                <div id="scan-message" class="alert mt-3 mx-auto" style="display: none; font-size: 1.1em; max-width: 500px;"></div>
                <div id="qr-reader-results" class="mt-1 text-sm text-stone-500"></div>

                {{-- Tombol Konfirmasi dengan gaya baru --}}
                <div id="scan-confirmation" style="display: none;" class="mt-4 bg-stone-700/50 p-4 rounded-lg">
                  <p class="text-orange-100">Karyawan: <strong id="scanned-employee-info" class="font-semibold"></strong></p>
                  <p class="text-orange-200 mt-2">Pilih tindakan:</p>
                  <div class="flex justify-center gap-4 mt-3">
                    <button id="btn-clock-in" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105">Absen Masuk</button>
                    <button id="btn-clock-out" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105">Absen Pulang</button>
                  </div>
                </div>
              </div>
            </div>

            {{-- Kolom Kanan: Tabel Absensi Hari Ini (dengan tema baru) --}}
            <div class="w-full lg:w-5/12">
              <h4 class="mb-4 text-xl font-bold text-stone-700 dark:text-orange-200">Absensi Hari Ini (<span id="today-date-display"></span>)</h4>
              <div class="bg-yellow-700 dark:bg-yellow-800 bg-opacity-80 dark:bg-opacity-70 backdrop-blur-sm shadow-2xl sm:rounded-xl p-1 overflow-hidden">
                <div class="bg-orange-50 dark:bg-stone-800 overflow-hidden shadow-inner sm:rounded-lg">
                  <div class="overflow-x-auto" style="max-height: 550px;">
                    <table id="today-attendance-table" class="min-w-full divide-y divide-yellow-700 dark:divide-stone-700">
                      <thead class="bg-yellow-800 dark:bg-stone-700 sticky top-0">
                        <tr>
                          <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Nama</th>
                          <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Masuk</th>
                          <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Keluar</th>
                          <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Status</th>
                          <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">Total Jam</th>
                        </tr>
                      </thead>
                      <tbody class="bg-orange-50 dark:bg-stone-800 divide-y divide-orange-200 dark:divide-stone-700">
                        {{-- Konten akan diisi oleh JavaScript --}}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const qrReaderDiv = document.getElementById('qr-reader');
      const clockDiv = document.getElementById('realtime-clock');
      const todayDateDisplay = document.getElementById('today-date-display');
      const attendanceTableBody = document.querySelector("#today-attendance-table tbody");
      const scanConfirmationDiv = document.getElementById('scan-confirmation');
      const scannedEmployeeInfoSpan = document.getElementById('scanned-employee-info');
      const btnClockIn = document.getElementById('btn-clock-in');
      const btnClockOut = document.getElementById('btn-clock-out');
      const messageContainer = document.getElementById('scan-message');

      var html5QrcodeScannerInstance = null;
      var currentScannedDecodedText = null;
      var workDurationInterval = null;

      function updateClockAndDurations() {
        const now = new Date();
        if (clockDiv) {
          clockDiv.textContent = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
          });
        }
        if (todayDateDisplay && !todayDateDisplay.textContent) {
          todayDateDisplay.textContent = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
          }).replace(/\//g, '-');
        }
        updateWorkDurations();
      }

      if (workDurationInterval) clearInterval(workDurationInterval);
      workDurationInterval = setInterval(updateClockAndDurations, 1000);
      updateClockAndDurations();

      function formatDurationFromMs(milliseconds) {
        if (isNaN(milliseconds) || milliseconds < 0) return "00:00:00";
        let totalSeconds = Math.floor(milliseconds / 1000);
        let hours = Math.floor(totalSeconds / 3600);
        totalSeconds %= 3600;
        let minutes = Math.floor(totalSeconds / 60);
        let seconds = totalSeconds % 60;
        return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
      }

      function calculateFixedDuration(jamMasukStr, jamKeluarStr) {
        if (!jamMasukStr || !jamKeluarStr) return "-";
        try {
          const todayDateStr = new Date().toISOString().slice(0, 10);
          const clockInDateTime = new Date(`${todayDateStr}T${jamMasukStr}`);
          const clockOutDateTime = new Date(`${todayDateStr}T${jamKeluarStr}`);
          if (isNaN(clockInDateTime.getTime()) || isNaN(clockOutDateTime.getTime())) return "-";
          let durationMs = clockOutDateTime.getTime() - clockInDateTime.getTime();
          if (durationMs < 0) durationMs = 0;
          let diffSecs = Math.floor(durationMs / 1000);
          let hours = Math.floor(diffSecs / 3600);
          diffSecs -= hours * 3600;
          let minutes = Math.floor(diffSecs / 60);
          return `${hours}j ${minutes}m`;
        } catch (e) {
          return "Err";
        }
      }

      function updateWorkDurations() {
        const now = new Date();
        document.querySelectorAll('.realtime-duration').forEach(span => {
          const clockInString = span.dataset.clockin;
          if (clockInString) {
            try {
              const [clockInHours, clockInMinutes, clockInSeconds] = clockInString.split(':').map(Number);
              let clockInTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), clockInHours, clockInMinutes, clockInSeconds || 0, 0);
              if (!isNaN(clockInTime.getTime())) {
                let durationMs = now.getTime() - clockInTime.getTime();
                if (durationMs < 0) durationMs = 0;
                span.textContent = formatDurationFromMs(durationMs);
              } else {
                span.textContent = "Waktu Invalid";
              }
            } catch (e) {
              span.textContent = "Err Time";
            }
          }
        });
      }

      function renderTodaysAttendanceTable(attendances) {
        attendanceTableBody.innerHTML = '';
        if (attendances.length === 0) {
          attendanceTableBody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-sm text-stone-500 dark:text-orange-300 italic">Belum ada absensi hari ini.</td></tr>';
          return;
        }
        attendances.forEach(att => {
          const row = attendanceTableBody.insertRow();
          row.className = 'hover:bg-orange-100 dark:hover:bg-stone-700/50 transition-colors duration-150';

          const cellNama = row.insertCell();
          cellNama.textContent = att.employee ? att.employee.nama_lengkap : 'N/A';
          cellNama.className = 'px-4 py-2.5 whitespace-nowrap text-sm text-stone-700 dark:text-orange-200';

          const cellMasuk = row.insertCell();
          cellMasuk.textContent = att.jam_masuk ? new Date(`1970-01-01T${att.jam_masuk}`).toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
          }) : '-';
          cellMasuk.className = 'px-4 py-2.5 whitespace-nowrap text-sm text-stone-600 dark:text-orange-300 text-center font-mono';

          const cellKeluar = row.insertCell();
          cellKeluar.textContent = att.jam_keluar ? new Date(`1970-01-01T${att.jam_keluar}`).toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
          }) : '-';
          cellKeluar.className = 'px-4 py-2.5 whitespace-nowrap text-sm text-stone-600 dark:text-orange-300 text-center font-mono';

          const cellStatus = row.insertCell();
          let statusBadge = '';
          const statusText = att.status_kehadiran || att.status;
          if (statusText === 'Hadir') statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Hadir</span>';
          else if (statusText === 'Pulang') statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100">Pulang</span>';
          else if (statusText === 'Izin') statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-5 text-sky-800 bg-sky-100 rounded-full dark:bg-sky-700 dark:text-sky-100">Izin</span>';
          else if (statusText === 'Sakit') statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">Sakit</span>';
          else if (statusText === 'Alpha') statusBadge = '<span class="px-2 py-1 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Alpha</span>';
          else statusBadge = `<span class="px-2 py-1 text-xs font-semibold leading-5 text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">${statusText || 'N/A'}</span>`;
          cellStatus.innerHTML = statusBadge;
          cellStatus.className = 'px-4 py-2.5 whitespace-nowrap text-sm text-center';

          const durationCell = row.insertCell();
          if (att.jam_masuk && att.jam_keluar) {
            durationCell.textContent = calculateFixedDuration(att.jam_masuk, att.jam_keluar);
          } else if (att.jam_masuk && !att.jam_keluar && (statusText === 'Hadir' || statusText === 'Masuk')) {
            durationCell.innerHTML = `<span class="realtime-duration" data-clockin="${att.jam_masuk}">Menghitung...</span>`;
          } else {
            durationCell.textContent = '-';
          }
          durationCell.className = 'px-4 py-2.5 whitespace-nowrap text-sm text-stone-600 dark:text-orange-300 text-center font-mono';
        });
        updateWorkDurations();
      }

      function fetchTodaysAttendance() {
        if (!attendanceTableBody) return;
        attendanceTableBody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-sm text-stone-500 dark:text-orange-300 italic">Memuat data...</td></tr>';
        axios.get('{{ route("attendances.today") }}')
          .then(response => renderTodaysAttendanceTable(response.data))
          .catch(error => {
            console.error("Error fetching today's attendance:", error);
            attendanceTableBody.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-sm text-red-500 dark:text-red-400 italic">Gagal memuat data.</td></tr>';
          });
      }

      function showMessage(text, isSuccess) {
        if (!messageContainer) return;
        messageContainer.textContent = text;
        messageContainer.className = 'p-3 rounded-md text-white font-semibold ' + (isSuccess ? 'bg-green-500' : 'bg-red-500');
        messageContainer.style.display = 'block';
        setTimeout(() => {
          messageContainer.style.display = 'none';
        }, 3500);
      }

      function processAttendanceAction(qrCode, action) {
        if (scanConfirmationDiv) scanConfirmationDiv.style.display = 'none';
        showMessage("Sedang memproses...", true);
        axios.post('{{ route("attendance.process") }}', {
            qr_code: qrCode,
            action: action,
            _token: '{{ csrf_token() }}'
          })
          .then(response => {
            showMessage(response.data.message, true);
            fetchTodaysAttendance();
          })
          .catch(error => {
            let errMsg = (error.response && error.response.data && error.response.data.message) ? error.response.data.message : 'Terjadi error.';
            showMessage(errMsg, false);
          }).finally(() => {
            if (html5QrcodeScannerInstance) {
              try {
                if (html5QrcodeScannerInstance.getState && html5QrcodeScannerInstance.getState() !== Html5QrcodeScannerState.SCANNING) {
                  html5QrcodeScannerInstance.resume();
                }
              } catch (e) {
                console.warn("Error resuming scanner:", e);
              }
            }
          });
      }

      if (btnClockIn) btnClockIn.addEventListener('click', () => {
        if (currentScannedDecodedText) processAttendanceAction(currentScannedDecodedText, 'in');
      });
      if (btnClockOut) btnClockOut.addEventListener('click', () => {
        if (currentScannedDecodedText) processAttendanceAction(currentScannedDecodedText, 'out');
      });

      function onScanSuccess(decodedText, decodedResult) {
        currentScannedDecodedText = decodedText;
        if (html5QrcodeScannerInstance) {
          try {
            html5QrcodeScannerInstance.pause(true);
          } catch (e) {
            console.warn("Error pausing scanner:", e);
          }
        }
        if (scannedEmployeeInfoSpan) scannedEmployeeInfoSpan.textContent = decodedText;
        if (scanConfirmationDiv) scanConfirmationDiv.style.display = 'block';
        if (messageContainer) messageContainer.style.display = 'none';
      }

      if (qrReaderDiv) {
        try {
          html5QrcodeScannerInstance = new Html5QrcodeScanner(
            "qr-reader", {
              fps: 10,
              qrbox: {
                width: 250,
                height: 250
              },
              rememberLastUsedCamera: true,
              supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
            }, false
          );
          html5QrcodeScannerInstance.render(onScanSuccess, (errorMessage) => {});
        } catch (error) {
          console.error("Error initializing Html5QrcodeScanner:", error);
          qrReaderDiv.innerHTML = `<div class="p-4 text-center text-red-400 bg-red-900/50 rounded-lg">Error: ${error.message}.</div>`;
        }
      }

      fetchTodaysAttendance();
    });
  </script>
</x-app-layout>