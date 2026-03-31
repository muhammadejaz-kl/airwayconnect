<div class="d-flex mb-2 reply-item">
    <img src="{{ $reply->user->profile ?? 'https://www.shutterstock.com/image-vector/vector-flat-illustration-grayscale-avatar-600nw-2264922221.jpg' }}" class="rounded-circle me-2" width="35" height="35" alt="reply-user">
    <div>
        <strong>{{ $reply->user->name }}</strong>
        <p class="mb-1">
            {{ $reply->reply }}
            <button type="button" class="btn btn-sm text-warning restrict-user"
                data-id="{{ $reply->user_id }}" data-forum-id="{{ $forum->id }}" title="Restrict User">
                <i class="fas fa-user-slash"></i>
            </button>
            <button type="button" class="btn btn-sm text-danger delete-reply"
                data-id="{{ $reply->id }}" data-type="reply" title="Delete Reply">
                <i class="fas fa-trash"></i>
            </button>
        </p>
        <span class="text-muted small">Likes: {{ $reply->likes->count() }}</span>
    </div>
</div>