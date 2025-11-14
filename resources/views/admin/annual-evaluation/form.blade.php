<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Penilaian Pegawai Teladan Tahunan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- HEADER BAGIAN DAN FILTER TAHUN -->
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Daftar Kandidat Tahun {{ $year }}</h3>
                        
                        <!-- FORM FILTER TAHUN -->
                        <form method="GET" action="{{ route('annual-eval.form') }}" class="flex items-center space-x-2">
                            <label for="year" class="text-sm font-medium text-gray-700">Tahun:</label>
                            <select name="year" id="year" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1">
                                @for ($y = now()->year; $y >= 2024; $y--)
                                    <option value="{{ $y }}" @selected($y == $year)>{{ $y }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600">
                                Terapkan
                            </button>
                            <a href="{{ route('annual-eval.recap', ['year' => $year]) }}" class="inline-flex items-center px-3 py-1.5 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Lihat Peringkat
                            </a>
                        </form>
                    </div>

                    <!-- ALERT SUKSES -->
                    @if (session('success'))
                        <div class="bg-teal-100 border-l-4 border-brand-teal text-teal-800 p-4 rounded-md mb-4" role="alert">
                            <p class="font-bold">Sukses</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    <!-- FORM UTAMA DENGAN TABEL SKOR -->
                    <form method="POST" action="{{ route('annual-eval.store') }}">
                        @csrf
                        <input type="hidden" name="year" value="{{ $year }}">

                        <div class="overflow-x-auto border rounded-lg">
                            <table class="w-full">
                                <thead class="bg-brand-blue text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Kandidat</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jabatan</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-1/4">Skor Evaluasi Akhir</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($candidates as $candidate)
                                        <tr class="hover:bg-blue-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $candidate->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $candidate->jabatan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="number" name="scores[{{ $candidate->id }}]" min="0" max="100"
                                                       value="{{ $existingScores[$candidate->id] ?? '' }}"
                                                       class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                       placeholder="0-100">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-gray-500">
                                                Tidak ada kandidat (pemenang triwulanan) yang ditemukan untuk tahun {{ $year }}.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($candidates->isNotEmpty())
                            <div class="flex items-center mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                    Simpan Penilaian
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>