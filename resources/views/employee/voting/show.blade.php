<!-- resources/views/employee/voting/show.blade.php -->
<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Penilaian untuk: <span class="font-bold">{{ $assignment->target->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-6 p-4 bg-gray-50 border rounded-md">
                        <h4 class="font-semibold">Petunjuk Pengisian:</h4>
                        <ul class="list-disc list-inside text-sm text-gray-600 mt-2">
                            <li>Berikan penilaian seobjektif mungkin.</li>
                            <li>Gunakan skala 1 (Sangat Buruk) hingga 10 (Sangat Baik).</li>
                            <li>Semua pertanyaan wajib diisi.</li>
                        </ul>
                    </div>

                    <form action="{{ route('voting.store', $assignment->id) }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            @foreach($questions as $index => $question)
                            <div class="p-4 border rounded-md">
                                <label for="score_{{ $question->id }}" class="block font-medium text-gray-700">
                                    {{ $index + 1 }}. {{ $question->text }}
                                </label>
                                <div class="mt-3 flex space-x-2">
                                    @for($i = 1; $i <= 10; $i++)
                                        <div class="flex items-center">
                                        <input type="radio"
                                            id="score_{{ $question->id }}_{{ $i }}"
                                            name="scores[{{ $question->id }}]"
                                            value="{{ $i }}"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                            required>
                                        <label for="score_{{ $question->id }}_{{ $i }}" class="ml-2 block text-sm text-gray-900">{{ $i }}</label>
                                </div>
                                @endfor
                            </div>
                        </div>
                        @endforeach
                </div>

                <div class="flex items-center justify-end mt-8">
                    <a href="{{ route('voting.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest ...">
                        Kirim Penilaian
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-main-layout>