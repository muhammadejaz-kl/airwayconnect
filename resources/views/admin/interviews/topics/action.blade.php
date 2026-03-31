<div class="d-flex gap-2">

    <button type="button" class="btn btn-sm viewTopicBtn"
        data-title="{{ $topic->topic }}"
        data-description="{{ $topic->description }}"
        data-status="{{ $topic->status }}"
        data-created="{{ $topic->created_at ? $topic->created_at->format('d M Y H:i') : 'N/A' }}">
        <i class="fas fa-eye"></i>
    </button>

    <button class="btn btn-sm editTopicBtn"
        data-id="{{ $topic->id }}"
        data-title="{{ $topic->topic }}"
        data-description="{{ $topic->description }}"
        data-status="{{ $topic->status }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-sm delete-btn"
        data-url="{{ route('admin.interview.topic.destroy', $topic->id) }}"
        data-name="{{ $topic->topic }}" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</div>