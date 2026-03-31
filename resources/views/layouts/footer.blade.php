<footer class="bg-dark-color pt-8">
    <div class="container mx-auto px-4">
        <!-- Top Section -->
        <div class="flex justify-between gap-4 footer-container border-b border-gray-300 pb-6 flex-wrap">
            <div class="left-content max-w-md">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Logo" class="mb-4">
                <p class="text-white">
                    Create your account and set up your profile in just minutes, no credit card required.
                </p>
            </div>
            <div class="right-content grid md:grid-cols-2 gap-5">
                <div>
                    <p class="text-lg text-white font-semibold">Features</p>
                    <ul class="footer-menu space-y-2 mt-2">
                        <li><a href="{{ route('user.resume.index') }}" class="text-gray-300 hover:text-white">Resume Builder</a></li>
                        <li><a href="{{ route('user.interview.index') }}" class="text-gray-300 hover:text-white">Interview Preparation</a></li>
                        <li><a href="{{ route('user.airlineDirectory.index') }}" class="text-gray-300 hover:text-white">Airlines Directory</a></li>
                        <!-- <li><a href="#" class="text-gray-300 hover:text-white">Hiring List</a></li> -->
                        <li><a href="{{ route('user.resource.index') }}" class="text-gray-300 hover:text-white">Resource Library</a></li>
                        <li><a href="{{ route('user.forum.index') }}" class="text-gray-300 hover:text-white">Community Forum</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-lg text-white font-semibold">Legal</p>
                    <ul class="footer-menu space-y-2 mt-2">
                        <li>
                            <a href="{{ route('termsServices') }}" class="text-gray-300 hover:text-white">
                                Terms of Service
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('privacyPolicies') }}" class="text-gray-300 hover:text-white">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cookiesPolicies') }}" class="text-gray-300 hover:text-white">
                                Cookie Policy
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="social-container flex justify-between gap-3 py-6 flex-wrap items-center">
            <p class="text-white text-sm">
                © 2025 Airway Connect. All rights reserved.
            </p>
            <div class="flex gap-4 social-icons">
                <a href="https://www.facebook.com/share/1BrfgGbVPn/?mibextid=wwXIfr"><img src="{{ asset('assets/images/icon/Facebook.svg') }}" alt="Facebook"></a>
                <a href="https://www.instagram.com/airwayconnect?igsh=MXNvbHVraDVldTRscg%3D%3D&utm_source=qr"><img src="{{ asset('assets/images/icon/insta.svg') }}" alt="Instagram"></a>
                <a href="https://www.tiktok.com/@airwayconnect?_r=1&_t=ZP-91iICyFeSlS"><img src="{{ asset('assets/images/icon/tiktok.svg') }}" alt="Twitter"></a>
                <a href="https://www.linkedin.com/company/airwayconnect/"><img src="{{ asset('assets/images/icon/Linkedin.svg') }}" alt="LinkedIn"></a>
            </div>
        </div>
    </div>
</footer>