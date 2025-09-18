<!-- resources/views/admin/skp/index.blade.php -->
<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Input Nilai SKP') }} (Periode: {{ $activePeriod->name }})</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ... (Notifikasi sukses/error) ... -->
                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                    @endif
                    <form action="{{ route('skp.store') }}" method="POST">
                        @csrf
                        <div class="text-right mb-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Simpan Semua Nilai SKP</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama Pegawai</th>

                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai {{ $activePeriod->month_1_name ?? 'Bulan 1' }}</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai {{ $activePeriod->month_2_name ?? 'Bulan 2' }}</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai {{ $activePeriod->month_3_name ?? 'Bulan 3' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 font-medium @if(!$loop->last) border-r @endif">{{ $user->name }}</td>
                                        @php
                                        // Ambil skor user ini dari collection, atau buat objek kosong jika belum ada
                                        $userScore = $existingScores->get($user->id);
                                        @endphp
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 @if(!$loop->last) border-r @endif">
                                            <input type="" min="0" max="100"
                                                name="scores[{{ $user->id }}][month_1]"
                                                value="{{ old('scores.'.$user->id.'.month_1', $userScore->month_1_score ?? '') }}"
                                                class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 @if(!$loop->last) border-r @endif">
                                            <input type="" min="0" max="100"
                                                name="scores[{{ $user->id }}][month_2]"
                                                value="{{ old('scores.'.$user->id.'.month_2', $userScore->month_2_score ?? '') }}"
                                                class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 @if(!$loop->last) border-r @endif">
                                            <input type="" min="0" max="100"
                                                name="scores[{{ $user->id }}][month_3]"
                                                value="{{ old('scores.'.$user->id.'.month_3', $userScore->month_3_score ?? '') }}"
                                                class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>