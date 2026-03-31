@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fas fa-cogs me-2"></i> Skills in "{{ $category->name }}"
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.resumeSkill.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <button class="btn btn-primary" id="addSkillBtn" data-bs-toggle="modal" data-bs-target="#skillModal">
                <i class="fas fa-plus"></i> Add Skill
            </button>
        </div>
    </div>

    <!-- Skills -->
    <ul class="list-unstyled d-flex flex-wrap gap-3">
        @forelse($skills as $skill)
        <li class="d-flex align-items-center">
            <div class="skill-card p-3 d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center">
                    <span class="fw-bold me-2">{{ $loop->iteration }}.</span>
                    <span class="fw-semibold">{{ $skill->skill }}</span>
                </div>
                <button type="button" class="btn btn-sm text-danger delete-btn"
                    data-url="{{ route('admin.resumeSkill.destroy', $skill->id) }}"
                    data-name="{{ $skill->skill }}"
                    title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>

            @if(!$loop->last)
            <span class="mx-2 fw-bold text-muted">|</span>
            @endif
        </li>
        @empty
        <p class="text-muted fst-italic">No skills added yet.</p>
        @endforelse
    </ul>
</div>

<!-- Modal -->
<div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="skillForm">
            @csrf
            <input type="hidden" id="skill_id" name="id">
            <input type="hidden" name="category_id" value="{{ $category->id }}">

            <div class="modal-content shadow rounded-4 border-0">
                <div class="modal-header bg-info text-white rounded-top-4">
                    <h5 class="modal-title" id="skillModalLabel"><i class="fas fa-plus-circle me-2"></i> Add Skill</h5>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Skill Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" name="name" id="skill_name" class="form-control" placeholder="Enter Skill Name" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 py-3">
                    <button type="submit" class="btn btn-primary px-4" id="saveSkillBtn">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Close
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .skill-card {
        border-radius: 15px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        cursor: pointer;
        min-width: 200px;
    }

    .skill-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        border-color: #3b82f6;
    }

    .bg-gradient-info {
        background: linear-gradient(90deg, #17a2b8, #20c997);
    }
</style>
@endpush

@push('scripts')
<script>
    function resetSkillModal() {
        $('#skillForm')[0].reset();
        $('#skill_id').val('');
        $('#skillModalLabel').text('Add Skill');
        $('#saveSkillBtn').text('Save');
    }

    $('#addSkillBtn').click(function() {
        resetSkillModal();
        $('#skillForm').attr('action', "{{ route('admin.resumeSkill.store') }}");
    });
</script>
@endpush