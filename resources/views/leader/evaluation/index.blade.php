<!-- resources/views/leader/evaluation/index.blade.php -->
<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Input Evaluasi Kepala BPS') }} (Periode: {{ $activePeriod->name }})</h2>
    </x-slot>
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
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Simpan Semua Perubahan</button>
                        </div>

                        <!-- ======================================= -->
                        <!--       TABEL UNTUK PEGAWAI BIASA       -->
                        <!-- ======================================= -->
                        <div class="mb-10">
                            <h4 class="text-lg font-semibold mb-2 text-gray-700">Penilaian Pegawai</h4>
                            <div class="overflow-x-auto border rounded-lg">
                                <table class="w-full table-fixed">
                                    <thead class="bg-gray-50 border-b">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Nama Pegawai</th>
                                            @foreach($criteriaForPegawai as $criterion)
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500">{{ $criterion->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($users->where('is_ketua_tim', false) as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                            @foreach($criteriaForPegawai as $criterion)
                                            <td class="px-6 py-4">
                                                <input type="" name="scores[{{ $user->id }}][{{ $criterion->id }}]" value="{{ $existingScores[$user->id . '-' . $criterion->id] ?? '' }}" class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0" max="100">
                                            </td>
                                            @endforeach
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="{{ $criteriaForPegawai->count() + 1 }}" class="text-center py-4 text-gray-500">Tidak ada data pegawai.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- ======================================= -->
                        <!--        TABEL UNTUK KETUA TIM          -->
                        <!-- ======================================= -->
                        <div>
                            <h4 class="text-lg font-semibold mb-2 text-gray-700">Penilaian Ketua Tim</h4>
                            <div class="overflow-x-auto border rounded-lg">
                                <table class="w-full table-fixed">
                                    <thead class="bg-gray-50 border-b">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500">Nama Ketua Tim</th>
                                            @foreach($criteriaForKetuaTim as $criterion)
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500">{{ $criterion->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($users->where('is_ketua_tim', true) as $user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                            @foreach($criteriaForKetuaTim as $criterion)
                                            <td class="px-6 py-4">
                                                <input type="" name="scores[{{ $user->id }}][{{ $criterion->id }}]" value="{{ $existingScores[$user->id . '-' . $criterion->id] ?? '' }}" class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0" max="100">
                                            </td>
                                            @endforeach
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="{{ $criteriaForKetuaTim->count() + 1 }}" class="text-center py-4 text-gray-500">Tidak ada data ketua tim.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</x-main-layout>