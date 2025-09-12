<!-- resources/views/employee/results/list.blade.php -->
<x-app-layout>
    <x-slot name="header">
        Hasil Penilaian Pegawai Teladan
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Silakan pilih periode untuk melihat hasil akhir.</h3>
                    <div class="space-y-4">
                        @forelse ($publishedPeriods as $period)
                            <a href="{{ route('voting.results.show', $period->id) }}" class="block p-4 bg-gray-50 rounded-lg border ...">
                                <p class="font-semibold text-gray-800">{{ $period->name }}</p>
                            </a>
                        @empty
                            <p class="text-gray-500 text-center py-10">Belum ada hasil penilaian yang dipublikasikan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>