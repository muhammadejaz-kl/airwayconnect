<div class="d-flex justify-content-center gap-2">
    <button class="btn btn-sm viewFaqBtn"
        data-question="{{ $faq->question }}"
        data-answer="{{ $faq->answer }}">
        <i class="fas fa-eye"></i>
    </button>

    <button class="btn btn-sm editFaqBtn"
        data-id="{{ $faq->id }}"
        data-question="{{ $faq->question }}"
        data-answer="{{ $faq->answer }}">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-sm delete-btn"
        data-url="{{ route('admin.faqs.destroy', $faq->id) }}"
        data-name="{{ $faq->question }}" title="Delete">
        <i class="fas fa-trash"></i>
    </button>
</div>
