<x-main-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Grid untuk Widget -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Widget Total Pegawai -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 flex flex-col justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Pegawai</h3>
                <p class="text-4xl font-bold text-brand-blue mt-1">{{ $totalPegawai }}</p>
            </div>
            <p class="text-xs text-gray-400 mt-4">Jumlah seluruh pegawai aktif</p>
        </div>

        <!-- Widget Total Kepala BPS -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 flex flex-col justify-between">
            <div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Kepala BPS</h3>
                <p class="text-4xl font-bold text-brand-green mt-1">{{ $totalKepalaBps }}</p>
            </div>
            <p class="text-xs text-gray-400 mt-4">Jumlah Kepala BPS/ketua tim</p>
        </div>
        
        <!-- Widget Periode Aktif & Progres -->
        @if($activePeriod)
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 col-span-1 md:col-span-2">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Periode Aktif: <span class="font-bold text-gray-700">{{ $activePeriod->name }}</span></h3>
            <p class="text-lg font-semibold text-gray-800 mt-4">Progres Penilaian</p>
            <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                <div class="bg-brand-orange h-4 rounded-full text-center text-white text-xs font-bold" @style(['width' => $progress['percentage'] . '%'])>
                    {{ $progress['percentage'] }}%
                </div>
            </div>
            <p class="text-right text-sm text-gray-600 mt-2">{{ $progress['completed'] }} dari {{ $progress['total'] }} tugas selesai</p>
        </div>
        @endif

        <!-- Widget Hasil Terpublikasi Terakhir -->
        @if($publishedResults)
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 col-span-1 md:col-span-2 lg:col-span-4">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Hasil Penilaian Terbaru</h3>
            <div class="mt-4 flex flex-col sm:flex-row justify-between sm:items-center">
                <p class="text-xl font-semibold text-gray-800">{{ $publishedResults->name }}</p>
                <a href="{{ route('recap.show', $publishedResults->id) }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Lihat Hasil & Dokumen
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Shortcut -->
    <div class="mt-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <!-- Contoh Shortcut dengan Ikon -->
            <a href="{{ route('admin.users.create') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-2">
                    <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.5 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <p class="font-semibold text-gray-700 group-hover:text-brand-blue transition-colors">Tambah Pegawai</p>
            </a>
            
            <!-- Tambahkan shortcut lain di sini -->

        </div>
    </div>
</x-main-layout>