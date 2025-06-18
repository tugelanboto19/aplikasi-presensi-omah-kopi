<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark"> {{-- Pastikan ada class="dark" --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 dark:text-gray-100 antialiased">
    {{-- Latar belakang utama halaman guest --}}
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500 dark:text-gray-400" />
            </a>
        </div>

        {{-- Kartu yang membungkus form login/register --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-black dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }} {{-- Di sini konten form login/register akan masuk --}}
        </div>
    </div>
</body>

</html>