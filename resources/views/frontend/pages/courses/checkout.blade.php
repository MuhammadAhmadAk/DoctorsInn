@extends('frontend.layouts.main')
@section('title', 'Checkout – ' . ($course['title'] ?? 'Course') . ' | DoctorsInnElite')
@section('meta_description', 'Complete your enrollment on DoctorsInnElite. Secure payment process to access your MDCAT preparation course instantly after purchase.')
@section('meta_keywords', 'DoctorsInnElite checkout, enroll MDCAT course, buy MDCAT course Pakistan, course payment')
@section('content')

    <div class="breadcumb-wrapper" data-bg-src="{{ asset('frontend/img/bg/hero-bg1.webp') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Checkout</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('course') }}">Courses</a></li>
                            <li><a href="{{ route('course-details', $course['slug']) }}">{{ $course['title'] }}</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="th-checkout-wrapper space-top space-extra-bottom">
        <div class="container">

            {{-- Progress Steps --}}
            <div class="d-flex align-items-center justify-content-center gap-0 mb-5">
                <div class="d-flex align-items-center gap-2">
                    <div class="legacy-inline-820ce5a5d7">
                        <i class="fas fa-check legacy-inline-c42f23b8ec"></i>
                    </div>
                    <span class="fw-semibold d-none d-sm-inline legacy-inline-8b2ba38aab">Course Selected</span>
                </div>
                <div class="legacy-inline-8dc038f54c"></div>
                <div class="d-flex align-items-center gap-2">
                    <div class="legacy-inline-820ce5a5d7">2</div>
                    <span class="fw-semibold d-none d-sm-inline legacy-inline-8b2ba38aab">Checkout</span>
                </div>
                <div class="legacy-inline-b56d808c36"></div>
                <div class="d-flex align-items-center gap-2">
                    <div class="legacy-inline-c4693336f7">3</div>
                    <span class="fw-semibold d-none d-sm-inline legacy-inline-ec316ba5aa">Confirmed</span>
                </div>
            </div>

            <div class="row g-4">

                {{-- LEFT: Billing + Payment --}}
                <div class="col-lg-7">

                    {{-- Billing Details --}}
                    <div class="p-4 mb-4 rounded-3 legacy-inline-f5b3c0b899">
                        <h5 class="fw-bold mb-4 pb-3 legacy-inline-ea23b2ede6">
                            <i class="fal fa-user-circle me-2 legacy-inline-a5bc43493a"></i>
                            Your Details
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold legacy-inline-636b556886">First Name <span class="legacy-inline-649af0a300">*</span></label>
                                <input type="text" id="first-name" class="form-control co-input" placeholder="Ahmed" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold legacy-inline-636b556886">Last Name <span class="legacy-inline-649af0a300">*</span></label>
                                <input type="text" id="last-name" class="form-control co-input" placeholder="Khan" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold legacy-inline-636b556886">Email Address <span class="legacy-inline-649af0a300">*</span></label>
                                <input type="email" id="email-address" class="form-control co-input" placeholder="ahmed@example.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold legacy-inline-636b556886">Phone Number <span class="legacy-inline-649af0a300">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text legacy-inline-5c985e6a6f">🇵🇰 +92</span>
                                    <input type="tel" id="phone-number" class="form-control co-input legacy-inline-b491dfc26f" placeholder="3XX XXXXXXX" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold legacy-inline-636b556886">City</label>
                                <select class="form-select co-input" id="city-select">
                                    <option value="">Select your city</option>
                                    <option>Karachi</option>
                                    <option>Lahore</option>
                                    <option>Islamabad</option>
                                    <option>Rawalpindi</option>
                                    <option>Faisalabad</option>
                                    <option>Multan</option>
                                    <option>Peshawar</option>
                                    <option>Quetta</option>
                                    <option>Hyderabad</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Method --}}
                    <div class="p-4 rounded-3 legacy-inline-f5b3c0b899">
                        <h5 class="fw-bold mb-4 pb-3 legacy-inline-ea23b2ede6">
                            <i class="fal fa-credit-card me-2 legacy-inline-a5bc43493a"></i>
                            Payment Method
                        </h5>

                        {{-- EasyPaisa --}}
                        <div class="mb-3">
                            <label class="pm-label d-flex align-items-center gap-3 p-3 rounded-3 w-100 legacy-inline-77b8bb1eb4" for="pm-easypaisa"
                               >
                                <input type="radio" id="pm-easypaisa" name="payment_method" value="easypaisa" class="pm-radio d-none" checked>
                                <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0 legacy-inline-5fb10b7ed8"
                                   >
                                    <span class="legacy-inline-2bd4cdc14e">EASY<br>PAISA</span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold legacy-inline-300a5081b8">EasyPaisa</div>
                                    <div class="legacy-inline-d141a82f37">Mobile wallet payment</div>
                                </div>
                                <div class="pm-check legacy-inline-04c231f83e">
                                    <i class="fas fa-check legacy-inline-7a896c674f"></i>
                                </div>
                            </label>

                            {{-- EasyPaisa Details --}}
                            <div id="ep-details" class="p-3 mt-2 rounded-3 legacy-inline-a1c7dfdd04">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="fas fa-info-circle legacy-inline-639af1bcc7"></i>
                                    <strong class="legacy-inline-92da0f8236">EasyPaisa Payment Steps:</strong>
                                </div>
                                <ol class="legacy-inline-d40b741a51">
                                    <li>Open <strong>EasyPaisa App</strong> or dial <strong>*786#</strong></li>
                                    <li>Go to <strong>Send Money</strong></li>
                                    <li>Send to account: <strong class="legacy-inline-3857969591">0300-0000000</strong></li>
                                    <li>Amount: <strong class="legacy-inline-a5bc43493a">{{ $course['price'] }}</strong></li>
                                    <li>Upload screenshot below after payment</li>
                                </ol>
                                {{-- Screenshot Upload --}}
                                <div class="p-3 rounded-2 text-center screenshot-upload-trigger">
                                    <i class="fal fa-cloud-upload-alt legacy-inline-a1361680c7"></i>
                                    <div class="legacy-inline-9f1cdbc1ca">Click to upload payment screenshot</div>
                                    <div class="legacy-inline-e11ac94886">PNG, JPG accepted</div>
                                    <input type="file" id="ep-screenshot" accept="image/*" class="d-none">
                                </div>
                                <div id="ep-preview" class="mt-2 text-center legacy-inline-d0466aa33f">
                                    <img id="ep-preview-img" src="" alt="Screenshot preview" class="legacy-inline-9e7f72081d">
                                    <div class="legacy-inline-cd99cec8b7"><i class="fas fa-check-circle me-1"></i>Screenshot ready</div>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-3 p-2 rounded-2 legacy-inline-9efd35317f">
                                    <i class="fab fa-whatsapp legacy-inline-a6222cd554"></i>
                                    <span class="legacy-inline-f0a43f694f">Or WhatsApp screenshot to: <strong>0300-0000000</strong></span>
                                </div>
                            </div>
                        </div>

                        {{-- Bank / Card --}}
                        <div>
                            <label class="pm-label d-flex align-items-center gap-3 p-3 rounded-3 w-100 legacy-inline-77b8bb1eb4" for="pm-card"
                               >
                                <input type="radio" id="pm-card" name="payment_method" value="card" class="pm-radio d-none">
                                <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0 legacy-inline-9d82b2d5b6"
                                   >
                                    <span class="legacy-inline-2c39a84baa">DEBIT/<br>CREDIT</span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold legacy-inline-300a5081b8">Debit / Credit Card</div>
                                    <div class="d-flex align-items-center gap-1 mt-1">
                                        <span class="legacy-inline-4d52e535f8">VISA</span>
                                        <span class="legacy-inline-80ac36fe00">Mastercard</span>
                                        <span class="legacy-inline-1b186e62ce">Unionpay</span>
                                    </div>
                                </div>
                                <div class="pm-check legacy-inline-2ebbdf80b3"></div>
                            </label>

                            {{-- Card Form --}}
                            <div id="card-details" class="p-3 mt-2 rounded-3 legacy-inline-5caa265ea3">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold legacy-inline-0785f1a046">Card Number</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control co-input legacy-inline-7c24dc98c5" id="card-number" placeholder="0000 0000 0000 0000" maxlength="19">
                                            <span class="input-group-text legacy-inline-ca16adc04a">
                                                <i class="fal fa-credit-card"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold legacy-inline-0785f1a046">Name on Card</label>
                                        <input type="text" class="form-control co-input" id="card-name" placeholder="Ahmed Khan">
                                    </div>
                                    <div class="col-7">
                                        <label class="form-label fw-semibold legacy-inline-0785f1a046">Expiry Date</label>
                                        <input type="text" class="form-control co-input" id="card-expiry" placeholder="MM / YY" maxlength="7">
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label fw-semibold legacy-inline-0785f1a046">CVV</label>
                                        <input type="password" class="form-control co-input" id="card-cvv" placeholder="•••" maxlength="4">
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-3 p-2 rounded-2 legacy-inline-de05f3be86">
                                    <i class="fal fa-lock legacy-inline-a5bc43493a"></i>
                                    <span class="legacy-inline-b26f7d5fdf">Your card details are fully encrypted.</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>{{-- /col-lg-7 --}}

                {{-- RIGHT: Course + Order Summary --}}
                <div class="col-lg-5">
                    <div class="rounded-3 sticky-lg-top legacy-inline-37f3785d05">

                        {{-- Course Being Purchased --}}
                        <div class="p-4 mb-4 rounded-3 legacy-inline-f5b3c0b899">
                            <div class="mb-3 legacy-inline-3ce1de5dad">
                                <div class="legacy-inline-d546b3a65a">
                                    <i class="fal fa-shopping-bag me-1"></i> You are buying
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($course['image']) }}" alt="{{ $course['title'] }}"
                                        class="legacy-inline-4a26e1ef43">
                                    <div>
                                        <div class="fw-bold legacy-inline-a2f2cf2680">{{ $course['title'] }}</div>
                                        <div class="legacy-inline-f508abf24f">
                                            <i class="fas fa-star legacy-inline-6630fe8f0f"></i>
                                            {{ $course['rating'] }} &nbsp;·&nbsp;
                                            <i class="fal fa-file-lines legacy-inline-a5bc43493a"></i>
                                            {{ $course['lessons'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Price breakdown --}}
                            @php
                                $hasDiscount = !empty($course['original_price']);
                            @endphp
                            <div class="d-flex justify-content-between mb-2">
                                <span class="legacy-inline-ec316ba5aa">Course Fee</span>
                                <span class="legacy-inline-51273eeeb2">
                                    @if ($hasDiscount)
                                        <del class="legacy-inline-d141a82f37">{{ $course['original_price'] }}</del>
                                    @endif
                                </span>
                            </div>
                            @if ($hasDiscount)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="legacy-inline-ec316ba5aa">
                                        Discount
                                        @if (!empty($course['discount_tag']))
                                            <span class="badge ms-1 rounded-pill px-2 legacy-inline-1f338d948c">{{ $course['discount_tag'] }}</span>
                                        @endif
                                    </span>
                                    <span class="legacy-inline-643950af44">Applied ✓</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between pt-3 mt-1 legacy-inline-15fc8aa8dc">
                                <span class="fw-bold legacy-inline-46a8ffc600">Total</span>
                                <span class="fw-bold legacy-inline-a7641e38c3">{{ $course['price'] }}</span>
                            </div>
                        </div>

                        {{-- Place Order Button --}}
                        <button type="button" id="place-order-btn" class="th-btn w-100 d-block legacy-inline-cdf4351025"
                           >
                            <i class="fal fa-check-circle me-2"></i>Place Order &amp; Pay {{ $course['price'] }}
                        </button>

                        <p class="text-center mt-3 legacy-inline-b26f7d5fdf">
                            <i class="fal fa-lock me-1 legacy-inline-a5bc43493a"></i>
                            Secure checkout — SSL Encrypted
                        </p>

                        {{-- What happens next --}}
                        <div class="mt-3 p-3 rounded-3 legacy-inline-6af74c8978">
                            <div class="fw-semibold mb-2 legacy-inline-f0a43f694f">
                                <i class="fal fa-info-circle me-1 legacy-inline-a5bc43493a"></i>
                                After placing your order:
                            </div>
                            <ul class="legacy-inline-1e6cbf2e9a">
                                <li class="d-flex align-items-center gap-2 mb-2 legacy-inline-b26f7d5fdf">
                                    <i class="fas fa-check-circle flex-shrink-0 legacy-inline-ce3dee6e24"></i>
                                    Payment verified within 24 hours
                                </li>
                                <li class="d-flex align-items-center gap-2 mb-2 legacy-inline-b26f7d5fdf">
                                    <i class="fas fa-check-circle flex-shrink-0 legacy-inline-ce3dee6e24"></i>
                                    Course access activated on confirmation
                                </li>
                                <li class="d-flex align-items-center gap-2 legacy-inline-b26f7d5fdf">
                                    <i class="fas fa-check-circle flex-shrink-0 legacy-inline-ce3dee6e24"></i>
                                    Login details sent via email &amp; WhatsApp
                                </li>
                            </ul>
                        </div>

                        <div class="mt-3 text-center">
                            <a href="{{ route('course-details', $course['slug']) }}" class="legacy-inline-9f1cdbc1ca">
                                <i class="fal fa-arrow-left me-1"></i>Back to course details
                            </a>
                        </div>

                    </div>
                </div>

            </div>{{-- /row --}}

        </div>
    </section>

    {{-- Success Modal --}}
    <div id="success-modal" class="legacy-inline-323a949cd4">
        <div class="text-center p-5 rounded-4 legacy-inline-fd346e93e1">
            <div class="legacy-inline-7bd7763dc9">
                <i class="fas fa-check-circle legacy-inline-3171f46a4a"></i>
            </div>
            <h4 class="fw-bold mb-2 legacy-inline-e550217b62">Order Placed!</h4>
            <p class="legacy-inline-f692d92667">
                Thank you for enrolling in <strong>{{ $course['title'] }}</strong>.<br>
                We'll verify your payment and activate access within <strong>24 hours</strong>.
            </p>
            <div class="mt-3 p-3 rounded-3 legacy-inline-de05f3be86">
                <div class="legacy-inline-b26f7d5fdf">Your Reference Number:</div>
                <div id="order-ref" class="legacy-inline-1cd70a941a">DI-2026-XXXX</div>
            </div>
            <a href="{{ route('my-courses') }}" class="th-btn mt-4 d-block legacy-inline-220bdfdf25">
                <i class="fal fa-graduation-cap me-2"></i>Go to My Courses
            </a>
            <a href="{{ route('home') }}" class="d-block mt-2 legacy-inline-9f1cdbc1ca">Back to Home</a>
        </div>
    </div>

@endsection

@section('extra_js')
    <script src="{{ asset('frontend/js/checkout-page.js') }}"></script>
@endsection
