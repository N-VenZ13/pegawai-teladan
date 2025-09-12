<!-- resources/views/admin/periods/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pertanyaan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Menampilkan Error Validasi -->
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

                    <form action="{{ route('admin.questions.store') }}" method="POST">
                        @csrf
                        <!-- Isi Pertanyaan -->
                        <div>
                            <label for="text">Isi Pertanyaan</label>
                            <textarea name="text" id="text" rows="3" class="..."></textarea>
                        </div>

                        <!-- Tipe Pertanyaan -->
                        <div>
                            <label for="type">Tipe Pertanyaan</label>
                            <select name="type" id="type" class="..." required>
                                <option value="pegawai">Untuk Penilaian Pegawai</option>
                                <option value="ketua_tim">Untuk Penilaian Ketua Tim</option>
                            </select>
                        </div>

                        <!-- Status Aktif -->
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label for="is_active" class="ml-2">Aktifkan pertanyaan ini</label>
                        </div>

                        <!-- Tombol Simpan & Batal -->
                        <!-- Tombol Aksi -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.questions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-4">
                                Batal
                            </a>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>