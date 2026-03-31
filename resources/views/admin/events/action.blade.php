<div class="d-flex justify-content-center gap-2">
    <a href="{{ route('admin.events.show', $event->id) }}" class="btn btn-sm">
        <i class="fas fa-eye"></i>
    </a>

    <button class="btn btn-sm editEventBtn"
        data-id="{{ $event->id }}"
        data-title="{{ $event->title }}"
        data-link="{{ $event->link }}"
        data-description="{{ $event->description }}"
        data-location="{{ $event->location }}"
        data-date="{{ $event->date }}"
        data-timing="{{ $event->timing }}"
        data-about="{{ $event->about }}"
        data-banner="{{ $event->banner }}"
        data-description="{{ $event->description }}">
        <i class="fas fa-edit"></i>
    </button>

    <button class="btn btn-sm delete-btn"
        data-url="{{ route('admin.events.destroy', $event->id) }}"
        data-name="{{ $event->title }}">
        <i class="fas fa-trash"></i>
    </button>
</div>