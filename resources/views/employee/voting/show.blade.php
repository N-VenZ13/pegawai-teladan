<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Form Penilaian untuk: <span class="font-bold">{{ $assignment->target->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Kita hapus card putih terluar agar konten menyatu dengan background abu-abu -->
            <div class="p-6 md:p-8 text-gray-900">

                @if ($errors->any())
                <div class="bg-rose-100 border-l-4 border-brand-rose text-rose-800 p-4 rounded-md mb-6" role="alert">
                    <p class="font-bold">Oops! Terjadi kesalahan.</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Blok Petunjuk dengan warna biru -->
                <div class="mb-8 p-4 bg-blue-50 border-l-4 border-brand-blue rounded-r-lg">
                    <h4 class="font-semibold text-blue-800">Petunjuk Pengisian:</h4>
                    <ul class="list-disc list-inside text-sm text-blue-700 mt-2 space-y-1">
                        <li>Berikan penilaian seobjektif mungkin terhadap <span class="font-semibold">{{ $assignment->target->name }}</span>.</li>
                        <li>Gunakan skala 1 (Sangat Buruk) hingga 10 (Sangat Baik).</li>
                        <li>Klik di mana saja di dalam kotak skor untuk memilih.</li>
                        <li>Semua pertanyaan wajib diisi.</li>
                    </ul>
                </div>

                <form id="voting-form" action="{{ route('voting.store', $assignment->id) }}" method="POST">
                    @csrf
                    <div class="space-y-6">

                        @forelse($questions as $index => $question)
                        <div class="p-6 border rounded-lg bg-white shadow-sm question-group transition-all duration-300">
                            <p class="block font-medium text-gray-800 text-lg">
                                <span class="font-bold text-brand-blue">{{ $index + 1 }}.</span> {{ $question->text }}
                            </p>

                            <div class="mt-4 grid grid-cols-5 md:grid-cols-10 gap-2">
                                @for ($i = 1; $i <= 10; $i++)
                                    <label for="score_{{ $question->id }}_{{ $i }}"
                                    class="flex flex-col items-center justify-center p-3 border rounded-lg cursor-pointer 
                                                      transition-colors duration-200
                                                      text-gray-600 font-semibold bg-gray-50/50
                                                      hover:bg-blue-100 hover:border-blue-300
                                                      has-[:checked]:bg-brand-blue has-[:checked]:text-white has-[:checked]:border-brand-blue has-[:checked]:shadow-lg">

                                    <input type="radio"
                                        id="score_{{ $question->id }}_{{ $i }}"
                                        name="scores[{{ $question->id }}]"
                                        value="{{ $i }}"
                                        class="hidden">

                                    <span class="text-lg">{{ $i }}</span>
                                    </label>
                                    @endfor
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-10 bg-white rounded-lg border">
                            <p class="text-gray-500">Tidak ada pertanyaan penilaian yang tersedia untuk kategori ini.</p>
                        </div>
                        @endforelse
                    </div>

                    @if($questions->isNotEmpty())
                    <div class="flex items-center justify-end mt-8">
                        <a href="{{ route('voting.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 me-6">
                            Batal
                        </a>
                        <button type="submit" id="submit-button" class="inline-flex items-center px-8 py-3 bg-brand-blue border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all">
                            Kirim Penilaian
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const votingForm = document.getElementById('voting-form');
            if (votingForm) {
                votingForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const questionGroups = document.querySelectorAll('.question-group');
                    let allAnswered = true;
                    questionGroups.forEach(group => {
                        group.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                    });
                    questionGroups.forEach(group => {
                        if (!group.querySelector('input[type="radio"]:checked')) {
                            allAnswered = false;
                            group.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                        }
                    });
                    if (!allAnswered) {
                        alert('Mohon isi semua pertanyaan. Pertanyaan yang belum diisi telah ditandai dengan warna merah.');
                        return;
                    }
                    if (confirm('Apakah Anda sudah yakin dengan semua nilai yang Anda berikan? Penilaian yang sudah dikirim tidak dapat diubah kembali.')) {
                        const submitButton = document.getElementById('submit-button');
                        if (submitButton) {
                            submitButton.disabled = true;
                            submitButton.innerText = 'MENGIRIM...';
                        }
                        this.submit();
                    }
                });
            }
        });
    </script>
    @endpush
</x-main-layout>