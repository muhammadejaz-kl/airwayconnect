@extends('user.layout.user')

@section('content')

<div class="py-7 px-6">
    <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">

        <div class="text-gray-400 text-sm mb-4">
            <a href="#" class="hover:text-white text-lg">Home</a>
            <i class="pi pi-chevron-right text-sm mx-1"></i>
            <span class="text-gray-200 text-lg">Interview Preparation</span>
        </div>

        <div class="bg-secondary-color p-5 rounded-lg">
            <h2 class="font-bold text-2xl text-white mb-5">Interview Preparation</h2>

            @if ($topics->count())

                <div class="flex flex-col lg:flex-row gap-4" style="min-height: 520px;">

                    {{-- LEFT: Topics List --}}
                    <div class="lg:w-1/3 flex flex-col gap-2 overflow-y-auto" style="max-height: 600px;">
                        @foreach ($topics as $topic)
                            <button
                                onclick="loadTopic({{ $topic->id }}, '{{ addslashes($topic->topic) }}')"
                                id="topic-btn-{{ $topic->id }}"
                                class="topic-btn flex items-center justify-between text-white text-sm text-left px-4 py-3 rounded-lg border border-transparent hover:border-primary-color hover:bg-white/5 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="text-base">✈</span>
                                    <span class="uppercase font-medium">{{ $topic->topic }}</span>
                                </div>
                                <span class="text-gray-400 text-xs whitespace-nowrap ml-2">[{{ $topic->questions_count }}]</span>
                            </button>
                        @endforeach
                    </div>

                    {{-- RIGHT: Q&A Panel --}}
                    <div class="lg:w-2/3 bg-white/5 rounded-xl p-6 flex flex-col" style="min-height: 440px;">

                        {{-- Empty state --}}
                        <div id="qa-empty" class="flex flex-col items-center justify-center flex-1 text-gray-400">
                            <span class="text-5xl mb-4">✈</span>
                            <p class="text-lg">Select a topic to start</p>
                        </div>

                        {{-- Loading --}}
                        <div id="qa-loading" class="hidden flex-col items-center justify-center flex-1 text-gray-400">
                            <svg class="animate-spin h-10 w-10 mb-3 text-primary-color" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            <p>Loading questions...</p>
                        </div>

                        {{-- Card Panel --}}
                        <div id="qa-panel" class="hidden flex-col flex-1">
                            <h3 id="qa-topic-title" class="text-white font-bold text-lg uppercase mb-4"></h3>

                            {{-- Card --}}
                            <div id="qa-card" class="bg-secondary-color rounded-xl p-6 flex-1 flex flex-col justify-between" style="min-height: 280px;">
                                <div class="flex-1">
                                    {{-- Question mode --}}
                                    <div id="card-question-view">
                                        <p class="text-gray-400 text-xs uppercase font-semibold mb-2 tracking-wider">Question</p>
                                        <p id="card-question-text" class="text-white text-lg leading-relaxed"></p>
                                        <div id="card-question-img-wrap" class="mt-4 hidden">
                                            <img id="card-question-img" src="" alt="Question image" class="max-w-full rounded-lg max-h-64 object-contain">
                                        </div>
                                    </div>

                                    {{-- Answer mode --}}
                                    <div id="card-answer-view" class="hidden">
                                        <p class="text-gray-400 text-xs uppercase font-semibold mb-2 tracking-wider">Answer</p>
                                        <p id="card-answer-text" class="text-white text-lg leading-relaxed"></p>
                                        <div id="card-answer-img-wrap" class="mt-4 hidden">
                                            <img id="card-answer-img" src="" alt="Answer image" class="max-w-full rounded-lg max-h-64 object-contain">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Navigation --}}
                            <div class="flex items-center justify-between mt-5">
                                <button id="btn-prev"
                                    onclick="navigate('prev')"
                                    class="min-w-[120px] py-2 px-4 rounded-lg text-white border border-white/30 hover:border-white transition hidden">
                                    ← Previous
                                </button>
                                <div class="text-white text-sm">
                                    <span id="qa-counter" class="text-gray-300"></span>
                                </div>
                                <button id="btn-next"
                                    onclick="navigate('next')"
                                    class="min-w-[120px] py-2 px-4 rounded-lg bg-primary-color text-white hover:opacity-90 transition">
                                    Next →
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            @else

                <div class="bg-[#C5C5C5] rounded-lg flex flex-col items-center justify-center py-10 mt-6 shadow-inner">
                    <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Interview Topics" class="w-28 h-28 mb-4 opacity-80">
                    <p class="text-gray-700 text-lg font-medium text-center">No Interview Preparation found.</p>
                </div>

            @endif

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const questionsUrl = "{{ url('interview/questions') }}";

    // State
    let questions  = [];   // flat array of {question, question_image, answer, answer_image}
    let cardIndex  = 0;    // index in questions array
    let showingAnswer = false;

    function loadTopic(topicId, topicName) {
        // Highlight active topic
        document.querySelectorAll('.topic-btn').forEach(b => {
            b.classList.remove('border-primary-color', 'bg-white/10');
        });
        const activeBtn = document.getElementById('topic-btn-' + topicId);
        if (activeBtn) activeBtn.classList.add('border-primary-color', 'bg-white/10');

        // Show loading
        document.getElementById('qa-empty').classList.add('hidden');
        document.getElementById('qa-panel').classList.add('hidden');
        document.getElementById('qa-loading').classList.remove('hidden');
        document.getElementById('qa-loading').classList.add('flex');

        fetch(questionsUrl + '/' + topicId)
            .then(r => r.json())
            .then(data => {
                questions = data;
                cardIndex = 0;
                showingAnswer = false;

                document.getElementById('qa-loading').classList.add('hidden');
                document.getElementById('qa-loading').classList.remove('flex');

                if (questions.length === 0) {
                    document.getElementById('qa-empty').classList.remove('hidden');
                    return;
                }

                document.getElementById('qa-topic-title').textContent = topicName;
                document.getElementById('qa-panel').classList.remove('hidden');
                document.getElementById('qa-panel').classList.add('flex');

                renderCard();
            })
            .catch(() => {
                document.getElementById('qa-loading').classList.add('hidden');
                document.getElementById('qa-loading').classList.remove('flex');
                document.getElementById('qa-empty').classList.remove('hidden');
            });
    }

    function renderCard() {
        const q = questions[cardIndex];
        const total = questions.length;

        // Show correct view
        const questionView = document.getElementById('card-question-view');
        const answerView   = document.getElementById('card-answer-view');

        if (showingAnswer) {
            questionView.classList.add('hidden');
            answerView.classList.remove('hidden');

            document.getElementById('card-answer-text').textContent = q.answer || '—';

            const imgWrap = document.getElementById('card-answer-img-wrap');
            const img     = document.getElementById('card-answer-img');
            if (q.answer_image) {
                img.src = q.answer_image;
                imgWrap.classList.remove('hidden');
            } else {
                imgWrap.classList.add('hidden');
            }
        } else {
            answerView.classList.add('hidden');
            questionView.classList.remove('hidden');

            document.getElementById('card-question-text').textContent = q.question;

            const imgWrap = document.getElementById('card-question-img-wrap');
            const img     = document.getElementById('card-question-img');
            if (q.question_image) {
                img.src = q.question_image;
                imgWrap.classList.remove('hidden');
            } else {
                imgWrap.classList.add('hidden');
            }
        }

        // Counter: shows "Q 3 / 50" or "A 3 / 50"
        const label = showingAnswer ? 'Answer' : 'Question';
        document.getElementById('qa-counter').textContent =
            label + ' ' + (cardIndex + 1) + ' / ' + total;

        // Prev button: hide on first question (not answer)
        const prevBtn = document.getElementById('btn-prev');
        prevBtn.classList.toggle('hidden', cardIndex === 0 && !showingAnswer);

        // Next button label
        const nextBtn = document.getElementById('btn-next');
        if (!showingAnswer) {
            nextBtn.textContent = 'Show Answer →';
        } else if (cardIndex < total - 1) {
            nextBtn.textContent = 'Next →';
        } else {
            nextBtn.textContent = 'Finish';
        }
    }

    function navigate(direction) {
        if (direction === 'next') {
            if (!showingAnswer) {
                // Question → Answer
                showingAnswer = true;
            } else {
                // Answer → Next Question
                if (cardIndex < questions.length - 1) {
                    cardIndex++;
                    showingAnswer = false;
                } else {
                    // Finished — restart
                    cardIndex = 0;
                    showingAnswer = false;
                }
            }
        } else {
            // Previous
            if (showingAnswer) {
                // Answer → back to Question
                showingAnswer = false;
            } else if (cardIndex > 0) {
                // Question → previous Answer
                cardIndex--;
                showingAnswer = true;
            }
        }
        renderCard();
    }
</script>
@endpush

