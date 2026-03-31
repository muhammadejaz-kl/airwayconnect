<div class="d-flex justify-content-center gap-2">

    <button class="btn btn-sm editCategoryBtn" data-id="{{ $subscription->id }}"
        data-name="{{ $subscription->name }}" data-description="{{ $subscription->validity }}"
        data-banner="{{ $subscription->amount }}" data-topics='@json(json_decode($subscription->features, true) ?? [])'
        data-status="{{ $subscription->status }}" title="View">
        <i class="fas fa-eye"></i>
    </button>

    <!-- Edit -->
    <button type="button" class="btn btn-sm editForumBtn" data-id="{{ $subscription->id }}"
        data-name="{{ $subscription->name }}" data-description="{{ $subscription->validity }}"
        data-banner="{{ $subscription->amount }}" data-topics='@json(json_decode($subscription->features, true) ?? [])'
        data-status="{{ $subscription->status }}" title="Edit">
        <i class="fas fa-edit"></i>
    </button>

    <!-- Delete -->
    <button type="button" class="btn btn-sm delete-btn"
        data-url="{{ route('admin.subscriptions.destroy', $subscription->id) }}" data-name="{{ $subscription->name }}"
        title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</div>