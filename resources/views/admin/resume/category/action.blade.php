<div class="d-flex justify-content-center">
    <button class="btn btn-sm me-2 editCategoryBtn" title="Edit"
        data-id="{{ $category->id }}"
        data-name="{{ $category->name }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-sm delete-btn" title="Delete"
        data-url="{{ route('admin.resumeSkill.category.destroy', $category->id) }}"
        data-name="{{ $category->name }}">
        <i class="fas fa-trash"></i>
    </button>

    <a href="{{ route('admin.resumeSkill.skillIndex', ['id' => $category->id]) }}" class="btn btn-sm ms-2" title="Add Resource">
        <i class="fas fa-plus"></i>
    </a>

</div>