@extends('user.layout.user')

@section('content')

    <style>
        .notification-success {
            background-color: #28a745 !important;
            color: white !important;
        }

        .notification-error {
            background-color: #dc3545 !important;
            color: white !important;
        }
    </style>

    <div id="toastContainer" class="fixed top-5 right-5 z-50 space-y-2"></div>

    <div class="py-7 px-6">
        <div class="mx-auto w-full md:max-w-4xl p-2 sm:px-6 lg:px-8">

            <div class="text-gray-400 text-sm mb-4">
                <a href="{{ route('user.interview.index') }}" class="hover:text-white text-lg">Home</a>
                <i class="pi pi-chevron-right text-sm mx-1"></i>
                <span class="text-gray-200 text-lg">{{ $topic->topic }}</span>
            </div>

            <h2 class="font-bold text-2xl text-white mb-5 uppercase">
                {{ $topic->topic }} Questions
            </h2>

            <div class="bg-secondary-color p-6 rounded-xl shadow-lg relative" id="questionContainer">

                @if ($questions->count())

                    @foreach ($questions as $index => $q)

                        <div class="question-item {{ $index === 0 ? '' : 'hidden' }}" 
                             data-answer="{{ strtolower($q->answer) }}">

                            <div class="text-white text-xl font-semibold mb-6">
                                Q{{ $index + 1 }}. {{ $q->question }}
                            </div>

                            @if($q->type === 'MSQ')
                                @php $options = json_decode($q->options, true); @endphp

                                <div class="space-y-3 mb-6">
                                    @foreach($options as $key => $option)
                                        <label class="flex items-center gap-3 text-white text-lg cursor-pointer">
                                            <input type="radio" name="question_{{ $q->id }}" 
                                                   value="{{ strtolower($key) }}" 
                                                   class="option-radio">
                                            <span>{{ strtoupper($key) }}. {{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>

                                <p class="mt-3 text-green-400 text-base hidden answer-box">
                                    Answer:
                                    <strong>
                                        {{ strtoupper($q->answer) }}. {{ $options[$q->answer] ?? '' }}
                                    </strong>
                                </p>

                            @else
                                <p class="text-lg text-white mb-6">Answer: {{ $q->answer }}</p>
                            @endif

                        </div>
                    @endforeach

                @else
                    <p class="text-center text-white text-lg mt-5">
                        No questions found for this topic.
                    </p>
                @endif


                @if ($questions->count())
                    <div class="flex items-center justify-between mt-8">

                        <button id="prevBtn" 
                                class="min-w-[140px] py-2 px-4 rounded-lg text-white border border-white hidden">
                            ⬅ Previous
                        </button>

                        <div class="text-white text-lg">
                            <span id="currentIndex">1</span> /
                            <span id="totalQuestions">{{ count($questions) }}</span>
                        </div>

                        <button id="nextBtn" 
                                class="min-w-[140px] py-2 px-4 rounded-lg bg-primary-color text-white">
                            Verify
                        </button>
                        
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const questions = document.querySelectorAll('.question-item');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const currentIndexEl = document.getElementById('currentIndex');
        const totalQuestions = questions.length;

        let currentIndex = 0;
        const visited = {};

        function showQuestion(index) {
            questions.forEach((q, i) =>
                q.classList.toggle('hidden', i !== index)
            );

            currentIndexEl.textContent = index + 1;

            prevBtn.classList.toggle('hidden', index === 0);

            const qEl = questions[index];
            const isMCQ = qEl.querySelector('.option-radio');
            const answerBox = qEl.querySelector('.answer-box');
            const radios = qEl.querySelectorAll('.option-radio');
            const qKey = `q${index}`;

            if (answerBox) answerBox.classList.add('hidden');

            if (isMCQ) {
                nextBtn.textContent =
                    visited[qKey]?.verified
                    ? (index === totalQuestions - 1 ? 'Finish' : 'Next')
                    : 'Verify';

                if (visited[qKey]) {
                    radios.forEach(r => r.checked = (r.value === visited[qKey].answer));
                    if (visited[qKey].verified && answerBox) answerBox.classList.remove('hidden');
                } else {
                    radios.forEach(r => r.checked = false);
                }

            } else {
                nextBtn.textContent = (index === totalQuestions - 1) ? 'Finish' : 'Next';
            }
        }

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                showQuestion(currentIndex);
            }
        });

        nextBtn.addEventListener('click', () => {

            const qEl = questions[currentIndex];
            const isMCQ = qEl.querySelector('.option-radio');
            const selected = qEl.querySelector('.option-radio:checked');
            const correctAnswer = qEl.dataset.answer;
            const answerBox = qEl.querySelector('.answer-box');
            const qKey = `q${currentIndex}`;

            if (isMCQ) {

                if (!visited[qKey]?.verified) {

                    if (!selected) {
                        $notification('Please select an option.', 'error');
                        return;
                    }

                    const userAnswer = selected.value;
                    visited[qKey] = { answer: userAnswer, verified: true };

                    if (userAnswer === correctAnswer) {
                        $notification('Correct answer!', 'success');
                    } else {
                        $notification('Wrong answer.', 'error');
                        if (answerBox) answerBox.classList.remove('hidden');
                    }

                    nextBtn.textContent =
                        currentIndex === totalQuestions - 1
                        ? 'Finish'
                        : 'Next';

                } else {
                    goNextOrFinish();
                }

            } else {
                goNextOrFinish();
            }
        });

        function goNextOrFinish() {
            if (currentIndex < totalQuestions - 1) {
                currentIndex++;
                showQuestion(currentIndex);
            } else {
                $notification('You have completed all questions.', 'success');
                setTimeout(() => {
                    window.location.href = "{{ route('user.interview.index') }}";
                }, 1000);
            }
        }

        function $notification(message, type) {
            const box = document.createElement('div');
            box.className =
                `fixed top-5 right-5 z-50 px-4 py-2 rounded shadow-lg text-white 
                 ${type === 'success' ? 'notification-success' : 'notification-error'}`;
            box.textContent = message;

            document.body.appendChild(box);

            setTimeout(() => box.remove(), 1500);
        }

        showQuestion(currentIndex);
    });
</script>
@endpush
