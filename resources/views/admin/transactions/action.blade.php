<div class="d-flex justify-content-center gap-2">
    <button class="btn btn-sm viewTransactionBtn" title="View"
        data-id="{{ $transaction->id }}"
        data-username="{{ $transaction->username }}"
        data-plan_name="{{ $transaction->plan->name ?? 'N/A' }}"
        data-plan_validity="{{ $transaction->plan->validity ?? 'N/A' }}"
        data-plan_amount="{{ $transaction->plan->amount ?? 0 }}"
        data-coupon_code="{{ $transaction->coupon->code ?? 'N/A' }}"
        data-coupon_discount="{{ $transaction->coupon->discount ?? 0 }}"
        data-transaction_id="{{ $transaction->transaction_id }}"
        data-paid_amount="{{ $transaction->paid_amount }}"
        data-payment_status="{{ $transaction->payment_status }}"
        data-created_at="{{ $transaction->created_at }}"
        data-response="{{ htmlspecialchars($transaction->response) }}"
    >
        <i class="fas fa-eye"></i>
    </button>
</div>
