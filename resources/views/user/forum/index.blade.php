@extends('user.layout.user')

@section('content')
<div class="py-7" x-data="{ openModal: false }">
    <div class="mx-auto w-full md:max-w-7xl p-2 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="p-5 py-7 rounded-lg rounded-b-none h-[261px] flex flex-col justify-center"
            style="background: url('{{ asset('assets/images/forumimg.svg') }}');background-size: cover;background-position:center">
            <h1 class="text-3xl font-bold text-white">Welcome to Airway Connect Community</h1>
            <p class="text-sm text-white">
                Explore a curated collection of guides, templates, tools, and learning materials designed to support your journey.
            </p>
        </div>

        <div class="bg-secondary-color p-6">
            <div class="flex justify-between items-center mb-6">
                <!-- Modal Trigger -->
                @if (auth()->user()->role === ('admin'))
                <button class="bg-primary-color text-white px-4 py-2 rounded-md hover:bg-blue-700"
                    @click="openModal = true">
                    Start Discussion
                </button>
                @endif

                <!-- Dropdown -->
                <div x-data="{ open: false, selected: '{{ ucfirst($order) }}' }" class="relative">
                    <button @click="open = !open"
                        class="bg-white text-gray-700 px-4 py-2 rounded-md flex items-center gap-2">
                        <span x-text="selected"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false"
                        class="absolute right-0 mt-2 w-32 bg-white shadow-lg rounded-md py-2 z-50">
                        <button @click="selected = 'Latest'; open = false"
                            class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                            onclick="loadForums('latest')">
                            Latest
                        </button>
                        <button @click="selected = 'Oldest'; open = false"
                            class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                            onclick="loadForums('oldest')">
                            Oldest
                        </button>
                    </div>
                </div>
            </div>

            <!-- Discussion List -->
            <div id="forum-container" class="space-y-5 mt-5">
                @include('user.forum.partials.forum-list', ['forums' => $forums])
            </div>

            <div class="text-center mt-6" id="load-more-container">
                @if($forums->hasMorePages())
                <button id="load-more" class="text-gray-300 hover:text-white"
                    data-next-page="{{ $forums->nextPageUrl() }}">
                    Load More
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('user.forum.partials.create-modal', ['topics' => $topics])
</div>

<script src="https://unpkg.com/alpinejs" defer></script>
@endsection

@push('scripts')
<script>
    let currentOrder = '{{ $order }}';

    function loadForums(order, append = false, pageUrl = null) {
        currentOrder = order;
        const url = pageUrl ?? ("{{ route('user.forum.index') }}?order=" + order);

        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(data => {
                if (!append) {
                    document.getElementById('forum-container').innerHTML = data;
                } else {
                    document.getElementById('forum-container').insertAdjacentHTML('beforeend', data);
                }

                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                const newLoadMore = tempDiv.querySelector('#load-more');
                const container = document.getElementById('load-more-container');

                if (newLoadMore) {
                    container.innerHTML = `<button id="load-more" class="text-gray-300 hover:text-white"
                    data-next-page="${newLoadMore.dataset.nextPage}">Load More</button>`;
                } else {
                    container.innerHTML = '';
                }
            });
    }

    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'load-more') {
            const btn = e.target;
            btn.textContent = 'Loading...';
            const pageUrl = btn.dataset.nextPage + '&order=' + currentOrder;
            loadForums(currentOrder, true, pageUrl);
        }


        document.addEventListener('submit', function(e) {
            if (e.target && e.target.id === 'createForumForm') {
                showPreloader();
            }
        });

    });
</script>
@endpush