<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Peringkat Pegawai Teladan Tahunan ({{ $year }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- ======================================= -->
            <!--    BAGIAN NAVIGASI & FILTER TAHUN     -->
            <!-- ======================================= -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 flex justify-between items-center">
                    <a href="{{ route('annual-eval.form', ['year' => $year]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Kembali ke Form Penilaian
                    </a>
                    
                    <form method="GET" action="{{ route('annual-eval.recap') }}" class="flex items-center space-x-2">
                        <label for="year" class="text-sm font-medium text-gray-700">Lihat Tahun Lain:</label>
                        <select name="year" id="year" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm py-1" onchange="this.form.submit()">
                            @for ($y = now()->year; $y >= 2024; $y--)
                                <option value="{{ $y }}" @selected($y == $year)>{{ $y }}</option>
                            @endfor
                        </select>
                    </form>
                </div>
            </div>

            <!-- ======================================= -->
            <!--    BAGIAN PODIUM TAHUNAN              -->
            <!-- ======================================= -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">🏆 Peringkat Pegawai Teladan Tahun {{ $year }} 🏆</h3>

                    @if($results->count() >= 1)
                        @php
                            $juara1 = $results->get(0);
                            $juara2 = $results->get(1);
                            $juara3 = $results->get(2);
                        @endphp

                        <div class="flex items-end justify-center gap-4 md:gap-8 text-center">
                            <!-- Juara 2 -->
                            @if($juara2)
                                <div class="w-1/3">
                                    <img src="{{ $juara2->user->profile_photo_url }}" class="w-24 h-24 md:w-32 md:h-32 mx-auto rounded-full object-cover border-4 border-gray-300">
                                    <h4 class="mt-4 font-bold text-lg text-gray-800">{{ $juara2->user->name }}</h4>
                                    <div class="bg-gray-200 text-gray-800 p-4 md:p-6 rounded-t-lg mt-2 h-24 md:h-32 flex flex-col justify-center">
                                        <span class="text-4xl md:text-5xl font-bold">2</span>
                                        <span class="font-semibold">{{ $juara2->score }} Poin</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Juara 1 -->
                            @if($juara1)
                                <div class="w-1/3">
                                    <img src="{{ $juara1->user->profile_photo_url }}" class="w-28 h-28 md:w-40 md:h-40 mx-auto rounded-full object-cover border-4 border-yellow-400">
                                    <h4 class="mt-4 font-bold text-xl text-yellow-600">{{ $juara1->user->name }} 👑</h4>
                                    <div class="bg-yellow-300 text-gray-800 p-4 md:p-6 rounded-t-lg mt-2 h-32 md:h-48 flex flex-col justify-center">
                                        <span class="text-5xl md:text-6xl font-bold">1</span>
                                        <span class="font-semibold">{{ $juara1->score }} Poin</span>
                                    </div>
                                </div>
                            @endif

                            <!-- Juara 3 -->
                             @if($juara3)
                                <div class="w-1/3">
                                    <img src="{{ $juara3->user->profile_photo_url }}" class="w-24 h-24 md:w-32 md:h-32 mx-auto rounded-full object-cover border-4 border-yellow-600">
                                    <h4 class="mt-4 font-bold text-lg text-gray-800">{{ $juara3->user->name }}</h4>
                                    <div class="bg-yellow-600 text-white p-4 md:p-6 rounded-t-lg mt-2 h-20 md:h-24 flex flex-col justify-center">
                                        <span class="text-3xl md:text-4xl font-bold">3</span>
                                        <span class="font-semibold">{{ $juara3->score }} Poin</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-gray-500">Belum ada data penilaian yang disimpan untuk tahun {{ $year }}.</p>
                            <a href="{{ route('annual-eval.form', ['year' => $year]) }}" class="mt-4 inline-block px-4 py-2 bg-brand-blue text-white rounded-md text-sm hover:bg-blue-700">
                                Input Penilaian Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ======================================= -->
            <!--    BAGIAN TABEL PERINGKAT LENGKAP     -->
            <!-- ======================================= -->
            @if ($results->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Peringkat Lengkap</h3>
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="w-full">
                            <thead class="bg-brand-blue text-white">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider w-16">Peringkat</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Pegawai</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider w-32">Skor Akhir</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($results as $result)
                                    <tr class="hover:bg-blue-50">
                                        <td class="px-6 py-4 text-center text-sm font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $result->user->name }}</td>
                                        <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">{{ $result->score }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-main-layout>