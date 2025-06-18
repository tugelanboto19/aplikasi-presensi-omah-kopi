<x-app-layout>
    {{-- Menambahkan Google Fonts untuk tema Jawa --}}
    <x-slot name="head">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    </x-slot>

    <x-slot name="header">
        {{-- Bungkus h2 dengan div untuk menerapkan background kustom --}}
        <div class="bg-stone-800 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-3 shadow">
            <h2 class="font-semibold text-xl text-orange-100 leading-tight">
                Dashboard Admin - Omah Kopi Mrisen
            </h2>
        </div>
    </x-slot>

    {{-- Latar belakang utama dengan motif batik --}}
    <div class="py-12 bg-orange-50 dark:bg-stone-900 min-h-screen" style="background-image: url('https://www.transparenttextures.com/patterns/subtle-batik.png');">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Kartu utama dengan efek glassmorphism --}}
            <div class="bg-yellow-700/70 dark:bg-stone-800/80 backdrop-blur-md shadow-2xl sm:rounded-2xl p-1 overflow-hidden">
                <div class="bg-orange-50/80 dark:bg-stone-800/70 overflow-hidden shadow-inner sm:rounded-lg">
                    <div class="p-6 md:p-8 text-stone-900 dark:text-orange-100">
                        <div class="welcome-message-animation">
                            {{-- Judul dengan font Jawa --}}
                            <h3 class="text-4xl mb-3 text-stone-700 dark:text-orange-200" style="font-family: 'Caveat', cursive;">
                                Sugeng Rawuh, {{ Auth::user()->name }}!
                            </h3>
                            <p class="mb-8 text-stone-600 dark:text-orange-300">
                                Pilih salah satunggaling menu ing ngandhap menika kagem miwiti:
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                            {{-- Kartu 1: Manajemen Karyawan --}}
                            <a href="{{ route('employees.index') }}" class="card-link-wrapper no-underline card-item-animation block transform transition-all duration-300 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-orange-500 focus:ring-opacity-50 rounded-lg">
                                <div class="card-interactive-bg rounded-lg shadow-lg p-6 flex flex-col items-center text-center h-full border border-yellow-700/50 dark:border-yellow-600/50">
                                    <div class="card-icon-wrapper">
                                        <svg class="w-16 h-16 mb-4 text-white opacity-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                    <h5 class="text-xl font-semibold text-orange-50 dark:text-orange-100 mb-2 card-title-interactive">Manajemen Karyawan</h5>
                                    <p class="text-sm text-orange-200 dark:text-orange-300 opacity-90 mb-4 flex-grow">Tambah, pirsani, edit, utawi busak data karyawan.</p>
                                    <span class="btn-card-look mt-auto">Pirsani Data</span>
                                </div>
                            </a>

                            {{-- Kartu 2: Scan Absensi QR --}}
                            <a href="{{ route('attendance.scan') }}" class="card-link-wrapper no-underline card-item-animation block transform transition-all duration-300 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-orange-500 focus:ring-opacity-50 rounded-lg" style="animation-delay: 0.1s;">
                                <div class="card-interactive-bg rounded-lg shadow-lg p-6 flex flex-col items-center text-center h-full border border-yellow-700/50 dark:border-yellow-600/50">
                                    <div class="card-icon-wrapper">
                                        <svg class="w-16 h-16 mb-4 text-white opacity-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 15.375c-.621 0-1.125.504-1.125 1.125v2.25c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V16.5c0-.621-.504-1.125-1.125-1.125h-2.25z" />
                                        </svg>
                                    </div>
                                    <h5 class="text-xl font-semibold text-orange-50 dark:text-orange-100 mb-2 card-title-interactive">Scan Absensi QR</h5>
                                    <p class="text-sm text-orange-200 dark:text-orange-300 opacity-90 mb-4 flex-grow">Scan QR code kagem absensi mlebet &amp; kondur.</p>
                                    <span class="btn-card-look mt-auto">Wiwiti Scan</span>
                                </div>
                            </a>

                            {{-- Kartu 3: Input Absensi Manual --}}
                            <a href="{{ route('attendances.manual.create') }}" class="card-link-wrapper no-underline card-item-animation block transform transition-all duration-300 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-orange-500 focus:ring-opacity-50 rounded-lg" style="animation-delay: 0.2s;">
                                <div class="card-interactive-bg rounded-lg shadow-lg p-6 flex flex-col items-center text-center h-full border border-yellow-700/50 dark:border-yellow-600/50">
                                    <div class="card-icon-wrapper">
                                        <svg class="w-16 h-16 mb-4 text-white opacity-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </div>
                                    <h5 class="text-xl font-semibold text-orange-50 dark:text-orange-100 mb-2 card-title-interactive">Input Absensi Manual</h5>
                                    <p class="text-sm text-orange-200 dark:text-orange-300 opacity-90 mb-4 flex-grow">Cathet izin, sakit, utawi alpha karyawan.</p>
                                    <span class="btn-card-look mt-auto">Input Manual</span>
                                </div>
                            </a>

                            {{-- Kartu 4: Laporan Harian --}}
                            <a href="{{ route('laporan.harian') }}" class="card-link-wrapper no-underline card-item-animation block transform transition-all duration-300 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-orange-500 focus:ring-opacity-50 rounded-lg" style="animation-delay: 0.3s;">
                                <div class="card-interactive-bg rounded-lg shadow-lg p-6 flex flex-col items-center text-center h-full border border-yellow-700/50 dark:border-yellow-600/50">
                                    <div class="card-icon-wrapper">
                                        <svg class="w-16 h-16 mb-4 text-white opacity-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                        </svg>
                                    </div>
                                    <h5 class="text-xl font-semibold text-orange-50 dark:text-orange-100 mb-2 card-title-interactive">Laporan Dinten</h5>
                                    <p class="text-sm text-orange-200 dark:text-orange-300 opacity-90 mb-4 flex-grow">Pirsani rekapitulasi absensi saben dinten.</p>
                                    <span class="btn-card-look mt-auto">Pirsani Laporan</span>
                                </div>
                            </a>

                            {{-- Kartu 5: Laporan Bulanan --}}
                            <a href="{{ route('laporan.bulanan') }}" class="card-link-wrapper no-underline card-item-animation block transform transition-all duration-300 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-orange-500 focus:ring-opacity-50 rounded-lg" style="animation-delay: 0.4s;">
                                <div class="card-interactive-bg rounded-lg shadow-lg p-6 flex flex-col items-center text-center h-full border border-yellow-700/50 dark:border-yellow-600/50">
                                    <div class="card-icon-wrapper">
                                        <svg class="w-16 h-16 mb-4 text-white opacity-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-3.75h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V12zm2.25-2.25h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V12z" />
                                        </svg>
                                    </div>
                                    <h5 class="text-xl font-semibold text-orange-50 dark:text-orange-100 mb-2 card-title-interactive">Laporan Wulan</h5>
                                    <p class="text-sm text-orange-200 dark:text-orange-300 opacity-90 mb-4 flex-grow">Filter lan pirsani rekap absensi saben wulan.</p>
                                    <span class="btn-card-look mt-auto">Pirsani Laporan</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .btn-card-look {
            @apply inline-block bg-orange-100 dark:bg-stone-600 text-orange-700 dark:text-orange-200 font-semibold py-2 px-5 rounded-lg shadow-md border border-orange-300/50 dark:border-stone-500/50 text-sm transition-all duration-300;
        }

        .card-link-wrapper:hover .btn-card-look {
            @apply bg-orange-200 dark:bg-stone-500 text-orange-800 dark:text-orange-100 shadow-lg scale-105;
        }

        .welcome-message-animation {
            animation: fadeInDown 0.8s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-item-animation {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
            animation: cardFadeInUp 0.6s ease-out forwards;
        }

        @keyframes cardFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .card-interactive-bg {
            @apply bg-gradient-to-br from-yellow-800/80 to-yellow-900/90 dark:from-stone-700/80 dark:to-stone-800/90;
            transition: all 0.4s ease-in-out;
        }

        .card-link-wrapper:hover .card-interactive-bg {
            @apply from-yellow-700 to-yellow-800 dark:from-stone-600 dark:to-stone-700;
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.4);
        }

        .card-icon-wrapper svg {
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .card-link-wrapper:hover .card-icon-wrapper svg {
            transform: scale(1.2) rotate(-8deg) translateY(-3px);
        }

        .card-title-interactive {
            font-family: 'Inter', sans-serif;
            transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .card-link-wrapper:hover .card-title-interactive {
            color: #FFDAB9;
            /* Peach Puff */
            transform: translateY(-2px);
        }

        .dark .card-link-wrapper:hover .card-title-interactive {
            color: #FFEBCD;
            /* Blanched Almond */
        }
    </style>
</x-app-layout>