<!-- resources/views/employee/results/show.blade.php -->
<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hasil Akhir Penilaian (Periode: {{ $period->name }})
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 text-center">🏆 Peringkat Pegawai Teladan 🏆</h3>
                    <p class="text-center text-gray-500 mb-6">Berikut adalah hasil akhir resmi yang telah dipublikasikan.</p>

                    <!-- ======================================================= -->
                    <!--     INI DIA BAGIAN UNTUK DOWNLOAD FILE-NYA              -->
                    <!-- ======================================================= -->
                    @if($period->sk_file_path || $period->sertifikat_file_path)
                    <div class="mb-6 p-4 bg-gray-50 rounded-md border text-center">
                        <h4 class="font-semibold mb-2">Dokumen Resmi</h4>
                        @if($period->sk_file_path)
                        <a href="{{ Storage::url($period->sk_file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Unduh SK
                        </a>
                        @endif
                        @if($period->sertifikat_file_path)
                        <a href="{{ Storage::url($period->sertifikat_file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                            Unduh Sertifikat
                        </a>
                        @endif
                    </div>
                    @endif
                    <!-- ======================================================= -->

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Peringkat</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-center bg-gray-300">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recapData as $index => $data)
                                <tr class="hover:bg-gray-50 {{ $index < 3 ? 'bg-yellow-50' : '' }}">
                                    <td class="py-3 px-4 text-center font-bold">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-medium">{{ $data['user']->name }}</td>
                                    <td class="py-3 px-4 text-center font-bold text-lg bg-gray-100">{{ $data['final_score'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>