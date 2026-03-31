<div class="d-flex justify-content-center">
    <button type="button" class="btn viewDetailBtn"
        data-id="{{ $detail->id }}"
        data-part="{{ $detail->part }}"
        data-airlines_type="{{ $detail->airlines_type }}"
        data-job_type="{{ $detail->job_type }}"
        data-schedule_type="{{ $detail->schedule_type }}"
        data-option_401k="{{ $detail->option_401k }}"
        data-flight_benefits="{{ $detail->flight_benefits }}"
        data-description="{{ $detail->description }}"
        title="View Detail">
        <i class="fas fa-eye"></i>
    </button>

    <button type="button" class="btn editDetailBtn"
        data-id="{{ $detail->id }}"
        data-part="{{ $detail->part }}"
        data-airlines_type="{{ $detail->airlines_type }}"
        data-job_type="{{ $detail->job_type }}"
        data-schedule_type="{{ $detail->schedule_type }}"
        data-option_401k="{{ $detail->option_401k }}"
        data-flight_benefits="{{ $detail->flight_benefits }}"
        data-description="{{ $detail->description }}"
        title="Edit Detail">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn delete-btn"
        title="Delete"
        data-url="{{ route('admin.airlinesDirectory.destroyDetails', $detail->id) }}"
        data-name="{{ $detail->part }}">
        <i class="fas fa-trash"></i>
    </button>
</div>