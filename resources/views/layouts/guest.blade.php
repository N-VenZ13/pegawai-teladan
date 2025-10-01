<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPATEN') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Latar belakang abu-abu lembut -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

        <!-- Logo dan Judul -->
        <div class="text-center mb-6">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" class="w-20 h-20 mx-auto" alt="Logo">
            </a>
            <h1 class="mt-4 text-3xl font-semibold text-gray-800 tracking-tight">
                <!-- {{ config('Sistem Penilaian Kinerja Pegawai') }} -->
                Sistem Penilaian Pegawai Teladan
            </h1>
        
        </div>

        <!-- Kartu Form dengan Latar Biru -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-brand-blue text-white shadow-lg overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>