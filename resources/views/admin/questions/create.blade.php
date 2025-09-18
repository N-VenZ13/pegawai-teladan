<!-- resources/views/admin/questions/create.blade.php -->
<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pertanyaan Pegawai Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                    <!-- ... (Error Handling) ... -->
                    <div class="mb-4">
                        <div class="font-medium text-red-600">Terjadi kesalahan:</div>
                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    

                    <form id="create-form" action="{{ route('admin.questions.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="text" class="block text-sm font-medium text-gray-700">Isi Pertanyaan</label>
                                <textarea name="text" id="text" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('text') }}</textarea>
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Pertanyaan</label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="pegawai">Untuk Penilaian Pegawai</option>
                                    <option value="ketua_tim">Untuk Penilaian Ketua Tim</option>
                                </select>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" checked class="h-4 w-4 text-brand-blue rounded border-gray-300 focus:ring-brand-blue">
                                <label for="is_active" class="ms-2 block text-sm text-gray-900">Aktifkan pertanyaan ini</label>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 border-t pt-6">
                            <a href="{{ route('admin.questions.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 me-4">
                                Batal
                            </a>
                            <button id="submit-button" type="submit" class="inline-flex items-center px-4 py-2 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Skrip untuk mencegah double submit -->
    @push('scripts')
    <script>
        document.getElementById('create-form').addEventListener('submit', function() {
            var submitButton = document.getElementById('submit-button');
            submitButton.disabled = true;
            submitButton.innerText = 'Menyimpan...';
        });
    </script>
    @endpush
</x-main-layout>