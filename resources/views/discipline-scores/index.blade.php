<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Input Nilai Disiplin') }} (Periode: {{ $activePeriod->name }})</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('discipline.scores.store') }}" method="POST">
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
                        <div class="text-right mb-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Simpan Semua Perubahan</button>
                        </div>

                        <div class="overflow-x-auto border rounded-lg">
                            <table class="min-w-full bg-white border table-fixed">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="w-[30%] py-3 px-4 uppercase font-semibold text-sm text-left">Nama Pegawai</th>
                                        @foreach($criteria as $criterion)
                                        <th class="py-3 px-4 uppercase font-semibold text-sm text-center">{{ $criterion->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 font-medium @if(!$loop->last) border-r @endif">{{ $user->name }}</td>
                                        @foreach($criteria as $criterion)
                                        <td >
                                            <input type=""class="px-6 py-4 whitespace-nowrap text-center text-gray-500 @if(!$loop->last) border-r @endif"
                                                name="scores[{{ $user->id }}][{{ $criterion->id }}]"
                                                value="{{ $existingScores[$user->id . '-' . $criterion->id] ?? '' }}"
                                                class="w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                min="0" max="100">
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-main-layout>