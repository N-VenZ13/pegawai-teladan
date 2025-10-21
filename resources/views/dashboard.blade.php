<x-main-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-6">
        <!-- Pesan Selamat Datang -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $user->name }}!</h2>
            <p class="text-gray-600 mt-1">Berikut adalah ringkasan aktivitas penilaian Anda.</p>
        </div>

        <!-- Widget Utama: Tugas Penilaian -->
        @if($activePeriod)
        <div class="bg-amber-50 border border-amber-200 p-6 rounded-xl shadow-sm">
            <h3 class="text-amber-800 text-sm font-medium uppercase tracking-wider">Periode Aktif: <span class="font-bold">{{ $activePeriod->name }}</span></h3>

            <div class="mt-4 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    @if($pendingAssignmentsCount > 0)
                    <p class="text-lg font-semibold text-gray-800">Anda memiliki <span class="text-4xl font-bold text-brand-amber">{{ $pendingAssignmentsCount }}</span> tugas penilaian yang perlu diselesaikan.</p>
                    @else
                    <p class="text-lg font-semibold text-brand-teal">Terima kasih, semua tugas penilaian telah selesai!</p>
                    @endif
                </div>
                @if($pendingAssignmentsCount > 0)
                <a href="{{ route('voting.index') }}" class="flex-shrink-0 inline-flex items-center px-4 py-2 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Mulai Menilai
                </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Widget Hasil Penilaian Terakhir -->
        @if($latestPublishedPeriod)
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Hasil Penilaian Terbaru</h3>
            <div class="mt-4 flex flex-col sm:flex-row justify-between sm:items-center">
                <p class="text-xl font-semibold text-gray-800">{{ $latestPublishedPeriod->name }}</p>
                <a href="{{ route('voting.results.show', $latestPublishedPeriod->id) }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Lihat Hasil
                </a>
            </div>
        </div>
        @endif

        <!-- Notifikasi jika tidak ada aktivitas -->
        @if(!$activePeriod && !$latestPublishedPeriod)
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 text-center">
            <p class="text-gray-600">Saat ini tidak ada aktivitas penilaian yang berlangsung.</p>
        </div>
        @endif

        <!-- ======================================================= -->
        <!--   SHORTCUT KHUSUS KEPALA BPS (DAN ROLE LAIN JIKA PERLU) -->
        <!-- ======================================================= -->
        @role('Kepala BPS')
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat Kepala BPS</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Shortcut Evaluasi Kepala BPS -->
                <a href="{{ route('leader.evaluation.index') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-center mb-2">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Evaluasi Kinerja</p>
                </a>

                <!-- Shortcut Rekapitulasi -->
                <a href="{{ route('recap.select_period') }}" class="group bg-white p-4 text-center rounded-xl shadow-md border border-gray-200 hover:border-brand-blue hover:shadow-lg transition-all duration-300">
                    <div class="flex justify-center mb-2">
                        <svg class="w-8 h-8 text-gray-400 group-hover:text-brand-blue transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm text-gray-700 group-hover:text-brand-blue transition-colors">Rekapitulasi</p>
                </a>
            </div>
        </div>
        @endrole
        <!-- ======================================================= -->
    </div>
</x-main-layout>