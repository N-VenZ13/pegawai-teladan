<!-- resources/views/umum/dashboard.blade.php -->
<x-main-layout>
    <x-slot name="header">
        Dashboard Bagian Umum
    </x-slot>

    <div class="space-y-6">
        <!-- Pesan Selamat Datang -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-gray-600 mt-1">Anda login sebagai Bagian Umum. Berikut adalah akses cepat untuk tugas Anda.</p>
        </div>
        
        <!-- Notifikasi Periode Aktif -->
        @if($activePeriod)
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md" role="alert">
                <p class="font-bold">Informasi</p>
                <p>Saat ini periode <span class="font-semibold">{{ $activePeriod->name }}</span> sedang aktif. Silakan lakukan input nilai.</p>
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md" role="alert">
                <p class="font-bold">Perhatian</p>
                <p>Saat ini tidak ada periode penilaian yang aktif. Anda belum bisa melakukan input nilai.</p>
            </div>
        @endif

        <!-- Shortcut -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- Shortcut Kriteria Disiplin -->
                <a href="{{ route('discipline.criteria.index') }}" class="group bg-white p-4 text-center rounded-xl shadow-md ...">
                    {{-- Icon --}}
                    <p class="font-semibold text-gray-700 group-hover:text-brand-blue transition-colors">Kriteria Disiplin</p>
                </a>
                <!-- Shortcut Input Nilai Disiplin -->
                <a href="{{ route('discipline.scores.index') }}" class="group bg-white p-4 text-center rounded-xl shadow-md ...">
                    {{-- Icon --}}
                    <p class="font-semibold text-gray-700 group-hover:text-brand-blue transition-colors">Input Nilai Disiplin</p>
                </a>
                <!-- Shortcut Input SKP -->
                <a href="{{ route('skp.index') }}" class="group bg-white p-4 text-center rounded-xl shadow-md ...">
                    {{-- Icon --}}
                    <p class="font-semibold text-gray-700 group-hover:text-brand-blue transition-colors">Input SKP</p>
                </a>
            </div>
        </div>
    </div>
</x-main-layout>