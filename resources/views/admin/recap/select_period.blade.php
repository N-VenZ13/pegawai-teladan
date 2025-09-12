<!-- resources/views/admin/recap/select_period.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Periode Rekapitulasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Silakan pilih periode yang ingin Anda lihat rekapitulasinya.</h3>

                    <div class="space-y-4">
                        @forelse ($periods as $period)
                        <a href="{{ route('recap.show', $period->id) }}" class="block p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-indigo-50 hover:border-indigo-400 transition">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $period->name }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($period->start_date)->isoFormat('D MMM Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->isoFormat('D MMM Y') }}
                                    </p>
                                </div>
                                <div>
                                    @if ($period->status == 'published')
                                    <span class="bg-purple-200 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">Sudah Dipublikasi</span>
                                    @else
                                    <span class="bg-blue-200 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai (Draft)</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="text-center py-10">
                            <p class="text-gray-500">Tidak ada periode yang siap untuk direkapitulasi.</p>
                            <p class="text-gray-400 text-sm mt-1">Pastikan status periode sudah diubah menjadi 'finished'.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>