<!-- resources/views/admin/periods/index.blade.php -->

<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Periode') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- <div class="mb-4 text-right">
                        <a href="{{ route('admin.periods.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Tambah Periode
                        </a>
                    </div> -->

                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.periods.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Tambah Periode
                        </a>
                    </div>

                    <!-- Notifikasi Sukses -->
                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <!-- Notifikasi Error (jika ada) -->
                    @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif


                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama Periode</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Tanggal Mulai</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Tanggal Selesai</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Status</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse ($periods as $period)
                                <tr>
                                    <td class="py-3 px-4">{{ $period->name }}</td>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($period->start_date)->isoFormat('D MMMM Y') }}</td>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($period->end_date)->isoFormat('D MMMM Y') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        {{-- Logika untuk warna status --}}
                                        @php
                                        $statusClass = '';
                                        if ($period->status == 'draft') $statusClass = 'bg-gray-200 text-gray-800';
                                        elseif ($period->status == 'active') $statusClass = 'bg-green-200 text-green-800';
                                        elseif ($period->status == 'finished') $statusClass = 'bg-blue-200 text-blue-800';
                                        elseif ($period->status == 'published') $statusClass = 'bg-purple-200 text-purple-800';
                                        @endphp
                                        <span class="text-xs font-medium px-2.5 py-0.5 rounded {{ $statusClass }}">
                                            {{ ucfirst($period->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="{{ route('admin.periods.edit', $period->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.periods.destroy', $period->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus periode ini? Semua data penilaian terkait akan ikut terhapus!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110 cursor-pointer">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <td class="py-3 px-4 text-center">
                                    <a href="{{ route('admin.assignments.index', $period->id) }}" class="text-blue-500 hover:underline">
                                        Lihat ({{ $period->assignments_count }})
                                    </a>
                                </td>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada data periode.</td>
                                </tr>
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