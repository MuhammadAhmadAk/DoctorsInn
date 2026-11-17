@extends('frontend.layouts.main')
@section('title', 'Contact Us | DoctorsInnElite')
@section('meta_description', 'Have a question? Contact the DoctorsInnElite team by email, phone or WhatsApp. We usually reply within one business day.')
@section('meta_keywords', 'contact DoctorsInnElite, MDCAT help Pakistan, DoctorsInnElite WhatsApp, medical prep support')

@section('extra_css')
    <link rel="stylesheet" href="{{ asset('frontend/css/contact.css') }}?v={{ filemtime(public_path('frontend/css/contact.css')) }}">
@endsection

@section('content')

    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Contact Us</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="di-contact space-top" id="contact-sec">
        <div class="container">
            <div class="row gy-5">

                {{-- Left: intro + contact details --}}
                <div class="col-lg-5">
                    <span class="di-contact-badge"><i class="fal fa-envelope"></i> Contact</span>

                    <h2 class="di-contact-title">How can we help you today?</h2>

                    <p class="di-contact-lead">
                        Our dedicated student support team is just a message or a call away — from course
                        guidance and admissions to payments and technical help.
                    </p>

                    <ul class="di-contact-list">
                        <li>
                            <span class="di-contact-icon"><i class="fal fa-envelope-open-text"></i></span>
                            <div>
                                <span class="di-contact-label">Email us</span>
                                <a class="di-contact-value"
                                    href="mailto:{{ $cms['contact_email_1'] ?? 'info@doctorsinnelite.com' }}">{{ $cms['contact_email_1'] ?? 'info@doctorsinnelite.com' }}</a>
                            </div>
                        </li>
                        <li>
                            <span class="di-contact-icon"><i class="fal fa-phone-alt"></i></span>
                            <div>
                                <span class="di-contact-label">Call us</span>
                                <a class="di-contact-value"
                                    href="tel:{{ preg_replace('/[^0-9+]/', '', $cms['contact_phone_1'] ?? '+923001234567') }}">{{ $cms['contact_phone_1'] ?? '+92 300 1234567' }}</a>
                            </div>
                        </li>
                        <li>
                            <span class="di-contact-icon"><i class="fab fa-whatsapp"></i></span>
                            <div>
                                <span class="di-contact-label">WhatsApp</span>
                                <a class="di-contact-value" href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cms['whatsapp_number'] ?? '923001234567') }}"
                                    target="_blank" rel="noopener">Chat with our team</a>
                            </div>
                        </li>
                    </ul>
                </div>

                {{-- Right: form card --}}
                <div class="col-lg-7">
                    <div class="di-contact-card" id="contact-form">
                        <h3 class="di-form-title">Send us a message</h3>
                        <p class="di-form-sub">Fill in the form below and our team will get back to you within one business day.</p>

                        @if (session('contact_success'))
                            <div class="di-contact-alert is-success" role="status">
                                <i class="fal fa-check-circle"></i>
                                <span>{{ session('contact_success') }}</span>
                            </div>
                        @endif

                        @if (session('contact_error'))
                            <div class="di-contact-alert is-error" role="alert">
                                <i class="fal fa-exclamation-circle"></i>
                                <span>{{ session('contact_error') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="di-contact-alert is-error" role="alert">
                                <i class="fal fa-exclamation-circle"></i>
                                <span>Please check the highlighted fields and try again.</span>
                            </div>
                        @endif

                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf

                            <div class="di-hp" aria-hidden="true">
                                <label for="c-website">Website</label>
                                <input type="text" id="c-website" name="website" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="row gy-3">
                                <div class="col-sm-6">
                                    <label class="di-label" for="c-first">First name<span class="di-req">*</span></label>
                                    <input type="text" id="c-first" name="first_name"
                                        class="di-input @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name') }}" placeholder="Ali" required maxlength="60"
                                        autocomplete="given-name">
                                    @error('first_name')
                                        <p class="di-field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="di-label" for="c-last">Last name<span class="di-req">*</span></label>
                                    <input type="text" id="c-last" name="last_name"
                                        class="di-input @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name') }}" placeholder="Khan" required maxlength="60"
                                        autocomplete="family-name">
                                    @error('last_name')
                                        <p class="di-field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="di-label" for="c-email">Email address<span class="di-req">*</span></label>
                                    <input type="email" id="c-email" name="email"
                                        class="di-input @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Enter email" required maxlength="120"
                                        autocomplete="email">
                                    @error('email')
                                        <p class="di-field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <label class="di-label" for="c-phone">Phone number</label>
                                    <input type="tel" id="c-phone" name="phone"
                                        class="di-input @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}" placeholder="Enter phone number" maxlength="25"
                                        autocomplete="tel">
                                    @error('phone')
                                        <p class="di-field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="di-label" for="c-subject">Subject</label>
                                    <select id="c-subject" name="subject"
                                        class="di-input @error('subject') is-invalid @enderror">
                                        <option value="" selected>Choose a topic</option>
                                        <option value="Course & admissions" @selected(old('subject') === 'Course & admissions')>Course &amp; admissions</option>
                                        <option value="Mock tests & results" @selected(old('subject') === 'Mock tests & results')>Mock tests &amp; results</option>
                                        <option value="Payments & billing" @selected(old('subject') === 'Payments & billing')>Payments &amp; billing</option>
                                        <option value="Technical support" @selected(old('subject') === 'Technical support')>Technical support</option>
                                        <option value="General enquiry" @selected(old('subject') === 'General enquiry')>General enquiry</option>
                                    </select>
                                    @error('subject')
                                        <p class="di-field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="di-label" for="c-message">Message<span class="di-req">*</span></label>
                                    <textarea id="c-message" name="message" class="di-input @error('message') is-invalid @enderror"
                                        rows="5" placeholder="Enter a question, feedback or suggestion..." required
                                        maxlength="3000">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="di-field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="di-consent" for="c-consent">
                                        <input type="checkbox" id="c-consent" name="consent" value="1"
                                            @checked(old('consent')) required>
                                        <span>I agree to the <a href="{{ route('privacy-policy') }}" target="_blank"
                                                rel="noopener">privacy policy</a>.</span>
                                    </label>
                                    @error('consent')
                                        <p class="di-field-error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="di-submit">
                                        Send Message
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path
                                                d="M14.0331 2.03512C12.5811 0.471411 1.65895 4.30197 1.66797 5.7005C1.6782 7.28644 5.93336 7.7743 7.11277 8.10524C7.82203 8.30417 8.01197 8.50817 8.1755 9.2519C8.91617 12.6202 9.28803 14.2955 10.1356 14.3329C11.4865 14.3926 15.4502 3.56117 14.0331 2.03512Z"
                                                fill="transparent" stroke="currentColor" stroke-width="1.5"></path>
                                            <path d="M7.66797 8.33333L10.0013 6" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="di-faq">
        <div class="container">
            <div class="row gy-5">

                {{-- Left: FAQ intro --}}
                <div class="col-lg-5">
                    <h2 class="di-faq-title">Frequently asked questions</h2>
                    <p class="di-faq-lead">
                        Got questions about courses, payments or MDCAT preparation? Here are the answers
                        students ask us most.
                    </p>
                    <a class="di-faq-btn" href="{{ route('faq') }}">
                        Browse all FAQs
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M3 10L10 3M10 3H4.5M10 3V8.5" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                </div>

                {{-- Right: accordion --}}
                <div class="col-lg-7">
                    <div class="di-faq-list">
                        <details class="di-faq-item" open>
                            <summary>
                                How do I enroll in a course?
                                <span class="di-faq-icon" aria-hidden="true"></span>
                            </summary>
                            <p>Create your free account, open any course and click Enroll. Once checkout is complete,
                                the course appears in your student dashboard right away.</p>
                        </details>

                        <details class="di-faq-item">
                            <summary>
                                Which payment methods are supported?
                                <span class="di-faq-icon" aria-hidden="true"></span>
                            </summary>
                            <p>Payments are handled through our secure online checkout. If a transaction fails,
                                send us your order details and we will resolve it quickly.</p>
                        </details>

                        <details class="di-faq-item">
                            <summary>
                                How long do I have access to a course?
                                <span class="di-faq-icon" aria-hidden="true"></span>
                            </summary>
                            <p>Once enrolled, the course stays in your account so you can revisit lectures, notes and
                                practice tests whenever you need them.</p>
                        </details>

                        <details class="di-faq-item">
                            <summary>
                                Are mock tests and practice MCQs included?
                                <span class="di-faq-icon" aria-hidden="true"></span>
                            </summary>
                            <p>Yes. Full-length MDCAT mock tests with instant scoring and detailed explanations are part
                                of the preparation experience.</p>
                        </details>

                        <details class="di-faq-item">
                            <summary>
                                I forgot my password. What should I do?
                                <span class="di-faq-icon" aria-hidden="true"></span>
                            </summary>
                            <p>Open the login page and click “Forgot password”. We will email you a 6-digit reset code
                                that expires in 15 minutes.</p>
                        </details>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
