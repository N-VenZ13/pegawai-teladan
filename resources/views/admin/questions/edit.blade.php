<!-- resources/views/admin/questions/edit.blade.php -->

<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pertanyaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg-px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <!-- ... (blok error handling sama seperti create) ... -->
                    @endif

                    <!-- Perbedaan #1: Action form mengarah ke route 'update' -->
                    <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                        @csrf
                        <!-- Perbedaan #2: Tambahkan method PUT -->
                        @method('PUT')

                        <!-- Isi Pertanyaan -->
                        <div>
                            <label for="text" class="block font-medium text-sm text-gray-700">Isi Pertanyaan</label>
                            <!-- Perbedaan #3: Isi textarea dengan data lama -->
                            <textarea name="text" id="text" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>{{ old('text', $question->text) }}</textarea>
                        </div>

                        <!-- Tipe Pertanyaan -->
                        <div class="mt-4">
                            <label for="type" class="block font-medium text-sm text-gray-700">Tipe Pertanyaan</label>
                            <!-- Perbedaan #3: Pilih option yang sesuai dengan data lama -->
                            <select name="type" id="type" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>
                                <option value="pegawai" @selected(old('type', $question->type) == 'pegawai')>
                                    Untuk Penilaian Pegawai
                                </option>
                                <option value="ketua_tim" @selected(old('type', $question->type) == 'ketua_tim')>
                                    Untuk Penilaian Ketua Tim
                                </option>
                            </select>
                        </div>

                        <!-- Status Aktif -->
                        <div class="flex items-center mt-4">
                            <!-- Perbedaan #3: Centang checkbox jika data lama is_active = true -->
                            <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', $question->is_active))>
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktifkan pertanyaan ini</label>
                        </div>

                        <!-- Tombol Simpan & Batal (sama persis dengan create) -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.questions.index') }}" class="... mr-4">
                                Batal
                            </a>
                            <button type="submit" class="...">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-main-layout>