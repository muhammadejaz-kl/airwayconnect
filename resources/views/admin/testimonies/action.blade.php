<div class="d-flex justify-content-center">
    <!-- View Button -->
    <button class="btn btn-sm me-2 viewTestimonialBtn" title="View"
        data-id="{{ $testimony->id }}"
        data-name="{{ $testimony->name }}"
        data-role="{{ $testimony->role }}"
        data-rating="{{ $testimony->rating }}"
        data-description="{{ $testimony->description }}"
        data-status="{{ $testimony->status }}"
        data-image="{{ $testimony->profile_image }}">
        <i class="fas fa-eye"></i>
    </button>

    <!-- Edit Button -->
    <button class="btn btn-sm me-2 editTestimonyBtn" title="Edit"
        data-id="{{ $testimony->id }}"
        data-name="{{ $testimony->name }}"
        data-role="{{ $testimony->role }}"
        data-rating="{{ $testimony->rating }}"
        data-description="{{ $testimony->description }}"
        data-status="{{ $testimony->status }}"
        data-image="{{ $testimony->profile_image }}">
        <i class="fas fa-edit"></i>
    </button>

    <!-- Delete Button -->
    <button type="button" class="btn btn-sm delete-btn" title="Delete"
        data-url="{{ route('admin.testimony.destroy', $testimony->id) }}"
        data-name="{{ $testimony->name }}">
        <i class="fas fa-trash"></i>
    </button>
</div>
