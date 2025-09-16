<!-- resources/views/leader/evaluation/index.blade.php -->
<x-main-layout>
    <x-slot name="header">...</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('leader.evaluation.store') }}" method="POST">
                @csrf
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
                        <div class="text-right mb-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-blue ...">Simpan Semua Perubahan</button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama Pegawai</th>
                                        <!-- Loop untuk membuat header kriteria dinamis -->
                                        @foreach($criteriaForPegawai as $criterion) {{-- Kita ambil satu set kriteria sebagai sampel header --}}
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center w-32">{{ $criterion->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 font-medium">
                                            {{ $user->name }}
                                            @if($user->is_ketua_tim)
                                            <span class="ml-2 text-xs font-bold text-purple-800 bg-purple-200 px-2 py-1 rounded-full">Ketua Tim</span>
                                            @endif
                                        </td>

                                        @php
                                        $criteriaToUse = $user->is_ketua_tim ? $criteriaForKetuaTim : $criteriaForPegawai;
                                        @endphp

                                        @foreach($criteriaToUse as $criterion)
                                        <td class="py-3 px-4">
                                            <input type="number"
                                                name="scores[{{ $user->id }}][{{ $criterion->id }}]"
                                                value="{{ $existingScores[$user->id . '-' . $criterion->id] ?? '' }}"
                                                class="w-full text-center rounded-md border-gray-300 ..."
                                                min="0" max="100">
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>