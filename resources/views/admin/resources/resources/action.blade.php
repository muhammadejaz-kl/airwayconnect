<div class="d-flex justify-content-center">
    <button class="btn btn-sm me-2 viewResourceBtn" title="View"
        data-id="{{ $resource->id }}"
        data-title="{{ $resource->title }}"
        data-description="{{ $resource->description }}"
        data-about="{{ $resource->about }}"
        data-banner="{{ $resource->banner }}">
        <i class="fas fa-eye"></i>
    </button>

    <button class="btn btn-sm me-2 editResourceBtn" title="Edit"
        data-id="{{ $resource->id }}"
        data-title="{{ $resource->title }}"
        data-description="{{ $resource->description }}"
        data-about="{{ $resource->about }}"
        data-banner="{{ $resource->banner }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-sm delete-btn" title="Delete"
        data-url="{{ route('admin.resources.resourceDestroy', $resource->id) }}"
        data-name="{{ $resource->title }}">
        <i class="fas fa-trash"></i>
    </button>
</div>