<div id="subscriptionPopup"
    class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50  z-[999]">
    <div class="relative subscription-pop-up p-6">
        <div class="">
            <button id="closeSubscriptionPopup"
                class="absolute top-2 right-2 text-gray-600 hover:text-black text-white">
                ✕
            </button>
            <div class="flex mt-4 gap-4">
                <img src="{{ asset('assets/images/icon/rocket.svg') }}" alt="Rocket Icon"
                    class="w-16 h-16 mx-auto mb-4" />
                <h2 class="text-[24px] font-bold mb-4 text-white">Feature Available on Subscription</h2>
            </div>
            <p class="mb-2 text-[#C8C8C8] text-[14px]">This feature is available exclusively with our premium
                Subscription Plans</p>
            <li class="text-[#C8C8C8]">Advance tools and features</li>
            <li class="text-[#C8C8C8]">Priority support</li>
            <li class="text-[#C8C8C8]">Regular updates and improvements</li>
            <h1 class="text-[#FFFFFF] text-[20px] my-4">Ready to upgrade?</h1>
            <a href="{{ url('/premium-plan') }}"
                class="w-full justify-center primary-button border-none inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                View Pricing Plans
            </a>
        </div>
    </div>
</div>