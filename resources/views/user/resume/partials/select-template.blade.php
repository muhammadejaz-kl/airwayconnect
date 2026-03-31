{{-- ===================== TEMPLATE SELECTION ===================== --}}
<div class="flex flex-col py-12 items-center justify-center bg-[#0A1A2F] min-h-screen text-white">
    <h1 class="text-4xl font-bold mb-2 text-center text-white">Select the Template That Best Represents You</h1>
    <p class="text-gray-300 mb-10 text-center">You can always change your template later</p>

    <div class="hidden">
        <div id="template1">@include('user.resume.partials.templates.template2')</div>
        <div id="template2">@include('user.resume.partials.templates.template3')</div>
        <div id="template3">@include('user.resume.partials.templates.template4')</div>
    </div>

    <div id="previewArea" class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl px-6"></div>

    <div class="flex items-center justify-center space-x-4 mt-12">
        <button id="templateBackBtn"
            class="border min-w-[200px] border-gray-400 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition text-base">
            Back
        </button>
        <button id="templateNextBtn" disabled
            class="bg-gray-500 min-w-[200px] text-white px-6 py-3 rounded-lg cursor-not-allowed transition text-base">
            Next
        </button>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const templates = [
        { id: "template1", image: "{{ asset('assets/images/templates/template2.png') }}" },
        { id: "template2", image: "{{ asset('assets/images/templates/template3.png') }}" },
        { id: "template3", image: "{{ asset('assets/images/templates/template4.png') }}" }
    ];

    const $previewArea = $("#previewArea");
    const $templateNextBtn = $("#templateNextBtn");

    const $renderContainer = $("<div></div>").css({
        position: "absolute",
        left: "-9999px",
        top: "0",
        width: "800px",
        background: "white"
    }).appendTo("body");

    templates.forEach(tpl => {
        const $templateElement = $("#" + tpl.id);
        if ($templateElement.length) {
            $renderContainer.append($templateElement.clone());
        }
    });

    templates.forEach(tpl => {
        const $wrapper = $("<div></div>")
            .addClass("flex flex-col items-center text-center bg-[#0A1A2F]");

        const $img = $("<img>")
            .attr("src", tpl.image)
            .addClass("rounded-xl shadow-2xl border-2 border-transparent transition-transform duration-300 hover:scale-105 hover:shadow-blue-500/30")
            .css({
                width: "100%",
                maxWidth: "340px",
                height: "480px",
                objectFit: "contain",
                background: "#fff"
            });

        const $btn = $("<button></button>")
            .text("Choose Template")
            .addClass("mt-6 bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700 transition-all duration-200");

        $btn.on("click", function () {
            $("#previewArea img").removeClass("border-blue-500 border-4").addClass("border-transparent border-2");
            $img.removeClass("border-transparent border-2").addClass("border-blue-500 border-4");

            window.selectedTemplate = tpl.id;

            $templateNextBtn.prop("disabled", false)
                .removeClass("bg-gray-500 cursor-not-allowed")
                .addClass("bg-blue-600 hover:bg-blue-700");
        });

        $img.on("click", function () {
            $btn.trigger("click");
        });

        $wrapper.append($img, $btn);
        $previewArea.append($wrapper);
    });

    $templateNextBtn.on("click", function () {
        if (window.selectedTemplate) {
            $.ajax({
                url: "{{ route('user.resume.saveTemplateSession') }}",
                method: "POST",
                data: {
                    template_id: window.selectedTemplate,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    showStep("upload");
                }
            });
        }
    });
});
</script>
@endpush
