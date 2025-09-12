<!-- resources/views/admin/skp/index.blade.php -->
<x-app-layout>
    <x-slot name="header">...</x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- ... (Notifikasi sukses/error) ... -->
                    <form action="{{ route('skp.store') }}" method="POST">
                        @csrf
                        <div class="text-right mb-4">
                            <button type="submit" class="...">Simpan Semua Nilai SKP</button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-3 px-4 ... text-left">Nama Pegawai</th>
                                        
                                        <th class="...">Nilai {{ $activePeriod->month_1_name ?? 'Bulan 1' }}</th>
                                        <th class="...">Nilai {{ $activePeriod->month_2_name ?? 'Bulan 2' }}</th>
                                        <th class="...">Nilai {{ $activePeriod->month_3_name ?? 'Bulan 3' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td class="py-3 px-4">{{ $user->name }}</td>
                                        @php
                                        // Ambil skor user ini dari collection, atau buat objek kosong jika belum ada
                                        $userScore = $existingScores->get($user->id);
                                        @endphp
                                        <td>
                                            <input type="number" step="0.01" min="0" max="100"
                                                name="scores[{{ $user->id }}][month_1]"
                                                value="{{ old('scores.'.$user->id.'.month_1', $userScore->month_1_score ?? '') }}"
                                                class="w-full rounded-md ...">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" min="0" max="100"
                                                name="scores[{{ $user->id }}][month_2]"
                                                value="{{ old('scores.'.$user->id.'.month_2', $userScore->month_2_score ?? '') }}"
                                                class="w-full rounded-md ...">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" min="0" max="100"
                                                name="scores[{{ $user->id }}][month_3]"
                                                value="{{ old('scores.'.$user->id.'.month_3', $userScore->month_3_score ?? '') }}"
                                                class="w-full rounded-md ...">
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
</x-app-layout>