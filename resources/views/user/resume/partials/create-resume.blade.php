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
            <img src="{{ route('user.resume.image') }}" alt="Your Resume"
                class="w-[80%] md:h-[700px] mx-auto shadow-lg border border-gray-300">

            <div class="flex justify-center gap-4 mt-2">
                <button type="button" title="View Resume (PDF)" onclick="openResumePdf()"
                    class="hover:scale-110 transition transform">
                    <img src="{{ url('assets/images/icon/view.png') }}" alt="View Resume" class="w-5 h-5">
                </button>

                <button type="button" title="Download Resume as PDF" onclick="downloadResumePdf()"
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
    window.openResumePdf = function () {
        var win = window.open('{{ route('user.resume.view.pdf') }}', '_blank');
        if (!win) {
            Swal.fire({ title: 'Error!', text: 'Popup blocked. Please allow popups for this site.', icon: 'error' });
        }
    };

    window.downloadResumePdf = function () {
        var link = document.createElement('a');
        link.href = '{{ route('user.resume.download.pdf') }}';
        link.download = '';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    };
</script>
@endpush