<div class="d-flex justify-content-center">
    <button type="button" class="btn viewAirlineBtn"
        title="View"
        data-id="{{ $airline->id }}"
        data-name="{{ $airline->name }}"
        data-logo="{{ $airline->logo }}">
        <i class="fas fa-eye"></i>
    </button>

    <button type="button" class="btn editAirlineBtn"
        title="Edit"
        data-id="{{ $airline->id }}"
        data-name="{{ $airline->name }}"
        data-logo="{{ $airline->logo }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn delete-btn"
        title="Delete"
        data-url="{{ route('admin.airlinesDirectory.destroy', $airline->id) }}"
        data-name="{{ $airline->name }}">
        <i class="fas fa-trash"></i>
    </button>

    <a href="{{ route('admin.airlinesDirectory.show', $airline->id) }}"class="btn"title="Add Airline Details"><i class="fas fa-plus"></i></a>
</div>