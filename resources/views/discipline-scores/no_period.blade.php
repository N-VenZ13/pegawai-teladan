<!-- resources/views/admin/discipline-scores/no_period.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Nilai SKP') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h3 class="text-lg font-medium text-gray-800">Tidak Ada Periode Penilaian yang Sedang Aktif</h3>
                    <p class="text-gray-500 mt-2">Halaman ini hanya bisa digunakan saat ada periode penilaian dengan status "Aktif".</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>