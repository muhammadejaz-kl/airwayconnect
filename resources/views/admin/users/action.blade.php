<div class="d-flex justify-content-center gap-2">
 
    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm" title="View">
        <i class="fas fa-eye"></i>
    </a>
 
    @empty($hideEdit)
        <button class="btn btn-sm editUserBtn" title="Edit" data-id="{{ $user->id }}" data-name="{{ $user->name }}"
            data-email="{{ $user->email }}" data-phone_code="{{ $user->phone_code }}"
            data-phone_number="{{ $user->phone_number }}">
            <i class="fas fa-edit"></i>
        </button>
    @endempty

    <button type="button" class="btn btn-sm delete-btn" data-url="{{ route('admin.users.destroy', $user->id) }}"
        data-name="{{ $user->name }}" title="Delete">
        <i class="fas fa-trash"></i>
    </button>

</div>