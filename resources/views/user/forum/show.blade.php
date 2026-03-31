@extends('user.layout.user')

@section('content')
<div class="py-7 p-2">
    <div class="mx-auto w-full md:max-w-7xl py-2 sm:px-6 lg:px-8">
        <!-- Banner -->
        <div class="p-5 py-7 rounded-lg rounded-b-none h-[411px] flex flex-col justify-center"
            style="background: url('{{ $forum->banner ? asset('storage/'.$forum->banner) : asset('assets/images/forumbgimg.svg') }}'); background-size: cover; background-position:center">
        </div>

        <!-- Forum Content -->
        <div class="bg-secondary-color p-8">
            <div class="mb-6 flex gap-3 items-start">
                <!-- User Avatar -->
                <img src="{{ $forum->user && $forum->user->profile_image ? asset('storage/'.$forum->user->profile_image) : asset('admin/assets/img/profiles/avatar-01.png') }}"
                    class="w-12 h-12 rounded-full" alt="User Avatar">

                <!-- Forum Details -->
                <div class="flex flex-col w-full gap-2">
                    <div class="flex w-full justify-between items-center">
                        <div>
                            <h2 class="font-semibold text-2xl text-white">{{ $forum->user->name ?? 'Unknown User' }}</h2>
                            <p class="text-sm text-white">{{ $forum->created_at->format('F d, Y') }}</p>
                        </div>
                        @if(Auth::check() && Auth::id() === $forum->user_id)
                        <div class="flex gap-3">
                            <a href="{{ route('user.forum.edit', $forum->id) }}" class="bg-primary-color px-3 py-2 text-white rounded-xl">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('user.forum.destroy', $forum->id) }}" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 px-3 py-2 text-white rounded-xl">Delete</button>
                            </form>
                        </div>
                        @endif
                    </div>

                    <!-- Forum Description -->
                    <div class="mt-3 text-sm text-white leading-relaxed">
                        {{ $forum->description }}
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 pt-3">
                         <!-- Counts -->
                        <div class="flex items-center gap-4 text-gray-400 text-sm mb-3">
                            <span class="flex gap-2 items-center" id="likes-count"><img src={{ asset('assets/images/icon/like-fill-icon.svg') }} alt="">{{ $forum->likes->count() }} Likes</span>
                            <span class="flex gap-2 items-center" id="comments-count"><img src={{ asset('assets/images/icon/comment-fill.svg') }} alt="">{{ $forum->comments->count() }} Comments</span>
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex items-center gap-6 mb-3">
                            <button id="like-btn" class="flex items-center bg-primary-color px-3 rounded-3xl p-2 gap-2 like-btn {{ $forum->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}">
                                <img src="{{ asset('assets/images/icon/like.png') }}" class="w-7 h-7 like-icon outline-icon {{ $forum->likes->where('user_id', Auth::id())->count() ? 'd-none' : '' }}" alt="Like">
                                <img src="{{ asset('assets/images/icon/liked.png') }}" class="w-7 h-7 like-icon filled-icon {{ $forum->likes->where('user_id', Auth::id())->count() ? '' : 'd-none' }}" alt="Liked">
                                <span class="text-white" id="likes-count">{{ $forum->likes->count() }} Likes</span>
                            </button>
                        </div>

                       

                        <!-- Add Comment -->
                        <!-- <div class="flex items-center gap-3">
                            <img src="{{ Auth::user()->profile_image ? asset('storage/'.Auth::user()->profile_image) : asset('admin/assets/img/profiles/avatar-01.png') }}"
                                class="w-8 h-8 rounded-full" alt="User Avatar">
                            <input type="text" id="comment-input" placeholder="Add a comment..."
                                class="flex-1 bg-transparent border-b border-gray-600 text-sm text-white focus:outline-none">
                            <button id="comment-btn" class="text-blue-500 font-semibold text-sm">Comment</button>
                        </div> -->
                    </div>

                    <!-- Comments List -->
                    <ul id="comment-list" class="mt-6 space-y-4">
                        @include('user.forum.partials.comment-list', ['comments' => $comments])
                    </ul>

                    <!-- Load More Comments -->
                    <div class="text-center mt-6" id="load-more-comments-container">
                        @if($comments->hasMorePages())
                        <button id="load-more-comments" class="text-blue-400 hover:underline text-sm"
                            data-next-page="{{ $comments->nextPageUrl() }}">
                            Load More Comments
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="flex bg-white items-center gap-3 p-4 rounded-xl mt-3">
            <!-- <img src="{{ Auth::user()->profile_image ? asset('storage/'.Auth::user()->profile_image) : asset('admin/assets/img/profiles/avatar-01.png') }}"
                class="w-8 h-8 rounded-full" alt="User Avatar"> -->
            <input type="text" id="comment-input" placeholder="Add a comment..."
                class="flex-1 bg-transparent border-0 text-sm comment-input">
            <button id="comment-btn" class="bg-primary-color rounded-3xl py-3 px-5 text-white font-semibold text-sm">Comment</button>
        </div>
    </div>
</div>
@include('user.forum.partials.script')
@endsection