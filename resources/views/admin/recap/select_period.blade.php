<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Periode Rekapitulasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-800">Daftar Periode Penilaian</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Silakan pilih periode yang ingin Anda lihat rekapitulasinya. Periode dikelompokkan berdasarkan tahun.
                        </p>
                    </div>

                    @forelse ($periods as $year => $periodGroup)
                        {{-- Inisialisasi accordion hanya jika ada periode --}}
                        @if($loop->first)
                            <div id="accordion-group" data-accordion="collapse">
                        @endif

                        <h2 id="accordion-heading-{{ $year }}">
                            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-gray-700 border {{ $loop->first ? 'rounded-t-xl' : '' }} {{ !$loop->last ? 'border-b-0' : '' }} border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-100 gap-3" data-accordion-target="#accordion-body-{{ $year }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="accordion-body-{{ $year }}">
                                <span>Periode Penilaian Tahun {{ $year }}</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-body-{{ $year }}" class="{{ $loop->first ? '' : 'hidden' }}" aria-labelledby="accordion-heading-{{ $year }}">
                            <div class="border border-gray-200 {{ $loop->last ? 'rounded-b-xl border-t-0' : 'border-t-0 border-b-0' }}">
                                @foreach($periodGroup as $period)
                                    <a href="{{ route('recap.show', $period->id) }}" class="block p-4 border-b border-gray-200 last:border-b-0 hover:bg-indigo-50 transition duration-150">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $period->name }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $period->start_date->isoFormat('D MMM Y') }} - {{ $period->end_date->isoFormat('D MMM Y') }}
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
                                @endforeach
                            </div>
                        </div>

                        {{-- Tutup div accordion hanya jika ada periode --}}
                        @if($loop->last)
                            </div>
                        @endif
                    @empty
                        <div class="text-center py-10">
                            <p class="text-gray-500">Tidak ada periode yang siap untuk direkapitulasi.</p>
                            <p class="text-gray-400 text-sm mt-1">Pastikan status periode sudah diubah menjadi 'finished' atau 'published'.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-main-layout>