<div class="pb-3 mb-3 border-bottom comment-item">
    <!-- Comment Header -->
    <div class="d-flex align-items-center mb-2">
        <img src="{{ $comment->user->profile ?? 'https://www.shutterstock.com/image-vector/vector-flat-illustration-grayscale-avatar-600nw-2264922221.jpg' }}" class="rounded-circle me-2" width="40" height="40" alt="user">
        <div>
            <strong>{{ $comment->user->name }}</strong>
            <small class="text-muted d-block">{{ $comment->created_at->diffForHumans() }}</small>
        </div>
    </div>

    <!-- Comment Text -->
    <p class="mb-1">
        {{ $comment->comment }}
        <button type="button" class="btn btn-sm text-warning restrict-user"
            data-id="{{ $comment->user_id }}" data-forum-id="{{ $forum->id }}" title="Restrict User">
            <i class="fas fa-user-slash"></i>
        </button>
        <button type="button" class="btn btn-sm text-danger delete-comment"
            data-id="{{ $comment->id }}" data-type="comment" title="Delete Comment">
            <i class="fas fa-trash"></i>
        </button>
    </p>
    <span class="text-muted small">
        Likes: {{ $comment->likes->count() }} | Replies: {{ $comment->replies()->count() }}
    </span>

    <!-- Replies -->
    <div class="ms-5 mt-3" id="replies-{{ $comment->id }}">
        @foreach($comment->replies as $reply)
        @include('admin.forums.forums.partials.reply', ['reply' => $reply, 'forum' => $forum])
        @endforeach
    </div>

    @if($comment->replies()->count() > 2)
    <button class="btn btn-sm btn-link load-more-replies mt-2 mb-2 text-primary"
        data-comment-id="{{ $comment->id }}" data-offset="2">
        View more replies
    </button>
    @endif
</div>