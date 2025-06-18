<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Omah Kopi Mrisen!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }

        .wood-theme-bg {
            background: linear-gradient(135deg, #8B4513, #A0522D, #D2691E);
        }

        .panel-slide-in-left {
            animation: slideInLeft 0.8s cubic-bezier(0.250, 0.460, 0.450, 0.940) forwards;
            opacity: 0;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .panel-slide-in-right {
            animation: slideInRight 0.8s cubic-bezier(0.250, 0.460, 0.450, 0.940) forwards;
            opacity: 0;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .content-fade-in-up {
            animation: contentFadeInUp 0.7s ease-out forwards;
            opacity: 0;
        }

        @keyframes contentFadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .delay-init {
            animation-delay: 0s;
        }

        .delay-content-1 {
            animation-delay: 0.5s;
        }

        .delay-content-2 {
            animation-delay: 0.7s;
        }

        .delay-content-3 {
            animation-delay: 0.9s;
        }

        .delay-content-4 {
            animation-delay: 1.1s;
        }

        .delay-content-5 {
            animation-delay: 1.3s;
        }

        .login-button:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 12px 25px -10px rgba(101, 67, 33, 0.5);
        }

        .interactive-text {
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .interactive-text:hover {
            transform: translateX(5px) scale(1.01);
        }

        .left-panel-text:hover {
            color: #FFDAB9;
        }

        .dark .right-panel-text-main:hover {
            color: #FFDEAD;
        }

        .right-panel-text-main:hover {
            color: #A0522D;
        }

        .dark .right-panel-text-secondary:hover {
            color: #F5DEB3;
        }

        .right-panel-text-secondary:hover {
            color: #8B4513;
        }

        .modal-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        .modal-container {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
            background-color: rgba(139, 69, 19, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(245, 230, 220, 0.2);
        }

        .dark .modal-container {
            background-color: rgba(41, 37, 36, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .modal-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .modal-hidden .modal-container {
            transform: translateY(-20px) scale(0.95);
            opacity: 0;
        }

        .modal-visible {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-visible .modal-container {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .modal-input-field {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(245, 230, 220, 0.3);
            color: #F5E6DC;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .modal-input-field:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: #FFDAB9;
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 218, 185, 0.4);
        }

        .modal-input-field::placeholder {
            color: rgba(245, 230, 220, 0.6);
        }

        .dark .modal-input-field {
            background-color: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(188, 143, 106, 0.5);
            color: #E0D6CE;
        }

        .dark .modal-input-field:focus {
            background-color: rgba(0, 0, 0, 0.35);
            border-color: #FFDAB9;
            box-shadow: 0 0 0 2px rgba(255, 218, 185, 0.3);
        }

        .dark .modal-input-field::placeholder {
            color: rgba(224, 214, 206, 0.5);
        }
    </style>
</head>

<body class="bg-orange-50 dark:bg-stone-900">
    <div class="flex flex-col md:flex-row h-screen">
        <div class="w-full md:w-1/2 h-1/3 md:h-full wood-theme-bg flex items-center justify-center p-8 md:p-12 panel-slide-in-left delay-init">
            <div class="text-center content-fade-in-up delay-content-1">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Omah Kopi Mrisen"
                    class="w-48 h-auto md:w-64 mx-auto mb-8 transform transition-transform duration-500 hover:scale-105">
                <h1 class="text-3xl md:text-4xl font-bold text-orange-100 mb-4 content-fade-in-up delay-content-2 interactive-text left-panel-text">Absensi Omah Kopi Mrisen</h1>
                <p class="text-lg md:text-xl text-orange-100 opacity-90 content-fade-in-up delay-content-3 interactive-text left-panel-text">Omah Kopi Kita Semua.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 h-2/3 md:h-full bg-orange-50 dark:bg-stone-800 flex flex-col items-center justify-center p-8 md:p-16 panel-slide-in-right delay-init">
            <div class="w-full max-w-md text-center md:text-left">
                <h2 class="text-4xl md:text-5xl font-bold text-stone-800 dark:text-orange-100 mb-4 content-fade-in-up delay-content-2 interactive-text right-panel-text-main">
                    Sugeng Rawuh!
                </h2>
                <p class="text-lg text-stone-600 dark:text-orange-200 mb-10 content-fade-in-up delay-content-3 interactive-text right-panel-text-secondary">
                    Monggo mlebet untuk ngatur absensi tim Omah Kopi Mrisen kanthi gampil lan akurat.
                </p>

                <button
                    onclick="openLoginModal()"
                    class="w-full md:w-auto bg-orange-600 hover:bg-orange-700 text-white font-semibold py-4 px-10 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 content-fade-in-up delay-content-4 login-button">
                    Mlebet Akun
                </button>

                <div class="mt-12 text-sm text-stone-500 dark:text-stone-400 content-fade-in-up delay-content-5">
                    <p>Durung kagungan akun?
                        <a href="{{ route('register') }}" class="font-semibold text-orange-600 hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-300">
                            Daftar Sakniki
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="loginModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay modal-hidden bg-black bg-opacity-70">
        <div class="modal-container w-full max-w-sm rounded-xl shadow-2xl p-6 md:p-8 relative">
            <button onclick="closeLoginModal()" class="absolute top-3 right-3 text-orange-100 hover:text-white dark:text-orange-200 dark:hover:text-orange-100 transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="text-center mb-6">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Omah Kopi Mrisen" class="w-24 h-auto md:w-28 mx-auto mb-3 transform transition-transform duration-300 hover:scale-105">
                <h2 class="text-2xl font-bold text-orange-100 dark:text-orange-200">Mlebet Akun</h2>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="modal_email" class="block text-sm font-medium text-orange-100 dark:text-orange-200 mb-1">Email / Username</label>
                    <input type="text" name="email" id="modal_email" required value="{{ old('email') }}"
                        class="w-full px-3 py-2.5 rounded-lg modal-input-field focus:ring-2 focus:ring-orange-400"
                        placeholder="contoh@email.com">
                </div>
                <div class="mb-5">
                    <label for="modal_password" class="block text-sm font-medium text-orange-100 dark:text-orange-200 mb-1">Password</label>
                    <input type="password" name="password" id="modal_password" required
                        class="w-full px-3 py-2.5 rounded-lg modal-input-field focus:ring-2 focus:ring-orange-400"
                        placeholder="••••••••">
                </div>
                <div class="flex items-center justify-between mb-5 text-xs">
                    <label for="modal_remember_me" class="flex items-center">
                        <input type="checkbox" id="modal_remember_me" name="remember" class="h-3.5 w-3.5 text-orange-500 border-orange-300 rounded focus:ring-orange-400">
                        <span class="ml-2 text-orange-100 dark:text-orange-200">Eling Kula</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="font-medium text-orange-200 hover:text-orange-100 dark:text-orange-300 dark:hover:text-orange-200 transition-colors duration-300">
                        Kesupen Password?
                    </a>
                    @endif
                </div>
                <div>
                    <button type="submit"
                        class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2.5 px-4 rounded-lg shadow-md submit-button focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-75">
                        Mlebet
                    </button>
                </div>
            </form>
            <p class="mt-6 text-center text-xs text-orange-200 dark:text-orange-300 opacity-90">
                Durung kagungan akun?
                <a href="{{ route('register') }}" class="font-semibold text-orange-100 hover:text-white dark:text-orange-300 dark:hover:text-orange-100 transition-colors duration-300">
                    Daftar Sakniki
                </a>
            </p>
        </div>
    </div>

    <script>
        const loginModal = document.getElementById('loginModal');

        function openLoginModal() {
            loginModal.classList.remove('modal-hidden');
            loginModal.classList.add('modal-visible');
            document.getElementById('modal_email').focus();
        }

        function closeLoginModal() {
            loginModal.classList.remove('modal-visible');
            loginModal.classList.add('modal-hidden');
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && loginModal.classList.contains('modal-visible')) {
                closeLoginModal();
            }
        });

        loginModal.addEventListener('click', function(event) {
            if (event.target === loginModal) {
                closeLoginModal();
            }
        });
    </script>
</body>

</html>