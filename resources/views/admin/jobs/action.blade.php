<div class="d-flex justify-content-center gap-2">
    <a href="{{ route('admin.jobs.show', $job->id) }}" class="btn btn-sm" title="View">
        <i class="fas fa-eye"></i>
    </a>

    <button class="btn btn-sm editjobBtn" title="Edit"
        data-id="{{ $job->id }}"
        data-title="{{ $job->title }}"
        data-type="{{ $job->type }}"
        data-for_airlines="{{ $job->for_airlines }}"
        data-description="{{ $job->description }}"
        data-location="{{ $job->location }}"
        data-experience="{{ $job->experience }}"
        data-last_date="{{ $job->last_date }}"
        data-link="{{ $job->link }}"
        data-status="{{ $job->status }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-sm delete-btn" title="Delete"
        data-url="{{ route('admin.jobs.destroy', $job->id) }}"
        data-name="{{ $job->title }}">
        <i class="fas fa-trash"></i>
    </button>
</div>