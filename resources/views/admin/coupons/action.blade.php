    <div class="d-flex justify-content-center gap-2">
        <!-- View -->
        <a href="{{ route('admin.coupons.show', $coupon->id) }}" class="btn btn-sm" title="View">
            <i class="fas fa-eye"></i>
        </a>

        <!-- Edit -->
        <button type="button" class="btn btn-sm editCouponBtn"
            data-id="{{ $coupon->id }}"
            data-name="{{ $coupon->name }}"
            data-code="{{ $coupon->code }}"
            data-discount="{{ $coupon->discount }}"
            data-description="{{ $coupon->description }}"
            data-status="{{ $coupon->status }}"
            title="Edit">
            <i class="fas fa-edit"></i>
        </button>

        <!-- Delete -->
        <button type="button" class="btn btn-sm delete-btn"
            data-url="{{ route('admin.coupons.destroy', $coupon->id) }}"
            data-name="{{ $coupon->name }}" title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    </div>
