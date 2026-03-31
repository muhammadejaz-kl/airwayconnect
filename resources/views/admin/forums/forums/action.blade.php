<div class="d-flex justify-content-center gap-2">
    <!-- View -->
    <a href="{{ route('admin.forum.show', $forum->id) }}" class="btn btn-sm" title="View">
        <i class="fas fa-eye"></i>
    </a>

    <!-- Edit -->
    <button type="button" class="btn btn-sm editForumBtn"
        data-id="{{ $forum->id }}"
        data-name="{{ $forum->name }}"
        data-description="{{ $forum->description }}"
        data-banner="{{ $forum->banner }}"
        data-topics='@json($forum->topic_ids)'
        data-status="{{ $forum->status }}"
        title="Edit">
        <i class="fas fa-edit"></i>
    </button>

    <!-- Delete -->
    <button type="button" class="btn btn-sm delete-btn"
        data-url="{{ route('admin.forum.forumDestroy', $forum->id) }}"
        data-name="{{ $forum->name }}" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</div>