@forelse($forums as $forum)
    <a href="{{ route('user.forum.show', $forum->id) }}">
        <div class="flex items-start gap-4 border-b border-gray-600 py-4">
            <img src="{{ $forum->banner ? asset('storage/'.$forum->banner) : asset('assets/images/icon/default-user.png') }}"
                class="w-12 h-12 rounded-full object-cover" />
            <div class="flex-1">
                <h2 class="text-lg mb-2 font-bold text-white">{{ $forum->name }}</h2>
                <p class="text-sm flex items-center gap-2 font-medium text-white">
                    <img src="{{ asset('assets/images/icon/replyicon.svg') }}" alt="">
                    {{ Str::limit($forum->description, 100, '...') }}
                </p>
            </div>
            <div class="flex gap-2 items-center justify-center text-gray-300">
                <img src="{{ asset('assets/images/icon/chaticon.svg') }}" alt="">
                <span class="text-sm">{{ $forum->comments->count() }}</span>
            </div>
        </div>
    </a>
@empty
    <div class="bg-[#C5C5C5] rounded-lg flex flex-col items-center justify-center py-10 mt-6 shadow-inner">
        <img src="{{ asset('assets/images/icon/empty-screen.png') }}" alt="No Community"
            class="w-28 h-28 mb-4 opacity-80">
        <p class="text-gray-700 text-lg font-medium text-center">
            No Community found.
        </p>
    </div>
@endforelse

@if($forums->hasMorePages())
    <button id="load-more" class="hidden" data-next-page="{{ $forums->nextPageUrl() }}"></button>
@endif
