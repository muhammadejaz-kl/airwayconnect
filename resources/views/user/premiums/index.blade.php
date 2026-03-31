@extends('user.layout.user')

@section('content')
    <div class="flex md:justify-center p-6 pt-[2%] flex-col md:items-center ">
        <h1 class="text-white text-[42px] font-medium">Get Started Now, Pick your Plan</h1>
        <p class="text-[#7c7c7c] font-thin text-[14px] mt-2 text-center max-w-[600px]">
            Get instant access to the tools and features you need – flexible plans designed for every goal and budget
        </p>

        <div class="xl:max-w-4xl flex justify-center mt-5 overflow-hidden">
            <div class="swiper mySwiper px-6">
                <div class="swiper-wrapper">
                    @if($subscriptions->isEmpty())
                        <div class="swiper-slide flex justify-center">
                            <div
                                class="plan-card bg-[#172A46] rounded-2xl shadow-lg w-[340px] md:w-[420px] px-8 py-6 text-center">
                                <h2 class="text-white text-xl font-semibold mb-1">No Plans Available</h2>
                                <p class="text-gray-400 text-sm">Please check back later</p>
                            </div>
                        </div>
                    @else
                        @foreach($subscriptions as $subscription)
                            @php $features = json_decode($subscription->features, true) ?? []; @endphp

                            <div class="swiper-slide flex justify-center">
                                <div
                                    class="plan-card bg-[#172A46] rounded-2xl shadow-lg w-[340px] md:w-[420px] px-8 py-6 flex flex-col">
                                    <h2 class="text-white text-xl font-semibold mb-1">{{ $subscription->name }}</h2>
                                    <p class="text-gray-400 text-sm mb-4">Best plan for all features</p>

                                    <div class="price-wrapper flex items-baseline space-x-2 mb-4">
                                        <span class="plan-price text-white text-3xl font-bold"
                                            data-amount="{{ $subscription->amount }}">
                                            ${{ $subscription->amount }}
                                        </span>
                                        <span class="text-gray-400 text-sm">per month</span>
                                    </div>

                                    <div class="border-t border-gray-600 w-full mb-4"></div>

                                    <ul class="space-y-3 text-white text-sm flex-1">
                                        @forelse($features as $feature)
                                            <li class="flex items-center">
                                                <span class="text-blue-400 mr-2">✔</span>
                                                {{ $feature }}
                                            </li>
                                        @empty
                                            <li class="text-gray-400">No features listed</li>
                                        @endforelse
                                    </ul>

                                    @if(auth()->user()->premiun_status == 1 && auth()->user()->plan_id == $subscription->id)
                                        <button
                                            class="mt-6 w-full bg-gray-500 py-3 rounded-lg text-white font-semibold text-sm cursor-not-allowed"
                                            disabled>
                                            Current Plan
                                        </button>
                                    @else
                                        <button
                                            class="upgradePlan mt-6 w-full bg-[#2563EB] hover:bg-[#1D4ED8] py-3 rounded-lg text-white font-semibold text-sm transition"
                                            data-id="{{ $subscription->id }}" data-amount="{{ $subscription->amount }}"
                                            @if(auth()->user()->premiun_status == 1) disabled class="cursor-not-allowed opacity-60" @endif>
                                            Upgrade Plan
                                        </button>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="mt-6 flex justify-center w-full xl:max-w-[40%]">
            <div class="flex w-full bg-[#172A46] rounded-lg overflow-hidden">
                <input id="coupon_code" class="flex-1 bg-transparent px-4 text-white placeholder-gray-400 outline-none"
                    type="text" placeholder="Enter Coupon Code" />
                <button id="applyCoupon" class="bg-[#2563EB] hover:bg-[#1D4ED8] px-6 text-white font-medium transition">
                    Apply
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiperContainer = document.querySelector('.mySwiper');
            let appliedCouponId = null;

            const totalSlides = swiperContainer ? swiperContainer.querySelectorAll('.swiper-slide').length : 0;

            if (swiperContainer) {
                const swiper = new Swiper('.mySwiper', {
                    effect: 'coverflow',
                    centeredSlides: true,
                    slidesPerView: totalSlides === 1 ? 1 : 'auto',
                    loop: totalSlides > 2,
                    grabCursor: totalSlides > 1,
                    allowTouchMove: totalSlides > 1,
                    autoplay: { delay: 3000, disableOnInteraction: false },
                    pagination: { el: '.swiper-pagination', clickable: totalSlides > 1 },
                    coverflowEffect: { rotate: 0, stretch: 0, depth: 100, modifier: 1, slideShadows: false },
                    breakpoints: {
                        640: { slidesPerView: 1, spaceBetween: 0 },
                        768: { slidesPerView: totalSlides === 1 ? 1 : 'auto' },
                        1024: { slidesPerView: totalSlides === 1 ? 1 : 'auto', spaceBetween: 40 },
                        1280: { slidesPerView: totalSlides === 1 ? 1 : 'auto', spaceBetween: 50 },
                    }
                });

                swiperContainer.addEventListener('mouseenter', () => swiper.autoplay.stop());
                swiperContainer.addEventListener('mouseleave', () => swiper.autoplay.start());

                document.getElementById('applyCoupon').addEventListener('click', function () {
                    const code = document.getElementById('coupon_code').value.trim();
                    if (!code) return Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Please enter a coupon code!' });

                    fetch("{{ route('user.premium.applyCoupon') }}", {
                        method: "POST",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ code })
                    })
                        .then(res => res.json())
                        .then(data => {
                            const activeSlide = swiper.slides[swiper.activeIndex];
                            const priceWrapper = activeSlide.querySelector(".price-wrapper");
                            const priceEl = activeSlide.querySelector(".plan-price");
                            const original = parseFloat(priceEl.dataset.amount);

                            if (data.success) {
                                appliedCouponId = data.coupon_id;
                                const discounted = (original - (original * data.discount / 100)).toFixed(2);
                                priceWrapper.innerHTML = `
                            <del class="text-gray-400 text-lg font-medium">$${original}</del>
                            <span class="plan-price text-green-400 text-3xl font-bold" data-amount="${discounted}">$${discounted}</span>
                            <span class="text-gray-400 text-sm">per month</span>
                        `;
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Coupon Applied!',
                                    html: `You saved <b>${data.discount}%</b><br>New Price: <b>$${discounted}</b>`,
                                    showConfirmButton: false,
                                    timer: 2500
                                });
                            } else {
                                priceWrapper.innerHTML = `<span class="plan-price text-white text-3xl font-bold" data-amount="${original}">$${original}</span>
                            <span class="text-gray-400 text-sm">per month</span>`;
                                Swal.fire({ icon: 'error', title: 'Invalid Coupon', text: data.message });
                            }
                        })
                        .catch(() => Swal.fire({ icon: 'error', title: 'Something went wrong', text: 'Please try again later.' }));
                });

                document.querySelectorAll('.upgradePlan').forEach(button => {
                    button.addEventListener('click', async () => {
                        const subscriptionId = button.dataset.id;
                        const amountEl = button.closest('.swiper-slide').querySelector('.plan-price');
                        const amount = parseFloat(amountEl.dataset.amount);

                        try {
                            const res = await fetch("{{ route('user.premium.createCheckout') }}", {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ subscription_id: subscriptionId, amount: amount, coupon_id: appliedCouponId })
                            });
                            const data = await res.json();

                            if (data.sessionId) {
                                const stripe = Stripe("{{ env('STRIPE_PK') }}");
                                stripe.redirectToCheckout({ sessionId: data.sessionId });
                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Could not initiate payment.' });
                            }
                        } catch (err) {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.' });
                        }
                    });
                });
            }
        });
    </script>

    @if(!empty($transactionData))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let status = "{{ $transactionData['status'] ?? '' }}";
                let txnId = "{{ $transactionData['transaction_id'] ?? '' }}";
                let amount = "{{ ($transactionData['amount'] ?? 0) / 100 }}";
                let planId = "{{ $transactionData['plan_id'] ?? '' }}";
                let couponId = "{{ $transactionData['coupon_id'] ?? '' }}";

                if (status === 'paid') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful 🎉',
                        html: `
                            <b>Transaction ID:</b> ${txnId}<br>
                            <b>Amount:</b> $${amount}<br>
                        `,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('user.premium.index') }}";
                    });
                } else if (status === 'canceled') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Payment Canceled ❌',
                        html: `
                            <b>Transaction ID:</b> ${txnId}<br>
                            
                        `,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('user.premium.index') }}";
                    });
                }
            });
        </script>
    @endif

@endpush