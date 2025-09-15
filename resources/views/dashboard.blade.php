<!-- resources/views/employee/dashboard.blade.php -->
<x-main-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-6">
        <!-- Pesan Selamat Datang -->
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $user->name }}!</h2>
            <p class="text-gray-600 mt-1">Berikut adalah ringkasan aktivitas Anda.</p>
        </div>

        <!-- Widget Utama: Tugas Penilaian -->
        @if($activePeriod)
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Periode Aktif: <span class="font-bold text-gray-700">{{ $activePeriod->name }}</span></h3>

                <div class="mt-4 flex flex-col sm:flex-row justify-between sm:items-center">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">Anda memiliki <span class="text-4xl font-bold text-brand-orange">{{ $pendingAssignmentsCount }}</span> tugas penilaian yang perlu diselesaikan.</p>
                        @if($pendingAssignmentsCount == 0)
                            <p class="text-brand-green font-semibold mt-1">Terima kasih, semua tugas penilaian telah selesai!</p>
                        @endif
                    </div>
                    <a href="{{ route('voting.index') }}" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Mulai Menilai
                    </a>
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
    </div>
</x-main-layout>