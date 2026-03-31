<div class="d-flex justify-content-center">
    <button type="button" class="btn viewOrganizationBtn"
        title="View Details"
        data-id="{{ $organization->id }}"
        data-name="{{ $organization->name }}"
        data-type="{{ $organization->type }}"
        data-sector="{{ $organization->sector }}"
        data-link="{{ $organization->link }}"
        data-purpose="{{ $organization->purpose }}"
        data-established="{{ $organization->established }}"
        data-description="{{ $organization->description }}"
        data-logo="{{ $organization->logo }}">
        <i class="fas fa-eye"></i>
    </button>

    <button type="button" class="btn editOrganizationBtn"
        title="Edit"
        data-id="{{ $organization->id }}"
        data-name="{{ $organization->name }}"
        data-type="{{ $organization->type }}"
        data-sector="{{ $organization->sector }}"
        data-link="{{ $organization->link }}"
        data-purpose="{{ $organization->purpose }}"
        data-established="{{ $organization->established }}"
        data-description="{{ $organization->description }}"
        data-logo="{{ $organization->logo }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn delete-btn"
        title="Delete"
        data-url="{{ route('admin.organizations.destroy', $organization->id) }}"
        data-name="{{ $organization->name }}">
        <i class="fas fa-trash"></i>
    </button>
</div>
