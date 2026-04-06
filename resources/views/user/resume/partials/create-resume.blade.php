<div class="grid items-center md:grid-cols-2 gap-6">
    <div>
        <h3 class="text-primary-color text-6xl font-bold">
            Resume Builder
        </h3>
        <h3 class="text-white text-6xl font-bold">
            that lands you flight dispatcher jobs
        </h3>
        <p class="text-white my-3">
            Build a professional, aviation-ready resume designed to showcase your dispatcher
            skills and certifications, helping you stand out to airlines and land your next
            flight dispatcher role with confidence.
        </p>
        <button
            class="inline-block bg-primary-color px-6 py-3 text-white font-medium rounded-lg hover:bg-blue-700 transition"
            onclick="createResume(this)">Create Resume</button>
    </div>

    <div class="text-center">
        @if($resume && $resume->resume)
            <img src="{{ route('user.resume.serve.image') }}" alt="Your Resume"
                class="w-[80%] md:h-[700px] mx-auto shadow-lg border border-gray-300">

            <div class="flex justify-center gap-4 mt-2">
                <button type="button" title="View Resume (PDF)" onclick="openPdfView('{{ $resume->resume }}')"
                    class="hover:scale-110 transition transform">
                    <img src="{{ url('assets/images/icon/view.png') }}" alt="View Resume" class="w-5 h-5">
                </button>

                <button type="button" title="Download Resume as PDF" onclick="convertImageToPdf('{{ $resume->resume }}')"
                    class="hover:scale-110 transition transform">
                    <img src="{{ url('assets/images/icon/download.png') }}" alt="Download Resume" class="w-5 h-5">
                </button>
            </div>
        @else
            <img src="{{ asset('assets/images/builder-img.svg') }}" alt="Resume Builder" class="w-[80%] mx-auto">
        @endif
    </div>
</div>

@push('scripts')
    <script>
        window.convertImageToPdf = function (imagePath) {
            $.ajax({
                url: "{{ route('user.resume.convert.pdf') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    image_path: imagePath
                },
                beforeSend: function () {
                    Swal.fire({
                        title: 'Converting...',
                        text: 'Please wait while we prepare your PDF.',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (response) {
                    Swal.close();
                    if (response.success) {
                        const bytes = Uint8Array.from(atob(response.pdf_data), c => c.charCodeAt(0));
                        const blob = new Blob([bytes], {type: 'application/pdf'});
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = response.filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);

                        Swal.fire({
                            title: 'Downloaded!',
                            text: 'Your resume has been downloaded.',
                            icon: 'success'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.error || 'Something went wrong.',
                            icon: 'error'
                        });
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.error || 'Failed to convert image to PDF.',
                        icon: 'error'
                    });
                }
            });
        }

        window.openPdfView = function (imagePath) {
            $.ajax({
                url: "{{ route('user.resume.convert.pdf') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    image_path: imagePath
                },
                beforeSend: function () {
                    Swal.fire({
                        title: 'Preparing PDF...',
                        text: 'Please wait while we open your resume.',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (response) {
                    Swal.close();
                    if (response.success && response.pdf_data) {
                        const bytes = Uint8Array.from(atob(response.pdf_data), c => c.charCodeAt(0));
                        const blob = new Blob([bytes], {type: 'application/pdf'});
                        const url = URL.createObjectURL(blob);
                        window.open(url, '_blank');
                        setTimeout(() => URL.revokeObjectURL(url), 10000);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.error || 'Failed to open resume PDF.',
                            icon: 'error'
                        });
                    }
                },
                error: function (xhr) {
                    Swal.close();
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.error || 'An unexpected error occurred.',
                        icon: 'error'
                    });
                }
            });
        }
    </script>
@endpush