<!-- resources/views/admin/users/index.blade.php -->

<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4 text-right">
                        <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah User
                        </a>
                    </div>

                    <!-- Notifikasi Sukses -->
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
                                    <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                                    <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Email</th>
                                    <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">NIP</th>
                                    <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Role</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse ($users as $user)
                                <tr>
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4">{{ $user->email }}</td>
                                    <td class="py-3 px-4">{{ $user->nip ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $role)
                                        <span class="bg-indigo-200 text-indigo-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">{{ $role }}</span>
                                        @endforeach
                                        @endif
                                    </td>
                                    <!-- <td class="py-3 px-4">
                                        <a href="{{-- route('admin.users.edit', $user->id) --}}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                        <a href="#" class="text-red-500 hover:text-red-700 ml-4">Hapus</a>
                                    </td> -->
                                    <td class="py-3 px-4 flex items-center">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" class="inline-block ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada data user.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }} <!-- Ini untuk menampilkan navigasi halaman -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-main-layout>