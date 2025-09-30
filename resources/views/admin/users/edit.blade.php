<!-- resources/views/admin/users/edit.blade.php -->

<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User: ') }} {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block font-medium text-sm text-gray-700">Username</label>
                                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>
                            </div>

                            <!-- NIP -->
                            <div>
                                <label for="nip" class="block font-medium text-sm text-gray-700">NIP</label>
                                <input type="text" name="nip" id="nip" value="{{ old('nip', $user->nip) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ...">
                            </div>

                            <!-- Jabatan -->
                            <div>
                                <label for="jabatan" class="block font-medium text-sm text-gray-700">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $user->jabatan) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ...">
                            </div>

                            <!-- Password (Opsional) -->
                            <div>
                                <label for="password" class="block font-medium text-sm text-gray-700">Password Baru (kosongkan jika tidak diubah)</label>
                                <input type="password" name="password" id="password" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ...">
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ...">
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block font-medium text-sm text-gray-700">Role</label>
                                <select name="role" id="role" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>
                                    @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Checkbox Ketua Tim -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_ketua_tim" id="is_ketua_tim" value="1" {{ $user->is_ketua_tim ? 'checked' : '' }} class="rounded border-gray-300 ...">
                                <label for="is_ketua_tim" class="ml-2 block text-sm text-gray-900">
                                    Ketua Tim
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-4">
                                Batal
                            </a>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>