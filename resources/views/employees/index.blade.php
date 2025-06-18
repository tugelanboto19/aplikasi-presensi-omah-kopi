<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-stone-800 dark:text-orange-100 leading-tight">
      {{ __('Daftar Karyawan') }}
    </h2>
  </x-slot>

  <div class="py-12 bg-orange-50 dark:bg-stone-900 min-h-screen page-fade-in">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-yellow-700 dark:bg-yellow-800 bg-opacity-80 dark:bg-opacity-70 backdrop-blur-sm shadow-2xl sm:rounded-xl p-1 overflow-hidden">
        <div class="bg-orange-50 dark:bg-stone-800 overflow-hidden shadow-inner sm:rounded-lg">
          <div class="p-6 md:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 header-animation">
              <div>
                <h1 class="text-2xl font-bold text-stone-700 dark:text-orange-200">
                  Daftar Karyawan Omah Kopi Mrisen
                </h1>
                <p class="text-sm text-stone-500 dark:text-orange-300 mt-1">
                  Kelola data seluruh karyawan terdaftar.
                </p>
              </div>
              <a href="{{ route('employees.create') }}"
                class="mt-4 sm:mt-0 inline-flex items-center px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-semibold text-sm rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-75">
                <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Karyawan Baru
              </a>
            </div>

            @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-100 rounded-md shadow-sm alert-animation text-sm">
              {{ session('success') }}
            </div>
            @endif

            <div class="overflow-x-auto table-animation shadow-md rounded-lg">
              <table class="min-w-full divide-y divide-yellow-700 dark:divide-yellow-600">
                <thead class="bg-yellow-800 dark:bg-stone-700">
                  <tr>
                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">
                      No
                    </th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">
                      Nama Lengkap
                    </th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">
                      Posisi
                    </th>
                    <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">
                      ID Unik (QR)
                    </th>
                    <th scope="col" class="px-4 py-2 text-center text-xs font-medium text-orange-100 dark:text-orange-200 uppercase tracking-wider">
                      Aksi
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-orange-50 dark:bg-stone-800 divide-y divide-orange-200 dark:divide-stone-700">
                  @forelse ($employees as $key => $employee)
                  <tr class="hover:bg-orange-100 dark:hover:bg-stone-700 transition-colors duration-150 employee-row">
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm font-medium text-stone-900 dark:text-orange-100 text-center">
                      @if ($employees instanceof \Illuminate\Pagination\AbstractPaginator)
                      {{ $employees->firstItem() + $key }}
                      @else
                      {{ $loop->iteration }}
                      @endif
                    </td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm text-stone-700 dark:text-orange-200">
                      {{ $employee->nama_lengkap }}
                    </td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm text-stone-600 dark:text-orange-300">
                      {{ $employee->posisi }}
                    </td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm text-stone-500 dark:text-orange-300 font-mono">
                      {{ $employee->employee_id_unik }}
                    </td>
                    <td class="px-4 py-2.5 whitespace-nowrap text-sm font-medium">
                      <div class="flex items-center justify-center space-x-2">
                        <button type="button" onclick="showQrCodePageInModal('{{ route('employees.qrcode', $employee->id) }}', '{{ addslashes($employee->nama_lengkap) }}')" class="action-btn bg-sky-500 hover:bg-sky-600 dark:bg-sky-600 dark:hover:bg-sky-700" title="Lihat Kartu QR">
                          <svg class="action-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 15.375c-.621 0-1.125.504-1.125 1.125v2.25c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V16.5c0-.621-.504-1.125-1.125-1.125h-2.25z" />
                          </svg>
                        </button>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="action-btn bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700" title="Edit">
                          <svg class="action-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L16.862 4.487" />
                          </svg>
                        </a>
                        <button type="button" onclick="showDeleteConfirmModal('{{ route('employees.destroy', $employee->id) }}', '{{ addslashes($employee->nama_lengkap) }}')" class="action-btn bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700" title="Hapus">
                          <svg class="action-btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.56 0c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                          </svg>
                        </button>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-sm text-stone-500 dark:text-orange-300 italic">
                      Belum ada data karyawan. Silakan
                      <a href="{{ route('employees.create') }}" class="text-orange-600 hover:text-orange-700 dark:text-orange-400 dark:hover:text-orange-300 font-semibold underline">tambah baru</a>.
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            @if (isset($employees) && $employees instanceof \Illuminate\Pagination\AbstractPaginator && $employees->hasPages())
            <div class="mt-6 pagination-animation">
              {{ $employees->links() }}
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Konfirmasi Hapus -->
  <div id="deleteConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay modal-hidden bg-black bg-opacity-75">
    <div class="modal-container-delete w-full max-w-md rounded-xl shadow-2xl p-6 md:p-8 relative transform transition-all duration-300 ease-out">
      <div class="text-center">
        <svg class="w-16 h-16 mb-4 text-red-500 dark:text-red-400 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
        </svg>
        <h3 class="text-xl font-semibold text-stone-700 dark:text-orange-100 mb-2">Konfirmasi Hapus</h3>
        <p class="text-sm text-stone-600 dark:text-orange-200 mb-6" id="deleteConfirmMessage">
          Apakah Anda yakin ingin menghapus karyawan ini?
        </p>
      </div>
      <div class="flex justify-center space-x-4">
        <button type="button" onclick="closeDeleteConfirmModal()" class="px-6 py-2.5 rounded-lg text-sm font-medium text-stone-700 bg-stone-200 hover:bg-stone-300 dark:bg-stone-600 dark:text-orange-100 dark:hover:bg-stone-500 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-stone-400">
          Batal
        </button>
        <form id="deleteEmployeeForm" action="" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-red-500">
            Ya, Hapus
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Tampilkan Kartu QR Code via Iframe -->
  <div id="qrCardModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 modal-overlay modal-hidden bg-black bg-opacity-75">
    <div class="modal-container-qr-card w-full max-w-[380px] sm:max-w-sm rounded-xl shadow-2xl relative transform transition-all duration-300 ease-out text-center overflow-hidden bg-orange-50 dark:bg-stone-800">
      <div class="flex justify-between items-center p-3 sm:p-4 border-b border-orange-200 dark:border-stone-700">
        <h3 class="text-md sm:text-lg font-semibold text-stone-700 dark:text-orange-100" id="qrCardModalTitle">Kartu Karyawan</h3>
        <button onclick="closeQrCardModal()" class="text-stone-500 hover:text-stone-700 dark:text-orange-300 dark:hover:text-orange-100 transition-colors duration-300">
          <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      {{-- Kontainer iframe dengan tinggi yang disesuaikan --}}
      <div class="iframe-container bg-white dark:bg-stone-900">
        <iframe id="qrCardIframe" src="" class="w-full h-full border-0" title="Kartu QR Karyawan"></iframe>
      </div>
    </div>
  </div>


  <style>
    .action-btn {
      @apply inline-flex items-center justify-center rounded-md text-white shadow-sm transition-all duration-150 transform hover:scale-110 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-offset-orange-50 dark:focus:ring-offset-stone-800;
      width: 2.5rem;
      height: 2.5rem;
      padding: 0.5rem;
    }

    .action-btn-icon {
      @apply w-5 h-5;
    }

    .page-fade-in {
      animation: pageFadeIn 0.5s ease-out forwards;
      opacity: 0;
    }

    @keyframes pageFadeIn {
      to {
        opacity: 1;
      }
    }

    .header-animation {
      animation: headerSlideDown 0.6s ease-out 0.2s forwards;
      opacity: 0;
      transform: translateY(-20px);
    }

    @keyframes headerSlideDown {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-animation {
      animation: alertPopIn 0.5s ease-out 0.4s forwards;
      opacity: 0;
      transform: scale(0.9);
    }

    @keyframes alertPopIn {
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .table-animation {
      animation: tableFadeInUp 0.7s ease-out 0.5s forwards;
      opacity: 0;
      transform: translateY(20px);
    }

    @keyframes tableFadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .pagination-animation {
      animation: paginationFadeIn 0.5s ease-out 0.8s forwards;
      opacity: 0;
    }

    @keyframes paginationFadeIn {
      to {
        opacity: 1;
      }
    }

    nav[role="navigation"] span>span,
    nav[role="navigation"] a {
      @apply !text-stone-600 dark: !text-orange-300 !border-orange-200 dark: !border-stone-700 !bg-orange-50 dark: !bg-stone-800;
    }

    nav[role="navigation"] span[aria-current="page"]>span,
    nav[role="navigation"] a:hover {
      @apply !bg-orange-200 dark: !bg-stone-600 !border-orange-400 dark: !border-yellow-700 !text-orange-700 dark: !text-orange-100;
    }

    nav[role="navigation"] span[aria-disabled="true"]>span {
      @apply !text-stone-400 dark: !text-stone-600 !bg-orange-100 dark: !bg-stone-700;
    }

    .modal-overlay {
      transition: opacity 0.3s ease-in-out;
    }

    .modal-container-delete,
    .modal-container-qr-card {
      opacity: 0;
      transform: translateY(20px) scale(0.95);
      transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }

    .modal-container-delete {
      background-color: #fff;
    }

    .dark .modal-container-delete {
      background-color: #44403c;
    }

    .modal-container-qr-card {
      /* Styling untuk kontainer modal iframe */
    }

    .iframe-container {
      width: 350px;
      /* Lebar disamakan dengan .card di qrcode.blade.php */
      height: 500px;
      /* Tinggi perkiraan, sesuaikan agar pas dengan konten kartu */
      /* Jika ingin rasio ID Card (sekitar 1.586:1) */
      /* height: calc(350px / 1.586); */
      overflow: hidden;
      /* Sembunyikan scrollbar iframe jika kontennya pas */
      margin: auto;
      /* Pusatkan iframe jika modal lebih lebar */
    }

    .modal-container-qr-card iframe {
      transform-origin: top left;
      /* Scaling bisa dipertimbangkan jika ingin memuat konten besar ke iframe kecil,
           tapi lebih baik kontennya yang responsif/sesuai ukuran.
           Contoh: transform: scale(0.8); width: calc(100% / 0.8); height: calc(100% / 0.8); */
    }


    .modal-hidden {
      opacity: 0;
      pointer-events: none;
    }

    .modal-hidden .modal-container-delete,
    .modal-hidden .modal-container-qr-card {
      transform: translateY(20px) scale(0.95);
      opacity: 0;
    }

    .modal-visible {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-visible .modal-container-delete,
    .modal-visible .modal-container-qr-card {
      transform: translateY(0) scale(1);
      opacity: 1;
    }
  </style>
  <script>
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const deleteEmployeeForm = document.getElementById('deleteEmployeeForm');
    const deleteConfirmMessage = document.getElementById('deleteConfirmMessage');

    function showDeleteConfirmModal(deleteUrl, employeeName) {
      deleteEmployeeForm.action = deleteUrl;
      deleteConfirmMessage.textContent = `Apakah Anda yakin ingin menghapus karyawan "${employeeName}"? Tindakan ini tidak dapat dibatalkan.`;
      deleteConfirmModal.classList.remove('modal-hidden');
      deleteConfirmModal.classList.add('modal-visible');
    }

    function closeDeleteConfirmModal() {
      deleteConfirmModal.classList.remove('modal-visible');
      deleteConfirmModal.classList.add('modal-hidden');
    }

    const qrCardModal = document.getElementById('qrCardModal');
    const qrCardIframe = document.getElementById('qrCardIframe');
    const qrCardModalTitle = document.getElementById('qrCardModalTitle');

    function showQrCodePageInModal(pageUrl, employeeName) {
      qrCardModalTitle.textContent = `Kartu Karyawan: ${employeeName}`;
      qrCardIframe.src = pageUrl;
      qrCardModal.classList.remove('modal-hidden');
      qrCardModal.classList.add('modal-visible');
    }

    function closeQrCardModal() {
      qrCardModal.classList.remove('modal-visible');
      qrCardModal.classList.add('modal-hidden');
      qrCardIframe.src = 'about:blank';
    }

    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        if (deleteConfirmModal.classList.contains('modal-visible')) {
          closeDeleteConfirmModal();
        }
        if (qrCardModal.classList.contains('modal-visible')) {
          closeQrCardModal();
        }
      }
    });

    deleteConfirmModal.addEventListener('click', function(event) {
      if (event.target === deleteConfirmModal) {
        closeDeleteConfirmModal();
      }
    });
    qrCardModal.addEventListener('click', function(event) {
      if (event.target === qrCardModal) {
        closeQrCardModal();
      }
    });
  </script>
</x-app-layout>