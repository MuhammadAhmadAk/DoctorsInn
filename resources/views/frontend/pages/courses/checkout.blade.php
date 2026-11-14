@extends('frontend.layouts.main')
@section('title', 'Checkout – ' . $course->title . ' | DoctorsInnElite')
@section('meta_description', 'Complete your enrollment on DoctorsInnElite. Pay securely with EasyPaisa, JazzCash or card and get instant access to your preparation course.')
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
                            <li><a href="{{ route('course-details', $course->slug) }}">{{ $course->title }}</a></li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .co-card { background: #fff; border: 1px solid #ece8f7; border-radius: 8px; }
        .co-heading { font-size: 1rem; font-weight: 700; color: #050310; padding-bottom: 14px; margin-bottom: 20px; border-bottom: 1px solid #f0edf9; }
        .co-label { font-size: .875rem; font-weight: 600; color: #37324d; margin-bottom: 6px; }
        .co-input { border-radius: 8px; border: 1px solid #ddd7ef; padding: 11px 14px; font-size: .95rem; }
        .co-input:focus { border-color: var(--theme-color); box-shadow: 0 0 0 3px rgba(92, 50, 255, .12); }
        .co-pay { border-radius: 8px; padding: 15px 20px; font-weight: 700; }
        .co-wallet { display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 0 10px; border-radius: 6px; font-size: .72rem; font-weight: 800; letter-spacing: .02em; }
        .co-wallet-ep { background: #e8f7ec; color: #1d7a3c; }
        .co-wallet-jc { background: #fdecef; color: #c0122b; }
        .co-wallet-card { background: #eef0fb; color: #33409c; }
        .co-course-img { width: 78px; height: 62px; object-fit: cover; border-radius: 6px; flex-shrink: 0; }
        .co-step { width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; font-weight: 700; }
        .co-note { font-size: .85rem; color: #6d6884; }
    </style>

    <section class="th-checkout-wrapper space-top space-extra-bottom">
        <div class="container">

            {{-- Progress Steps --}}
            <div class="d-flex align-items-center justify-content-center gap-0 mb-5">
                <div class="d-flex align-items-center gap-2">
                    <div class="co-step text-white" style="background: var(--theme-color);"><i class="fas fa-check"></i></div>
                    <span class="fw-semibold d-none d-sm-inline">Course Selected</span>
                </div>
                <div class="mx-2 mx-sm-3 flex-shrink-0" style="height: 2px; width: 56px; background: var(--theme-color);"></div>
                <div class="d-flex align-items-center gap-2">
                    <div class="co-step text-white" style="background: var(--theme-color);">2</div>
                    <span class="fw-semibold d-none d-sm-inline">Checkout</span>
                </div>
                <div class="mx-2 mx-sm-3 flex-shrink-0" style="height: 2px; width: 56px; background: #e4e0f2;"></div>
                <div class="d-flex align-items-center gap-2">
                    <div class="co-step" style="background: #f1eefb; color: #8b85a8;">3</div>
                    <span class="fw-semibold d-none d-sm-inline text-muted">Confirmed</span>
                </div>
            </div>

            {{-- Flash messages --}}
            @if (session('error'))
                <div class="alert alert-danger rounded-3 mb-4"><i class="fal fa-circle-exclamation me-2"></i>{{ session('error') }}</div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning rounded-3 mb-4"><i class="fal fa-triangle-exclamation me-2"></i>{{ session('warning') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success rounded-3 mb-4"><i class="fal fa-circle-check me-2"></i>{{ session('success') }}</div>
            @endif
            @if (session('info'))
                <div class="alert alert-info rounded-3 mb-4"><i class="fal fa-circle-info me-2"></i>{{ session('info') }}</div>
            @endif
            @if (isset($errors) && $errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <i class="fal fa-circle-exclamation me-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <div class="row g-4">

                {{-- LEFT: details + payment --}}
                <div class="col-lg-7">

                    <div class="co-card p-4 p-md-5 mb-4">
                        <h5 class="co-heading">
                            <i class="fal fa-wallet me-2" style="color: var(--theme-color);"></i>
                            Payment
                        </h5>

                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <span class="co-wallet co-wallet-ep">EASYPAISA</span>
                            <span class="co-wallet co-wallet-jc">JAZZCASH</span>
                            <span class="co-wallet co-wallet-card">CARD</span>
                            <span class="co-wallet co-wallet-card">BANK</span>
                        </div>

                        <p class="co-note mb-4">
                            You will enter your wallet or card details on Safepay's secure payment page
                            and come right back here once the payment is done.
                        </p>

                        @if ($pendingOrder)
                            <div class="rounded-3 mb-4 p-3" style="background: #fff8e6; border: 1px solid #f4dfa8;">
                                <div class="fw-semibold mb-1">You have an unfinished payment</div>
                                <p class="co-note mb-3">
                                    Reference <strong>{{ $pendingOrder->reference }}</strong> — {{ $pendingOrder->amountLabel() }}.
                                    If you already paid, verify it now. Otherwise start a fresh payment below.
                                </p>
                                <form method="POST" action="{{ route('checkout.status', $pendingOrder->reference) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-dark" style="border-radius: 8px;">
                                        <i class="fal fa-sync me-1"></i>Verify payment
                                    </button>
                                </form>
                            </div>
                        @endif

                        @if (! $gatewayReady && ! $course->isFree())
                            <div class="alert alert-warning rounded-3">
                                <i class="fal fa-triangle-exclamation me-1"></i>
                                Online payments are being set up. Please contact the academic desk to enroll in this course.
                            </div>
                        @endif

                        @if ($course->isFree())
                            <form method="POST" action="{{ route('courses.enroll', $course->slug) }}">
                                @csrf
                                <button type="submit" class="th-btn w-100 co-pay">
                                    <i class="fal fa-graduation-cap me-2"></i>Enroll Free
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('checkout.pay', $course->slug) }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="co-label" for="co-name">Full Name <span style="color:#d6333f;">*</span></label>
                                        <input type="text" id="co-name" name="name" class="form-control co-input"
                                            value="{{ old('name', auth()->user()->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="co-label" for="co-email">Email <span style="color:#d6333f;">*</span></label>
                                        <input type="email" id="co-email" name="email" class="form-control co-input"
                                            value="{{ old('email', auth()->user()->email) }}" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="co-label" for="co-phone">Mobile Number <span style="color:#d6333f;">*</span></label>
                                        <input type="tel" id="co-phone" name="phone" class="form-control co-input"
                                            value="{{ old('phone', auth()->user()->phone) }}" placeholder="03XX XXXXXXX" required>
                                        <div class="co-note mt-1">Use the same number you will pay from in EasyPaisa or JazzCash.</div>
                                    </div>
                                </div>

                                <button type="submit" class="th-btn w-100 co-pay mt-4" @disabled(! $gatewayReady)>
                                    <i class="fal fa-lock me-2"></i>Continue to Pay {{ $course->priceLabel() }}
                                </button>

                                <p class="text-center co-note mt-3 mb-0">
                                    <i class="fal fa-shield-check me-1"></i>Secure payment. Enrollment activates automatically once payment is confirmed.
                                </p>
                            </form>
                        @endif
                    </div>

                </div>

                {{-- RIGHT: order summary --}}
                <div class="col-lg-5">
                    <div class="co-card p-4 sticky-lg-top" style="top: 120px;">

                        <h5 class="co-heading">Order Summary</h5>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <img src="{{ asset($course->image ?: 'frontend/img/course/course1-1.jpg') }}"
                                alt="{{ $course->title }}" class="co-course-img">
                            <div>
                                <div class="fw-bold" style="color: #050310;">{{ $course->title }}</div>
                                <div class="co-note mt-1">
                                    @if ($course->rating)
                                        <i class="fas fa-star" style="color: var(--theme-color2);"></i>
                                        {{ $course->rating }}
                                    @endif
                                    @if ($course->lessons)
                                        <span class="mx-2">·</span><i class="fal fa-file-lines"></i> {{ $course->lessons }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="co-note">Course Fee</span>
                            <span class="fw-semibold">{{ $course->priceLabel() }}</span>
                        </div>

                        @if ($course->original_price && ! $course->isFree())
                            <div class="d-flex justify-content-between mb-2">
                                <span class="co-note">Regular Fee</span>
                                <span class="co-note"><del>{{ $course->original_price }}</del></span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between pt-3 mt-1" style="border-top: 1px solid #f0edf9;">
                            <span class="fw-bold" style="color: #050310;">Total</span>
                            <span class="fw-bold" style="color: var(--theme-color); font-size: 1.15rem;">{{ $course->priceLabel() }}</span>
                        </div>

                        <div class="rounded-3 mt-4 p-3" style="background: #f8f6fe;">
                            <div class="fw-semibold mb-2" style="font-size: .9rem;">
                                <i class="fal fa-circle-info me-1" style="color: var(--theme-color);"></i>
                                What happens next
                            </div>
                            <div class="co-note d-flex align-items-start gap-2 mb-2">
                                <i class="fas fa-check-circle mt-1" style="color: #1d9e5f;"></i>
                                <span>Pay with EasyPaisa, JazzCash or card on the secure page.</span>
                            </div>
                            <div class="co-note d-flex align-items-start gap-2 mb-2">
                                <i class="fas fa-check-circle mt-1" style="color: #1d9e5f;"></i>
                                <span>We confirm the payment automatically in seconds.</span>
                            </div>
                            <div class="co-note d-flex align-items-start gap-2">
                                <i class="fas fa-check-circle mt-1" style="color: #1d9e5f;"></i>
                                <span>The classroom unlocks on this account immediately.</span>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('course-details', $course->slug) }}" class="co-note">
                                <i class="fal fa-arrow-left me-1"></i>Back to course details
                            </a>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
