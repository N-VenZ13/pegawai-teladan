<!-- resources/views/admin/assignments/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tugas Penilaian untuk Periode: {{ $period->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Daftar Tugas</h3>
                        <form action="{{ route('admin.assignments.generate', $period->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin? Ini akan menghapus dan membuat ulang semua tugas penilaian untuk periode ini.');">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Generate / Re-generate Tugas
                            </button>
                        </form>
                    </div>

                    <!-- Tabel untuk menampilkan daftar assignment -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Penilai (Voter)</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Target Penilaian</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse ($assignments as $assignment)
                                <tr>
                                    <td class="py-3 px-4">{{ $assignment->voter->name ?? 'User Dihapus' }}</td>
                                    <td class="py-3 px-4">{{ $assignment->target->name ?? 'User Dihapus' }}</td>
                                    <td class="py-3 px-4 text-center">
                                        @if ($assignment->status == 'completed')
                                        <span class="bg-green-200 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
                                        @else
                                        <span class="bg-yellow-200 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-6">
                                        <p class="text-gray-500">Belum ada tugas penilaian untuk periode ini.</p>
                                        <p class="text-gray-400 text-sm mt-1">Silakan klik tombol "Generate Tugas" untuk memulai.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>