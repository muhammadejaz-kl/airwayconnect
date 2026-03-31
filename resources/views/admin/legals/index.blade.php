@extends('admin.layouts.master')

@section('content')
<div class="content container-fluid h-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">
            <i data-feather="alert-triangle" class="me-1"></i> Legals Management
        </h4>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified mb-4">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-terms">
                        <i data-feather="file-text" class="me-1"></i> Terms of Service
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-privacy">
                        <i data-feather="lock" class="me-1"></i> Privacy Policy
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-cookie">
                        <i data-feather="shield" class="me-1"></i> Cookie Policy
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                {{-- Terms of Service --}}
                <div class="tab-pane fade show active" id="tab-terms">
                    <h5 class="mb-3 fw-semibold text-light">Update Terms of Service</h5>
                    <form method="POST" action="{{ route('admin.legals.store') }}">
                        @csrf
                        <input type="hidden" name="tab_type" value="legal_terms">
                        <div class="form-group mb-3">
                            <textarea id="editor_terms" name="legal_terms" class="form-control" rows="10">{{ old('legal_terms', $legalEntries['terms'] ?? '') }}</textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i data-feather="save" class="me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Privacy Policy --}}
                <div class="tab-pane fade" id="tab-privacy">
                    <h5 class="mb-3 fw-semibold text-light">Update Privacy Policy</h5>
                    <form method="POST" action="{{ route('admin.legals.store') }}">
                        @csrf
                        <input type="hidden" name="tab_type" value="legal_privacy">
                        <div class="form-group mb-3">
                            <textarea id="editor_privacy" name="legal_privacy" class="form-control" rows="10">{{ old('legal_privacy', $legalEntries['privacy'] ?? '') }}</textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i data-feather="save" class="me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Cookie Policy --}}
                <div class="tab-pane fade" id="tab-cookie">
                    <h5 class="mb-3 fw-semibold text-light">Update Cookie Policy</h5>
                    <form method="POST" action="{{ route('admin.legals.store') }}">
                        @csrf
                        <input type="hidden" name="tab_type" value="legal_cookie">
                        <div class="form-group mb-3">
                            <textarea id="editor_cookie" name="legal_cookie" class="form-control" rows="10">{{ old('legal_cookie', $legalEntries['cookie'] ?? '') }}</textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i data-feather="save" class="me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
<script>
    feather.replace();

    function createEditor(selector) {
        ClassicEditor.create(document.querySelector(selector), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            },
            placeholder: 'Start typing here...',
        }).then(editor => {
            editor.editing.view.change(writer => {
                writer.setStyle('color', '#000', editor.editing.view.document.getRoot());
                writer.setStyle('background-color', '#fff', editor.editing.view.document.getRoot());
            });
        }).catch(console.error);
    }

    createEditor('#editor_terms');
    createEditor('#editor_privacy');
    createEditor('#editor_cookie');
</script>
@endpush
