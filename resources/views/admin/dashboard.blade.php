<x-main-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Notifikasi Sukses (jika ada, sekarang berwarna teal) -->
    @if (session('success'))
    <div class="mb-6 bg-teal-100 border-l-4 border-brand-teal text-teal-800 p-4 rounded-md" role="alert">
        <p class="font-bold">Sukses</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- Grid untuk Widget -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Widget Total Pegawai -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Pegawai</h3>
            <p class="text-4xl font-bold text-brand-blue mt-1">{{ $totalPegawai }}</p>
        </div>

        <!-- Widget Total Kepala BPS -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Kepala BPS</h3>
            <p class="text-4xl font-bold text-brand-teal mt-1">{{ $totalKepalaBps }}</p>
        </div>

        <!-- Widget Periode Aktif & Progres -->
        @if($activePeriod)
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 col-span-1 md:col-span-2">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Periode Aktif: <span class="font-bold text-gray-700">{{ $activePeriod->name }}</span></h3>
            <p class="text-lg font-semibold text-gray-800 mt-4">Progres Penilaian</p>
            <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                <div class="bg-brand-amber h-4 rounded-full text-center text-white text-xs font-bold" @style(['width'=> $progress['percentage'] . '%'])>
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
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">

            <!-- Shortcut Tambah Pegawai -->
            <a href="{{ route('admin.users.create') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-2">
                    <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.5 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Tambah Pegawai</p>
            </a>

            <!-- Shortcut Tambah Periode -->
            <a href="{{ route('admin.periods.create') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-2">
                    <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18" />
                    </svg>
                </div>
                <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Tambah Periode</p>
            </a>

            <!-- Shortcut Tambah Pertanyaan Pegawai -->
            <a href="{{ route('admin.questions.create') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-2">
                    <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Tambah Pertanyaan</p>
            </a>

            <!-- Shortcut Tambah Kriteria Evaluasi -->
            <a href="{{ route('admin.leader-criteria.create') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-2">
                    <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                    </svg>
                </div>
                <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Tambah Kriteria Evaluasi</p>
            </a>

            <!-- Shortcut Tambah Kriteria Disiplin -->
            <a href="{{ route('discipline.criteria.create') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-2">
                    <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.286zm0 13.036h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
                <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Tambah Kriteria Disiplin</p>
            </a>

            <!-- Shortcut Lihat Progres (Tetap relevan) -->
            @if($activePeriod)
            <a href="{{ route('monitoring.show', $activePeriod->id) }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-amber-300 hover:border-brand-amber hover:shadow-lg transition-all duration-300">
                <div class="flex justify-center mb-2">
                    <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-amber transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 100 15 7.5 7.5 0 000-15zM21 21l-5.197-5.197" />
                    </svg>
                </div>
                <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-amber transition-colors">Lihat Progres</p>
            </a>
            @endif
        </div>
    </div>
</x-main-layout>