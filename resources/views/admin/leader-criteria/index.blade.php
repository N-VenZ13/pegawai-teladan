<!-- resources/views/admin/leader-criteria/index.blade.php -->
<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kriteria Pimpinan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.leader-criteria.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 ...">
                            + Tambah Kriteria
                        </a>
                    </div>

                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="w-1/2 py-3 px-4 uppercase font-semibold text-sm text-left">Nama Kriteria</th>
                                    <th class="w-1/2 py-3 px-4 uppercase font-semibold text-sm text-left">Deskripsi</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Status</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse ($criteria as $criterion)
                                <tr>
                                    <td class="py-3 px-4">{{ $criterion->name }}</td>
                                    <td class="py-3 px-4">{{ $criterion->description }}</td>
                                    <td class="py-3 px-4 text-center">
                                        @if($criterion->is_active)
                                        <span class="bg-green-200 ...">Aktif</span>
                                        @else
                                        <span class="bg-gray-200 ...">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex item-center justify-center">
                                            <a href="{{ route('admin.leader-criteria.edit', $criterion->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <!-- SVG Edit Icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.leader-criteria.destroy', $criterion->id) }}" method="POST" onsubmit="return confirm('Yakin?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110 cursor-pointer">
                                                    <!-- SVG Delete Icon -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">Tidak ada data kriteria.</td>
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