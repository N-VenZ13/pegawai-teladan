<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPEKA') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
        <div class="relative w-full max-w-4xl lg:max-w-5xl flex shadow-2xl rounded-2xl overflow-hidden" style="height: 650px;">
            
            <!-- Kolom Kiri (Visual) -->
            <div class="hidden lg:flex w-7/12 bg-white p-12 flex-col justify-between">
                <div class="z-10">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="h-10" alt="Logo">
                        <div>
                            <p class="text-l font-bold text-gray-500 leading-tight">BADAN PUSAT STATISTIK</p>
                            <p class="text-sm text-gray-500">Kabupaten Muara Enim</p>
                        </div>
                    </a>
                </div>
                <div class="flex justify-center items-center z-10">
                    <img src="{{ asset('images/login-illustration.png') }}" alt="Illustration" class="w-full max-w-md">
                </div>
                <div class="text-xs text-gray-400 z-10">
                    &copy; {{ date('Y') }} BPS Kabupaten Muara Enim
                </div>
            </div>

            <!-- Kolom Kanan (Form) -->
            <div class="w-full lg:w-5/12 bg-brand-blue p-8 lg:p-12 flex flex-col justify-center">
                {{ $slot }}
            </div>

            
        </div>
    </div>
</body>
</html>