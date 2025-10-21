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
            <div class="bg-teal-100 border-l-4 border-brand-teal text-teal-800 p-4 rounded-r-lg" role="alert">
                <p class="font-bold">Periode Aktif</p>
                <p>Saat ini periode <span class="font-semibold">{{ $activePeriod->name }}</span> sedang berjalan. Silakan lakukan input data.</p>
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-r-lg" role="alert">
                <p class="font-bold">Informasi</p>
                <p>Saat ini tidak ada periode penilaian yang aktif.</p>
            </div>
        @endif

        <!-- Shortcut -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat Input Data</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Shortcut Input Nilai Disiplin -->
                <a href="{{ route('discipline.scores.index') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-center mb-2">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                    </div>
                    <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Input Nilai Disiplin</p>
                </a>
                <!-- Shortcut Input SKP -->
                <a href="{{ route('skp.index') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-center mb-2">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" /></svg>
                    </div>
                    <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Input SKP</p>
                </a>
            </div>
        </div>
    </div>
</x-main-layout>