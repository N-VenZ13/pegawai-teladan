<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hasil Akhir Penilaian (Periode: {{ $period->name }})
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            <!-- ======================================= -->
            <!--    BAGIAN PODIUM PEGAWAI TELADAN        -->
            <!-- ======================================= -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">🏆 Peringkat Pegawai Teladan 🏆</h3>

                    @if($recapPegawai->count() >= 3)
                    @php
                    $juara1 = $recapPegawai->get(0);
                    $juara2 = $recapPegawai->get(1);
                    $juara3 = $recapPegawai->get(2);
                    @endphp

                    <div class="flex items-end justify-center gap-4 md:gap-8 text-center">
                        <!-- Juara 2 -->
                        <div class="w-1/3">
                            <img src="{{ $juara2['user']->profile_photo_path ? Storage::url($juara2['user']->profile_photo_path) : asset('images/default-avatar.png') }}" class="w-24 h-24 md:w-32 md:h-32 mx-auto rounded-full object-cover border-4 border-gray-300">
                            <h4 class="mt-4 font-bold text-lg text-gray-800">{{ $juara2['user']->name }}</h4>
                            <div class="bg-gray-300 text-gray-800 p-4 md:p-6 rounded-t-lg mt-2 h-24 md:h-32 flex flex-col justify-center">
                                <span class="text-4xl md:text-5xl font-bold">2</span>
                                <span class="font-semibold">{{ $juara2['final_score'] }} Poin</span>
                            </div>
                        </div>

                        <!-- Juara 1 -->
                        <div class="w-1/3">
                            <img src="{{ $juara1['user']->profile_photo_path ? Storage::url($juara1['user']->profile_photo_path) : asset('images/default-avatar.png') }}" class="w-28 h-28 md:w-40 md:h-40 mx-auto rounded-full object-cover border-4 border-yellow-400">
                            <h4 class="mt-4 font-bold text-xl text-yellow-600">{{ $juara1['user']->name }} 👑</h4>
                            <div class="bg-yellow-400 text-white p-4 md:p-6 rounded-t-lg mt-2 h-32 md:h-48 flex flex-col justify-center">
                                <span class="text-5xl md:text-6xl font-bold">1</span>
                                <span class="font-semibold">{{ $juara1['final_score'] }} Poin</span>
                            </div>
                        </div>

                        <!-- Juara 3 -->
                        <div class="w-1/3">
                            <img src="{{ $juara3['user']->profile_photo_path ? Storage::url($juara3['user']->profile_photo_path) : asset('images/default-avatar.png') }}" class="w-24 h-24 md:w-32 md:h-32 mx-auto rounded-full object-cover border-4 border-yellow-600">
                            <h4 class="mt-4 font-bold text-lg text-gray-800">{{ $juara3['user']->name }}</h4>
                            <div class="bg-yellow-600 text-white p-4 md:p-6 rounded-t-lg mt-2 h-20 md:h-24 flex flex-col justify-center">
                                <span class="text-3xl md:text-4xl font-bold">3</span>
                                <span class="font-semibold">{{ $juara3['final_score'] }} Poin</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <p class="text-center text-gray-500 py-10">Data tidak cukup untuk menampilkan peringkat 3 besar.</p>
                    @endif
                </div>
            </div>

            <!-- ======================================= -->
            <!--    BAGIAN PODIUM KETUA TIM TELADAN      -->
            <!-- ======================================= -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">🏆 Peringkat Ketua Tim Teladan 🏆</h3>

                    @if($recapKetuaTim->count() >= 1)
                    @php
                    $juaraKt1 = $recapKetuaTim->first();
                    @endphp

                    <!-- Tampilan Juara 1 Ketua Tim -->
                    <div class="w-full md:w-1/2 mx-auto text-center">
                        <img src="{{ $juaraKt1['user']->profile_photo_path ? Storage::url($juaraKt1['user']->profile_photo_path) : asset('images/default-avatar.png') }}" class="w-40 h-40 mx-auto rounded-full object-cover border-4 border-yellow-400">
                        <h4 class="mt-4 font-bold text-xl text-yellow-600">{{ $juaraKt1['user']->name }} 👑</h4>
                        <div class="bg-yellow-400 text-white p-6 rounded-lg mt-2 flex flex-col justify-center">
                            <span class="text-2xl font-semibold">Juara 1</span>
                            <span class="text-5xl font-bold">{{ $juaraKt1['final_score'] }} Poin</span>
                        </div>
                    </div>
                    @else
                    <p class="text-center text-gray-500 py-10">Data tidak cukup untuk menampilkan peringkat Ketua Tim.</p>
                    @endif
                </div>
            </div>

            <!-- Blok Download Dokumen -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Dokumen Resmi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Dokumen Pegawai Teladan -->
                        <div class="text-center p-4 border rounded-lg">
                            <h4 class="font-semibold mb-3">Pegawai Teladan</h4>
                            @if($period->sk_pegawai_path)
                            <a href="{{ Storage::url($period->sk_pegawai_path) }}" target="_blank" class="inline-flex items-center ... bg-gray-800 text-white ... mb-2">Unduh SK Pegawai</a>
                            @endif
                            @if($period->sertifikat_pegawai_path)
                            <a href="{{ Storage::url($period->sertifikat_pegawai_path) }}" target="_blank" class="inline-flex items-center ... bg-gray-800 text-white ...">Unduh Sertifikat Pegawai</a>
                            @endif
                            @if(!$period->sk_pegawai_path && !$period->sertifikat_pegawai_path)
                            <p class="text-sm text-gray-500">Dokumen belum tersedia.</p>
                            @endif
                        </div>
                        <!-- Dokumen Ketua Tim Teladan -->
                        <div class="text-center p-4 border rounded-lg">
                            <h4 class="font-semibold mb-3">Ketua Tim Teladan</h4>
                            @if($period->sk_ketua_tim_path)
                            <a href="{{ Storage::url($period->sk_ketua_tim_path) }}" target="_blank" class="inline-flex items-center ... bg-gray-800 text-white ... mb-2">Unduh SK Ketua Tim</a>
                            @endif
                            @if($period->sertifikat_ketua_tim_path)
                            <a href="{{ Storage::url($period->sertifikat_ketua_tim_path) }}" target="_blank" class="inline-flex items-center ... bg-gray-800 text-white ...">Unduh Sertifikat Ketua Tim</a>
                            @endif
                            @if(!$period->sk_ketua_tim_path && !$period->sertifikat_ketua_tim_path)
                            <p class="text-sm text-gray-500">Dokumen belum tersedia.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-main-layout>