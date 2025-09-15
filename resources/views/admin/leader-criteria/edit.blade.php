<!-- resources/views/admin/leader-criteria/edit.blade.php -->
<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.leader-criteria.update', $criterion->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Kriteria</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $criterion->name) }}" class="mt-1 block w-full ..." required>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                                <textarea name="description" id="description" rows="3" class="mt-1 block w-full ...">{{ old('description', $criterion->description) }}</textarea>
                            </div>
                            <div>
                                <label for="target_type" class="block text-sm font-medium text-gray-700">
                                    Kriteria ini untuk menilai siapa?
                                </label>
                                <select name="target_type" id="target_type" class="mt-1 block w-full rounded-md ...">
                                    <option value="pegawai" @selected(old('target_type', $criterion->target_type ?? '') == 'pegawai')>
                                        Pegawai
                                    </option>
                                    <option value="ketua_tim" @selected(old('target_type', $criterion->target_type ?? '') == 'ketua_tim')>
                                        Ketua Tim
                                    </option>
                                    <option value="semua" @selected(old('target_type', $criterion->target_type ?? '') == 'semua')>
                                        Semua (Pegawai & Ketua Tim)
                                    </option>
                                </select>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $criterion->is_active)) class="h-4 w-4 ...">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktifkan kriteria ini</label>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.leader-criteria.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-4">
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