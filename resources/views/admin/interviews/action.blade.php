<div class="d-flex gap-2">
    <button class="btn btn-sm viewQuestionBtn"
        data-topicname="{{ $qa->topic->topic ?? 'N/A' }}"
        data-type="{{ $qa->type }}"
        data-question="{{ $qa->question }}"
        data-answer="{{ $qa->answer }}"
        data-status="{{ $qa->status }}"
        data-options='{{ $qa->options }}'>
        <i class="fas fa-eye"></i>
    </button>

    <button class="btn btn-sm editQuestionBtn"
        data-id="{{ $qa->id }}"
        data-topic="{{ $qa->topic_id }}"
        data-type="{{ $qa->type }}"
        data-question="{{ $qa->question }}"
        data-answer="{{ $qa->answer }}"
        data-options='{{ $qa->options ?? "{}" }}'
        data-status="{{ $qa->status }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-sm delete-btn"
        data-url="{{ route('admin.interview.destroy', $qa->id) }}"
        data-name="{{ $qa->question }}" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</div>