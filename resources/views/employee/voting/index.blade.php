<!-- resources/views/employee/voting/index.blade.php -->
<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tugas Penilaian Anda (Periode: {{ $activePeriod->name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- DAFTAR YANG HARUS DINILAI -->
            <!-- Blok Penilaian Pegawai -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Perlu Dinilai: Rekan Pegawai ({{ $pendingPegawai->count() }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($pendingPegawai as $assignment)
                        <a href="{{ route('voting.show', $assignment->id) }}" class="...">
                            <p class="font-semibold">{{ $assignment->target->name }}</p>
                            <p class="text-sm text-gray-500">{{ $assignment->target->jabatan }}</p>
                        </a>
                        @empty
                        <p class="col-span-3">Tidak ada rekan pegawai yang perlu dinilai.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Blok Penilaian Ketua Tim -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Perlu Dinilai: Ketua Tim ({{ $pendingKetuaTim->count() }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($pendingKetuaTim as $assignment)
                        <a href="{{ route('voting.show', $assignment->id) }}" class="...">
                            <p class="font-semibold">{{ $assignment->target->name }}</p>
                            <p class="text-sm text-gray-500">{{ $assignment->target->jabatan }}</p>
                        </a>
                        @empty
                        <p class="col-span-3">Tidak ada ketua tim yang perlu dinilai.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- DAFTAR YANG SUDAH DINILAI -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 opacity-60">
                    <h3 class="text-lg font-medium mb-4">Selesai Dinilai ({{ $completedAssignments->count() }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($completedAssignments as $assignment)
                        <div class="block p-4 bg-green-50 rounded-lg border border-green-200">
                            <p class="font-semibold text-gray-800">{{ $assignment->target->name }}</p>
                            <p class="text-sm text-gray-500">{{ $assignment->target->jabatan }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>