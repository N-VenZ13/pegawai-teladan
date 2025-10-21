<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manajemen Periode') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Daftar Periode Penilaian</h3>
                        <a href="{{ route('admin.periods.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            + Tambah Periode
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-teal-100 border-l-4 border-brand-teal text-teal-800 p-4 rounded-md mb-4" role="alert">
                            <p class="font-bold">Sukses</p><p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <div class="overflow-x-auto border rounded-lg">
                        <table class="w-full">
                            <thead class="bg-brand-blue text-white">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Periode</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal Mulai</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal Selesai</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Progres</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($periods as $period)
                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $period->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($period->start_date)->isoFormat('D MMMM Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($period->end_date)->isoFormat('D MMMM Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusClass = '';
                                            if ($period->status == 'draft') $statusClass = 'bg-gray-100 text-gray-800';
                                            elseif ($period->status == 'active') $statusClass = 'bg-green-100 text-green-800';
                                            elseif ($period->status == 'finished') $statusClass = 'bg-blue-100 text-blue-800';
                                            elseif ($period->status == 'published') $statusClass = 'bg-purple-100 text-purple-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst($period->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 text-center">
                                        <a href="{{ route('monitoring.show', $period->id) }}" class="hover:underline">
                                            Lihat Progres ({{ $period->assignments_count }})
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="{{ route('admin.periods.edit', $period->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                            </a>
                                            <form action="{{ route('admin.periods.destroy', $period->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus periode ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-4 mr-2 transform hover:text-brand-rose hover:scale-110 cursor-pointer" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data periode.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $periods->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>