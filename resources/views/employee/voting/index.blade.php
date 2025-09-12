<!-- resources/views/employee/voting/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tugas Penilaian Anda (Periode: {{ $activePeriod->name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- DAFTAR YANG HARUS DINILAI -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Perlu Dinilai ({{ $pendingAssignments->count() }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($pendingAssignments as $assignment)
                        <a href="{{ route('voting.show', $assignment->id) }}" class="block p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-indigo-50 hover:border-indigo-400 transition">
                            <p class="font-semibold text-gray-800">{{ $assignment->target->name }}</p>
                            <p class="text-sm text-gray-500">{{ $assignment->target->jabatan }}</p>
                        </a>
                        @empty
                        <p class="text-gray-500 col-span-3">Hebat! Anda sudah menyelesaikan semua tugas penilaian.</p>
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
</x-app-layout>