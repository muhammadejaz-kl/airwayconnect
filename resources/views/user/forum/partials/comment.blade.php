<li class="flex items-start gap-3 pb-4 mb-4" data-comment-id="{{ $comment->id }}">
    <!-- Avatar -->
    <img src="{{ $comment->user && $comment->user->profile_image ? asset('storage/'.$comment->user->profile_image) : asset('assets/images/default-avatar.png') }}"
        class="w-10 h-10 rounded-full" alt="User Avatar">

    <!-- Comment Content -->
    <div class="flex-1">
        <div class="text-sm mb-3">
            <span class="font-semibold text-base text-white">{{ $comment->user->name ?? 'Unknown User' }}</span>
            <p class="text-white text-sm">{{ $comment->created_at->diffForHumans() }}</p>
            <p class="text-gray-300 mt-2">{{ $comment->comment }}</p>
        </div>

        <!-- Meta: Time, Like, Reply -->
        <div class="flex items-center gap-4 mt-1 text-xs text-gray-400">
            
            <button class="comment-like-btn bg-primary-color px-3 rounded-3xl p-2 flex items-center gap-1 text-white {{ $comment->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}" data-id="{{ $comment->id }}">
                <img src="{{ asset('assets/images/icon/like.png') }}" class="w-6 h-6 like-icon outline-icon {{ $comment->likes->where('user_id', Auth::id())->count() ? 'd-none' : '' }}" alt="Like">
                <img src="{{ asset('assets/images/icon/liked.png') }}" class="w-6 h-6 like-icon filled-icon {{ $comment->likes->where('user_id', Auth::id())->count() ? '' : 'd-none' }}" alt="Liked">
                <span class="text-sm font-medium">{{ $comment->likes->count() }} Like</span>
            </button>

            <button class="toggle-replies flex bg-primary-color px-3 rounded-3xl p-2 flex items-center gap-1 text-white" data-comment-id="{{ $comment->id }}">
                <img src="{{ asset('assets/images/icon/replyicon.svg') }}" class="w-6 h-6" alt="Reply">
                <span class="text-sm font-medium">Reply ({{ $comment->replies->count() }})</span>
            </button>
        </div>

        

        <!-- Replies -->
        <ul class="replies mt-4 space-y-2 pl-8" id="replies-{{ $comment->id }}">
            @foreach($comment->replies->take(2) as $reply)
            @include('user.forum.partials.reply-item', ['reply' => $reply])
            @endforeach
        </ul>
        <!-- Reply Input -->
        <div class="hidden reply-box mt-3 flex items-center gap-2">
            <img src="{{ Auth::user()->profile_image ? asset('storage/'.Auth::user()->profile_image) : asset('assets/images/default-avatar.png') }}"
                class="w-8 h-8 rounded-full" alt="User Avatar">
            <input type="text"
                placeholder="Add a reply..."
                class="reply-input bg-transparent border-b border-gray-600 text-sm text-white w-full focus:outline-none"
                data-parent-id="{{ $comment->id }}">
            <button class="send-reply text-blue-400 font-semibold" data-parent-id="{{ $comment->id }}">Reply</button>
        </div>

        @if($comment->replies->count() > 2)
        <button class="load-more-replies text-blue-400 text-xs mt-1" data-comment-id="{{ $comment->id }}" data-offset="2">
            Load More Replies
        </button>
        @endif
    </div>
</li>