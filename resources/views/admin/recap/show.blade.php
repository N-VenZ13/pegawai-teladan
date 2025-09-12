<!-- resources/views/admin/recap/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rekapitulasi Penilaian (Periode: {{ $period->name }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">Hasil Akhir Penilaian</h3>
                        @if($period->status == 'finished')
                        @role('Pimpinan')
                        <form action="{{ route('recap.publish', $period->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin mempublikasikan hasil ini? Aksi ini tidak dapat dibatalkan.');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Publikasikan Hasil
                            </button>
                        </form>
                        @endrole
                        @else
                        <div class="px-4 py-2 bg-green-200 text-green-800 rounded-md text-sm font-semibold">
                            Hasil Sudah Dipublikasikan
                        </div>
                        @endif
                    </div>

                    <!-- resources/views/admin/recap/show.blade.php -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-3 px-4 ... text-center">Peringkat</th>
                                    <th class="py-3 px-4 ... text-left">Nama Pegawai</th>
                                    <th class="py-3 px-4 ... text-center">Nilai Rekan (10%)</th>
                                    <th class="py-3 px-4 ... text-center">Nilai Pimpinan (40%)</th>
                                    <th class="py-3 px-4 ... text-center">Nilai SKP (30%)</th>
                                    <th class="py-3 px-4 ... text-center">Nilai Disiplin (20%)</th> <!-- KOLOM BARU -->
                                    <th class="py-3 px-4 ... text-center bg-gray-300">Nilai Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse($recapData as $index => $data)
                                <tr class="hover:bg-gray-50 {{ $index < 3 ? 'bg-yellow-50' : '' }}">
                                    <td class="py-3 px-4 text-center font-bold">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-medium">{{ $data['user']->name }}</td>
                                    <td class="py-3 px-4 text-center">{{ $data['peer_score'] }}</td>
                                    <td class="py-3 px-4 text-center">{{ $data['leader_score'] }}</td>
                                    <td class="py-3 px-4 text-center">{{ $data['skp_score'] }}</td>
                                    <td class="py-3 px-4 text-center">{{ $data['discipline_score'] }}</td> <!-- DATA BARU -->
                                    <td class="py-3 px-4 text-center font-bold text-lg bg-gray-100">{{ $data['final_score'] }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-10 text-gray-500">Data penilaian belum lengkap untuk dapat direkapitulasi.</td> <!-- Colspan jadi 7 -->
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @role('Pimpinan')
                    <div class="mt-8 border-t pt-6">
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Unggah Dokumen Pendukung</h4>

                        <form action="{{ route('recap.upload_files', $period->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="sk_file" class="block font-medium text-sm text-gray-700">File SK (PDF, maks 2MB)</label>
                                    <input type="file" name="sk_file" id="sk_file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 mt-1">
                                    @if($period->sk_file_path)
                                    <p class="text-sm text-green-600 mt-2">File SK sudah terunggah. <a href="{{ Storage::url($period->sk_file_path) }}" target="_blank" class="underline">Lihat/Unduh</a></p>
                                    @endif
                                </div>
                                <div>
                                    <label for="sertifikat_file" class="block font-medium text-sm text-gray-700">File Sertifikat (PDF/JPG, maks 2MB)</label>
                                    <input type="file" name="sertifikat_file" id="sertifikat_file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 mt-1">
                                    @if($period->sertifikat_file_path)
                                    <p class="text-sm text-green-600 mt-2">File Sertifikat sudah terunggah. <a href="{{ Storage::url($period->sertifikat_file_path) }}" target="_blank" class="underline">Lihat/Unduh</a></p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Unggah File</button>
                            </div>
                        </form>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>