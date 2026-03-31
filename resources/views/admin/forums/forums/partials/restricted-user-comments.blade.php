<div>
    <h6 class="fw-bold mb-2">Comments</h6>
    @forelse($comments as $comment)
        <div class="mb-3 border-bottom pb-2">
            <p class="mb-1">{{ $comment->comment }}</p>
            <small class="text-muted">{{ $comment->created_at->format('d M Y h:i A') }}</small>
        </div>
    @empty
        <p class="text-muted">No comments.</p>
    @endforelse

    <h6 class="fw-bold mt-4 mb-2">Replies</h6>
    @forelse($replies as $reply)
        <div class="mb-3 border-bottom pb-2">
            <p class="mb-1">{{ $reply->reply }}</p>
            <small class="text-muted">{{ $reply->created_at->format('d M Y h:i A') }}</small>
        </div>
    @empty
        <p class="text-muted">No replies.</p>
    @endforelse
</div>
