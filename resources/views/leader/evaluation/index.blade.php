<!-- resources/views/leader/evaluation/index.blade.php -->
<x-main-layout>
    <x-slot name="header">...</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('leader.evaluation.store') }}" method="POST">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
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
                        <!-- AKHIR BLOK -->

                        <!-- Tombol simpan di atas -->
                        <div class="text-right mb-4">
                            <button type="submit" class="...">Simpan Semua Perubahan</button>
                        </div>

                        <div class="space-y-8">
                            @foreach ($users as $user)
                            <div class="border rounded-lg p-4">
                                <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500 mb-4">
                                    {{ $user->jabatan }}
                                    @if($user->is_ketua_tim)
                                    <span class="ml-2 font-bold text-xs text-purple-800 bg-purple-200 px-2 py-1 rounded-full">Ketua Tim</span>
                                    @endif
                                </p>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    {{-- Tentukan set kriteria mana yang akan digunakan --}}
                                    @php
                                    $criteriaToUse = $user->is_ketua_tim ? $criteriaForKetuaTim : $criteriaForPegawai;
                                    @endphp

                                    @foreach($criteriaToUse as $criterion)
                                    <div>
                                        <label for="score_{{ $user->id }}_{{ $criterion->id }}" class="block text-sm font-medium text-gray-700">
                                            {{ $criterion->name }}
                                        </label>
                                        <input type="number"
                                            name="scores[{{ $user->id }}][{{ $criterion->id }}]"
                                            id="score_{{ $user->id }}_{{ $criterion->id }}"
                                            value="{{ $existingScores[$user->id . '-' . $criterion->id] ?? '' }}"
                                            class="mt-1 block w-full rounded-md ..."
                                            min="0" max="100">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>