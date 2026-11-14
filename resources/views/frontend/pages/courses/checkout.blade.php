@extends('frontend.layouts.main')
@section('title', 'Checkout – ' . $course->title . ' | DoctorsInnElite')
@section('meta_description', 'Complete your enrollment on DoctorsInnElite. Pay securely through Safepay and get instant access to your preparation course.')
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
        .co-card { background: #fff; border: 1px solid #ece8f7; border-radius: 8px; box-shadow: 0 12px 32px rgba(5, 3, 16, .04); }
        .co-panel { padding: 32px; }
        .co-section + .co-section { border-top: 1px solid #f0edf9; margin-top: 28px; padding-top: 28px; }
        .co-section-head { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 20px; }
        .co-step-num { width: 26px; height: 26px; border-radius: 50%; background: #f1eefb; color: var(--theme-color); font-size: .8rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px; }
        .co-section-title { font-size: 1.05rem; font-weight: 700; color: #050310; margin: 0 0 2px; }
        .co-section-sub { font-size: .82rem; color: #6d6884; margin: 0; }
        .co-label { font-size: .85rem; font-weight: 600; color: #37324d; margin-bottom: 6px; }
        .co-input { border-radius: 8px; border: 1px solid #ddd7ef; padding: 11px 14px; font-size: .95rem; }
        .co-input:focus { border-color: var(--theme-color); box-shadow: 0 0 0 3px rgba(92, 50, 255, .12); }
        .co-pay { border-radius: 8px; padding: 15px 20px; font-weight: 700; }
        .co-paynote { display: flex; gap: 12px; align-items: flex-start; background: #f8f7fc; border: 1px solid #efecf8; border-radius: 8px; padding: 14px 16px; margin-bottom: 20px; }
        .co-paynote i { color: var(--theme-color); font-size: 1rem; margin-top: 2px; }
        .co-paynote-text { font-size: .85rem; color: #5a5570; line-height: 1.55; margin: 0; }
        .co-trust { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px 22px; margin-top: 16px; }
        .co-trust span { font-size: .78rem; color: #7c7694; display: inline-flex; align-items: center; gap: 6px; }
        .co-trust i { color: #1d9e5f; font-size: .8rem; }
        .co-course-img { width: 84px; height: 66px; object-fit: cover; border-radius: 6px; flex-shrink: 0; }
        .co-note { font-size: .85rem; color: #6d6884; }
        .co-summary-row { display: flex; justify-content: space-between; align-items: center; font-size: .9rem; margin-bottom: 10px; }
        .co-summary-row:last-of-type { margin-bottom: 0; }
        .co-total { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0edf9; margin-top: 16px; padding-top: 16px; }
        .co-total-label { font-weight: 700; color: #050310; }
        .co-total-value { font-weight: 700; color: var(--theme-color); font-size: 1.3rem; line-height: 1; }
        .co-next { border-top: 1px solid #f0edf9; margin-top: 22px; padding-top: 18px; }
        .co-next-title { font-size: .78rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #8b85a8; margin-bottom: 10px; }
        .co-next-item { display: flex; gap: 8px; align-items: flex-start; font-size: .83rem; color: #6d6884; margin-bottom: 7px; }
        .co-next-item:last-child { margin-bottom: 0; }
        .co-next-item i { color: var(--theme-color); margin-top: 3px; font-size: .7rem; }
        .co-steps { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 40px; }
        .co-step-dot { width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 700; flex-shrink: 0; }
        .co-step-line { height: 2px; width: 52px; flex-shrink: 0; margin: 0 10px; }
        .co-step-label { font-size: .85rem; font-weight: 600; margin-left: 8px; }
        @media (max-width: 767.98px) {
            .co-panel { padding: 22px; }
            .co-step-label { display: none; }
            .co-step-line { width: 34px; margin: 0 6px; }
        }
    </style>

    <section class="th-checkout-wrapper space-top space-extra-bottom">
        <div class="container">

            <div class="co-steps">
                <div class="d-flex align-items-center">
                    <div class="co-step-dot text-white" style="background: var(--theme-color);"><i class="fas fa-check" style="font-size: .7rem;"></i></div>
                    <span class="co-step-label" style="color: #050310;">Course</span>
                </div>
                <div class="co-step-line" style="background: var(--theme-color);"></div>
                <div class="d-flex align-items-center">
                    <div class="co-step-dot text-white" style="background: var(--theme-color);">2</div>
                    <span class="co-step-label" style="color: #050310;">Checkout</span>
                </div>
                <div class="co-step-line" style="background: #e9e5f5;"></div>
                <div class="d-flex align-items-center">
                    <div class="co-step-dot" style="background: #f1eefb; color: #8b85a8;">3</div>
                    <span class="co-step-label text-muted">Confirmation</span>
                </div>
            </div>

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

                {{-- LEFT: billing + payment --}}
                <div class="col-lg-7">

                    <div class="co-card co-panel">
                        @if ($course->isFree())
                            <div class="co-section-head">
                                <span class="co-step-num">1</span>
                                <div>
                                    <h2 class="co-section-title">Enrollment</h2>
                                    <p class="co-section-sub">This course is free. Confirm to unlock it right away.</p>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('courses.enroll', $course->slug) }}">
                                @csrf
                                <button type="submit" class="th-btn w-100 co-pay">
                                    <i class="fal fa-graduation-cap me-2"></i>Enroll Free
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('checkout.pay', $course->slug) }}">
                                @csrf

                                <div class="co-section">
                                    <div class="co-section-head">
                                        <span class="co-step-num">1</span>
                                        <div>
                                            <h2 class="co-section-title">Billing details</h2>
                                            <p class="co-section-sub">These details are used for your enrollment record.</p>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="co-label" for="co-name">Full name <span style="color:#d6333f;">*</span></label>
                                            <input type="text" id="co-name" name="name" class="form-control co-input"
                                                value="{{ old('name', auth()->user()->name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="co-label" for="co-email">Email address <span style="color:#d6333f;">*</span></label>
                                            <input type="email" id="co-email" name="email" class="form-control co-input"
                                                value="{{ old('email', auth()->user()->email) }}" required>
                                        </div>
                                        <div class="col-12">
                                            <label class="co-label" for="co-phone">Mobile number <span style="color:#d6333f;">*</span></label>
                                            <input type="tel" id="co-phone" name="phone" class="form-control co-input"
                                                value="{{ old('phone', auth()->user()->phone) }}" placeholder="03XX XXXXXXX" required>
                                            <div class="co-note mt-1">Used for enrollment updates and payment verification.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="co-section">
                                    <div class="co-section-head">
                                        <span class="co-step-num">2</span>
                                        <div>
                                            <h2 class="co-section-title">Payment</h2>
                                            <p class="co-section-sub">Processed securely by Safepay.</p>
                                        </div>
                                    </div>

                                    <div class="co-paynote">
                                        <i class="fal fa-shield-check"></i>
                                        <p class="co-paynote-text">
                                            You will be redirected to Safepay's secure checkout page to complete the payment.
                                            Your payment details are entered there and never stored on DoctorsInn.
                                        </p>
                                    </div>

                                    @if ($pendingOrder)
                                        <div class="rounded-3 mb-4 p-3" style="background: #f8f7fc; border: 1px solid #efecf8;">
                                            <div class="fw-semibold mb-1" style="color: #050310;">Unfinished payment found</div>
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

                                    @if (! $gatewayReady)
                                        <div class="alert alert-warning rounded-3">
                                            <i class="fal fa-triangle-exclamation me-1"></i>
                                            Online payments are being set up. Please contact the academic desk to enroll in this course.
                                        </div>
                                    @endif

                                    <button type="submit" class="th-btn w-100 co-pay" @disabled(! $gatewayReady)>
                                        Continue to Pay {{ $course->priceLabel() }}
                                    </button>

                                    <div class="co-trust">
                                        <span><i class="fas fa-lock"></i>SSL secured</span>
                                        <span><i class="fas fa-bolt"></i>Instant access</span>
                                        <span><i class="fas fa-headset"></i>Support available</span>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>

                </div>

                {{-- RIGHT: order summary --}}
                <div class="col-lg-5">
                    <div class="co-card sticky-lg-top" style="top: 120px; padding: 26px;">

                        <h5 class="co-section-title mb-4">Order summary</h5>

                        <div class="d-flex align-items-center gap-3 pb-4 mb-4" style="border-bottom: 1px solid #f0edf9;">
                            <img src="{{ asset($course->image ?: 'frontend/img/course/course1-1.jpg') }}"
                                alt="{{ $course->title }}" class="co-course-img">
                            <div>
                                <div class="fw-bold" style="color: #050310; line-height: 1.35;">{{ $course->title }}</div>
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

                        <div class="co-summary-row">
                            <span class="co-note">Course fee</span>
                            <span class="fw-semibold" style="color: #050310;">{{ $course->priceLabel() }}</span>
                        </div>

                        @if ($course->original_price && ! $course->isFree())
                            <div class="co-summary-row">
                                <span class="co-note">Regular fee</span>
                                <span class="co-note"><del>{{ $course->original_price }}</del></span>
                            </div>
                        @endif

                        <div class="co-summary-row">
                            <span class="co-note">Processing</span>
                            <span class="co-note">Included</span>
                        </div>

                        <div class="co-total">
                            <span class="co-total-label">Total</span>
                            <span class="co-total-value">{{ $course->priceLabel() }}</span>
                        </div>

                        <div class="co-next">
                            <div class="co-next-title">What happens next</div>
                            <div class="co-next-item">
                                <i class="fas fa-circle"></i>
                                <span>Complete your payment on Safepay's secure page.</span>
                            </div>
                            <div class="co-next-item">
                                <i class="fas fa-circle"></i>
                                <span>Your payment is confirmed automatically, usually within seconds.</span>
                            </div>
                            <div class="co-next-item">
                                <i class="fas fa-circle"></i>
                                <span>The classroom unlocks on this account immediately.</span>
                            </div>
                        </div>

                        <div class="text-center mt-4 pt-3" style="border-top: 1px solid #f0edf9;">
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
