<div class="d-flex justify-content-center">
    <button class="btn btn-sm me-2 viewCategoryBtn" title="View"
        data-id="{{ $category->id }}"
        data-title="{{ $category->title }}"
        data-description="{{ $category->description }}"
        data-banner="{{ $category->banner }}">
        <i class="fas fa-eye"></i>
    </button>

    <button class="btn btn-sm me-2 editCategoryBtn" title="Edit"
        data-id="{{ $category->id }}"
        data-title="{{ $category->title }}"
        data-description="{{ $category->description }}"
        data-banner="{{ $category->banner }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-sm delete-btn" title="Delete"
        data-url="{{ route('admin.resources.category.destroy', $category->id) }}"
        data-name="{{ $category->title }}">
        <i class="fas fa-trash"></i>
    </button>

    <a href="{{ route('admin.resources.resourceIndex', ['id' => $category->id]) }}" class="btn btn-sm ms-2" title="Add Resource">
        <i class="fas fa-plus"></i>
    </a>

</div>