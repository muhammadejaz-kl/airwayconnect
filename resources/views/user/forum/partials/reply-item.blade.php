<li class="flex items-start gap-2" data-reply-id="{{ $reply->id }}">
    <img src="{{ $reply->user && $reply->user->profile_image ? asset('storage/'.$reply->user->profile_image) : asset('admin/assets/img/profiles/avatar-01.png') }}"
        class="w-8 h-8 rounded-full" alt="User Avatar">
    <div class="flex flex-col text-sm">
        <span class="font-semibold text-base text-white">{{ $reply->user->name ?? 'Unknown User' }}</span>
        <span class="text-white text-sm">{{ $reply->created_at->diffForHumans() }}</span>
        <span class="text-gray-300 mt-2 text-sm">{{ $reply->reply }}</span>
        <div class="flex items-center gap-4 mt-3 text-xs text-gray-400">
            
            <button class="reply-like-btn bg-primary-color p-2 px-3 rounded-3xl text-white flex items-center gap-1 {{ $reply->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}" data-id="{{ $reply->id }}">
                <img src="{{ asset('assets/images/icon/like.png') }}" class="w-6 h-6 like-icon outline-icon {{ $reply->likes->where('user_id', Auth::id())->count() ? 'd-none' : '' }}" alt="Like">
                <img src="{{ asset('assets/images/icon/liked.png') }}" class="w-6 h-6 like-icon filled-icon {{ $reply->likes->where('user_id', Auth::id())->count() ? '' : 'd-none' }}" alt="Liked">
                <span class="text-sm font-medium">{{ $reply->likes->count() }} Like</span>
            </button>

        </div>
    </div>
</li>