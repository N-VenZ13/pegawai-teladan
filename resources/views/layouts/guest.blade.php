<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sipaten') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="w-full max-w-4xl flex shadow-2xl rounded-2xl overflow-hidden" style="height: 600px;">

            <!-- Kolom Kiri (Visual - Latar Gelap) -->
            <div class="hidden lg:flex w-3/5 bg-brand-dark p-12 flex-col">

                <!-- Bagian Atas: Logo Resmi -->
                <div class="flex-shrink-0">
                    <a href="/">
                        <!-- UBAH UKURAN LOGO DI SINI (CONTOH: h-16) -->
                        <img src="{{ asset('images/logo-bps.png') }}" class="h-16" alt="Logo BPS Kabupaten Muara Enim">
                    </a>
                </div>

                <!-- Bagian Tengah: Ilustrasi & Subjudul (Mengisi ruang sisa) -->
                <div class="flex-grow flex flex-col items-center justify-center text-center">
                    <img src="{{ asset('images/login-illustration6.png') }}" alt="Ilustrasi Sipaten" class="w-full max-w-sm mx-auto">

                    <!-- SUBJUDUL BARU DENGAN WARNA -->
                    <p class="mb-12 font-semibold text-brand-blue" style="font-size: 21.5px;">
                        Sistem Penilaian Pegawai Teladan
                    </p>
                </div>

                <!-- Bagian Bawah: Copyright -->
                <div class="flex-shrink-0 text-xs text-gray-400 text-center">
                    &copy; {{ date('Y') }} BPS Kabupaten Muara Enim
                </div>

            </div>

            <!-- Kolom Kanan (Form - Latar Biru) -->
            <div class="w-full lg:w-2/5 bg-brand-blue p-8 lg:p-12 flex flex-col justify-center">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>