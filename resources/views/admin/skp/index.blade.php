<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Nilai SKP') }} (Periode: {{ $activePeriod->name }})
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('skp.store') }}" method="POST">
                    @csrf
                    <div class="p-6 text-gray-900">
                        
                        @if (session('success'))
                            <div class="bg-teal-100 border-l-4 border-brand-teal text-teal-800 p-4 rounded-md mb-6" role="alert">
                                <p class="font-bold">Sukses</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="bg-rose-100 border-l-4 border-brand-rose text-rose-800 p-4 rounded-md mb-6" role="alert">
                                <p class="font-bold">Gagal</p>
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">Tabel Input Nilai SKP Bulanan</h3>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand-blue border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Simpan Semua Nilai SKP
                            </button>
                        </div>

                        <div class="overflow-x-auto border rounded-lg">
                            <table class="w-full">
                                <thead class="bg-brand-blue text-white">
                                    <tr>
                                        <th class="w-2/5 px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Pegawai</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Nilai {{ $activePeriod->month_1_name ?? 'Bulan 1' }}</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Nilai {{ $activePeriod->month_2_name ?? 'Bulan 2' }}</th>
                                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider">Nilai {{ $activePeriod->month_3_name ?? 'Bulan 3' }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($users as $user)
                                    <tr class="hover:bg-blue-50 bg-gray-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                            <p class="text-xs text-gray-500">{{ $user->jabatan }}</p>
                                        </td>
                                        @php
                                            $userScore = $existingScores->get($user->id);
                                        @endphp
                                        <td class="px-4 py-2">
                                            <input type="" step="0.01" min="0" max="100"
                                                   name="scores[{{ $user->id }}][month_1]"
                                                   value="{{ old('scores.'.$user->id.'.month_1', $userScore->month_1_score ?? '') }}"
                                                   class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="" step="0.01" min="0" max="100"
                                                   name="scores[{{ $user->id }}][month_2]"
                                                   value="{{ old('scores.'.$user->id.'.month_2', $userScore->month_2_score ?? '') }}"
                                                   class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="" step="0.01" min="0" max="100"
                                                   name="scores[{{ $user->id }}][month_3]"
                                                   value="{{ old('scores.'.$user->id.'.month_3', $userScore->month_3_score ?? '') }}"
                                                   class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-gray-500">Tidak ada data pegawai.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>