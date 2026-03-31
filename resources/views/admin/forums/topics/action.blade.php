<div class="d-flex justify-content-center">
    <button class="btn btn-sm me-2 editTopicBtn"
        data-id="{{ $topic->id }}"
        data-title="{{ $topic->topic }}"
        data-status="{{ $topic->status }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-sm delete-btn"
        data-url="{{ route('admin.forum.topic.destroy', $topic->id) }}"
        data-name="{{ $topic->topic }}" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</div>