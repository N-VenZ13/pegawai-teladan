<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Monitoring Progres Penilaian (Periode: {{ $period->name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Sukses!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-4 gap-4">
                       <h3 class="text-lg font-medium text-gray-800">Progres Penilaian per Pegawai</h3>
                       <!-- Tombol Generate tetap di sini untuk kemudahan -->
                       <form action="{{ route('admin.assignments.generate', $period->id) }}" method="POST" onsubmit="return confirm('Yakin? Ini akan menghapus dan membuat ulang semua tugas.');">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Generate / Re-generate Tugas
                            </button>
                        </form>
                    </div>

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="w-1/3 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penilai</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Progres</th>
                                    <th class="w-1/2 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Bar Penilaian</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($monitoringData as $data)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $data->user->name }}
                                        <p class="text-xs text-gray-500">{{ $data->user->jabatan }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        <span class="font-semibold">{{ $data->completed }} / {{ $data->total }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="w-full bg-gray-200 rounded-full h-5">
                                            <div class="bg-brand-blue h-5 rounded-full flex items-center justify-center text-white text-xs font-bold" 
                                                 @style(['width' => $data->percentage . '%'])>
                                                {{ $data->percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-10 text-gray-500">
                                        <p>Belum ada tugas penilaian yang di-generate untuk periode ini.</p>
                                        <p class="text-sm mt-1">Silakan klik tombol "Generate / Re-generate Tugas" untuk memulai.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>