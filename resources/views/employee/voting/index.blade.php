<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tugas Penilaian Anda (Periode: {{ $activePeriod->name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- BLOK PENILAIAN REKAN PEGAWAI (Latar bir Pucat) -->
            <div class="bg-blue-50 border border-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-blue-800 mb-4">Perlu Dinilai: Anggota Tim ({{ $pendingPegawai->count() }})</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @forelse($pendingPegawai as $assignment)
                            <a href="{{ route('voting.show', $assignment->id) }}" 
                               class="group block p-4 bg-white rounded-lg border border-gray-200 shadow-sm 
                                      hover:bg-white hover:border-brand-blue hover:shadow-md 
                                      transition-all duration-200">
                                <p class="font-semibold text-gray-800 group-hover:text-brand-blue">{{ $assignment->target->name }}</p>
                                <p class="text-sm text-gray-500">{{ $assignment->target->jabatan }}</p>
                            </a>
                        @empty
                            <div class="col-span-full bg-white/50 p-4 rounded-lg text-center text-gray-500">
                                Tidak ada rekan pegawai yang perlu dinilai.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- BLOK PENILAIAN KETUA TIM (Latar biru Pucat) -->
            <div class="bg-blue-50 border border-blue-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-blue-800 mb-4">Perlu Dinilai: Ketua Tim ({{ $pendingKetuaTim->count() }})</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @forelse($pendingKetuaTim as $assignment)
                            <a href="{{ route('voting.show', $assignment->id) }}" 
                               class="group block p-4 bg-white rounded-lg border border-gray-200 shadow-sm 
                                      hover:bg-white hover:border-brand-blue hover:shadow-md 
                                      transition-all duration-200">
                                <p class="font-semibold text-gray-800 group-hover:text-brand-blue">{{ $assignment->target->name }}</p>
                                <p class="text-sm text-gray-500">{{ $assignment->target->jabatan }}</p>
                            </a>
                        @empty
                             <div class="col-span-full bg-white/50 p-4 rounded-lg text-center text-gray-500">
                                Tidak ada ketua tim yang perlu dinilai.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- BLOK SELESAI DINILAI (Latar Hijau Pucat) -->
            <div class="bg-teal-50 border border-teal-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-teal-800 mb-4">Selesai Dinilai ({{ $completedAssignments->count() }})</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @forelse($completedAssignments as $assignment)
                            <!-- Kartu di dalam blok hijau dibuat sedikit transparan -->
                            <div class="block p-4 bg-white/70 border border-teal-200 rounded-lg opacity-80">
                                <p class="font-semibold text-gray-700">{{ $assignment->target->name }}</p>
                                <p class="text-sm text-gray-500">{{ $assignment->target->jabatan }}</p>
                            </div>
                        @empty
                            <div class="col-span-full bg-white/50 p-4 rounded-lg text-center text-gray-500">
                                Anda belum menyelesaikan satupun tugas penilaian.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>