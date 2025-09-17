<x-main-layout>
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

                    <!-- Tabs untuk memisahkan hasil -->
                    <div class="mb-4 border-b border-gray-200">
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="pegawai-tab" data-tabs-target="#pegawai" type="button" role="tab" aria-controls="pegawai" aria-selected="true">Pegawai Teladan</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="ketua-tim-tab" data-tabs-target="#ketua-tim" type="button" role="tab" aria-controls="ketua-tim" aria-selected="false">Ketua Tim Teladan</button>
                            </li>
                        </ul>
                    </div>
                    <div id="myTabContent">
                        <!-- Konten Tab Pegawai Teladan -->
                        <div class="hidden p-4 rounded-lg bg-gray-50" id="pegawai" role="tabpanel" aria-labelledby="pegawai-tab">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Peringkat Pegawai Teladan</h3>
                            <table class="min-w-full bg-white border">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Peringkat</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama Pegawai</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai Rekan (10%)</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai Kepala BPS (40%)</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai SKP (30%)</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai Disiplin (20%)</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center bg-gray-300">Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recapPegawai as $index => $data)
                                    <tr class="hover:bg-gray-50 {{ $index < 3 ? 'bg-yellow-50' : '' }}">
                                        <td class="py-3 px-4 text-center font-bold">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 font-medium">{{ $data['user']->name }}</td>
                                        <td class="py-3 px-4 text-center">{{ $data['peer_score'] }}</td>
                                        <td class="py-3 px-4 text-center">{{ $data['leader_score'] }}</td>
                                        <td class="py-3 px-4 text-center">{{ $data['skp_score'] }}</td>
                                        <td class="py-3 px-4 text-center">{{ $data['discipline_score'] }}</td>
                                        <td class="py-3 px-4 text-center font-bold text-lg bg-gray-100">{{ $data['final_score'] }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-6">Data penilaian pegawai belum tersedia atau belum lengkap.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Konten Tab Ketua Tim Teladan -->
                        <div class="hidden p-4 rounded-lg bg-gray-50" id="ketua-tim" role="tabpanel" aria-labelledby="ketua-tim-tab">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Peringkat Ketua Tim Teladan</h3>
                            <table class="min-w-full bg-white border">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Peringkat</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama Ketua Tim</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai Rekan (10%)</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai Kepala BPS (40%)</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai SKP (30%)</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">Nilai Disiplin (20%)</th>
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center bg-gray-300">Nilai Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recapKetuaTim as $index => $data)
                                    <tr class="hover:bg-gray-50 {{ $index < 3 ? 'bg-yellow-50' : '' }}">
                                        <td class="py-3 px-4 text-center font-bold">{{ $index + 1 }}</td>
                                        <td class="py-3 px-4 font-medium">{{ $data['user']->name }}</td>
                                        <td class="py-3 px-4 text-center">{{ $data['peer_score'] }}</td>
                                        <td class="py-3 px-4 text-center">{{ $data['leader_score'] }}</td>
                                        <td class="py-3 px-4 text-center">{{ $data['skp_score'] }}</td>
                                        <td class="py-3 px-4 text-center">{{ $data['discipline_score'] }}</td>
                                        <td class="py-3 px-4 text-center font-bold text-lg bg-gray-100">{{ $data['final_score'] }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-6">Data penilaian ketua tim belum tersedia atau belum lengkap.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Aksi Publikasi & Upload -->
                    <div class="mt-8 border-t pt-6">
                        <div class="flex justify-end mb-6">
                            @if($period->status == 'finished')
                            @role('Kepala BPS')
                            <form action="{{ route('recap.publish', $period->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin mempublikasikan hasil ini? Aksi ini tidak dapat dibatalkan.');">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">Publikasikan Hasil</button>
                            </form>
                            @endrole
                            @else
                            <span class="px-4 py-2 bg-green-200 text-green-800 rounded-md text-sm font-semibold">Hasil Sudah Dipublikasikan</span>
                            @endif
                        </div>

                        @role('Kepala BPS')
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 mb-4">Unggah Dokumen Pendukung</h4>
                            <form action="{{ route('recap.upload_files', $period->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Kolom Pegawai -->
                                    <div class="space-y-4 p-4 border rounded-lg">
                                        <h5 class="font-semibold">Dokumen Pegawai Teladan</h5>
                                        <div>
                                            <label for="sk_pegawai" class="block text-sm font-medium text-gray-700">File SK Pegawai (PDF)</label>
                                            <input type="file" name="sk_pegawai" id="sk_pegawai" class="mt-1 block w-full text-sm ...">
                                            @if($period->sk_pegawai_path)
                                            <p class="text-sm text-green-600 mt-2">Terunggah: <a href="{{ Storage::url($period->sk_pegawai_path) }}" target="_blank" class="underline">Lihat/Unduh</a></p>
                                            @endif
                                        </div>
                                        <div>
                                            <label for="sertifikat_pegawai" class="block text-sm font-medium text-gray-700">Sertifikat Pegawai (PDF/JPG)</label>
                                            <input type="file" name="sertifikat_pegawai" id="sertifikat_pegawai" class="mt-1 block w-full text-sm ...">
                                            @if($period->sertifikat_pegawai_path)
                                            <p class="text-sm text-green-600 mt-2">Terunggah: <a href="{{ Storage::url($period->sertifikat_pegawai_path) }}" target="_blank" class="underline">Lihat/Unduh</a></p>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Kolom Ketua Tim -->
                                    <div class="space-y-4 p-4 border rounded-lg">
                                        <h5 class="font-semibold">Dokumen Ketua Tim Teladan</h5>
                                        <div>
                                            <label for="sk_ketua_tim" class="block text-sm font-medium text-gray-700">File SK Ketua Tim (PDF)</label>
                                            <input type="file" name="sk_ketua_tim" id="sk_ketua_tim" class="mt-1 block w-full text-sm ...">
                                            @if($period->sk_ketua_tim_path)
                                            <p class="text-sm text-green-600 mt-2">Terunggah: <a href="{{ Storage::url($period->sk_ketua_tim_path) }}" target="_blank" class="underline">Lihat/Unduh</a></p>
                                            @endif
                                        </div>
                                        <div>
                                            <label for="sertifikat_ketua_tim" class="block text-sm font-medium text-gray-700">Sertifikat Ketua Tim (PDF/JPG)</label>
                                            <input type="file" name="sertifikat_ketua_tim" id="sertifikat_ketua_tim" class="mt-1 block w-full text-sm ...">
                                            @if($period->sertifikat_ketua_tim_path)
                                            <p class="text-sm text-green-600 mt-2">Terunggah: <a href="{{ Storage::url($period->sertifikat_ketua_tim_path) }}" target="_blank" class="underline">Lihat/Unduh</a></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-blue ...">Unggah File</button>
                                </div>
                            </form>
                        </div>
                        @endrole
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initFlowbite();
        });
    </script>
    @endpush
</x-main-layout>