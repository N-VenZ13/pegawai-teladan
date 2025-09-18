<!-- resources/views/admin/periods/edit.blade.php -->

<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Periode: ') }} {{ $period->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                    <!-- ... (blok error handling) ... -->
                    @endif

                    <form action="{{ route('admin.periods.update', $period->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Nama Periode -->
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700">Nama Periode</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $period->name) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div>
                                <label for="start_date" class="block font-medium text-sm text-gray-700">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $period->start_date) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>
                            </div>

                            <!-- Tanggal Selesai -->
                            <div>
                                <label for="end_date" class="block font-medium text-sm text-gray-700">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $period->end_date) }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>
                            </div>

                            <div>
                                <label for="month_1_name">Nama Bulan 1 (untuk Label SKP)</label>
                                <input type="text" name="month_1_name" value="{{ old('month_1_name', $period->month_1_name ?? '') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Contoh: Juli">
                            </div>
                            <div>
                                <label for="month_2_name">Nama Bulan 2 (untuk Label SKP)</label>
                                <input type="text" name="month_2_name" value="{{ old('month_2_name', $period->month_2_name ?? '') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Contoh: Agustus">
                            </div>
                            <div>
                                <label for="month_3_name">Nama Bulan 3 (untuk Label SKP)</label>
                                <input type="text" name="month_3_name" value="{{ old('month_3_name', $period->month_3_name ?? '') }}" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Contoh: September">
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                                <select name="status" id="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 ..." required>
                                    <option value="draft" @selected(old('status', $period->status) == 'draft')>Draft</option>
                                    <option value="active" @selected(old('status', $period->status) == 'active')>Aktif</option>
                                    <option value="finished" @selected(old('status', $period->status) == 'finished')>Selesai</option>
                                    <option value="published" @selected(old('status', $period->status) == 'published')>Dipublikasi</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.periods.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-4">
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
</x-main-layout>