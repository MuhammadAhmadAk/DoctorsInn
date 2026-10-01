@extends('frontend.layouts.main')
@section('title', 'Contact Us | DoctorsInnElite')
@section('meta_description', 'Have a question? Contact DoctorsInnElite team via WhatsApp, email or contact form. We are available 24/7 to help you with your MDCAT preparation journey.')
@section('meta_keywords', 'contact DoctorsInnElite, MDCAT help Pakistan, DoctorsInnElite WhatsApp, medical prep support')
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

    <div class="space-top overflow-hidden contact-area-1 position-relative z-index-common" id="contact-sec">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="title-area text-center">
                        <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">Contact
                                Information</span></h2>
                        <p class="th_fade_anim">Thank you for your interest in Attach Web Agency. We're excited to hear from
                            you and discuss...</p>
                    </div>
                </div>
            </div>

            <div class="row gy-4">
                <div class="col-xl-3 col-md-6">
                    <div class="contact-card th_fade_anim">
                        <div class="box-icon"><i class="fal fa-headset"></i></div>
                        <div class="box-content">
                            <h3 class="box-title">Call Us</h3>
                            <p class="box-text">Any time for flight booking.</p><a class="box-link"
                                href="tel:253245636547">(+253)-2456-36547</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="contact-card th_fade_anim">
                        <div class="box-icon" data-theme-color="#FFBF00"><i class="fal fa-envelope-open-text"></i></div>
                        <div class="box-content">
                            <h3 class="box-title">Official Email</h3>
                            <p class="box-text">Email us for any quires</p><a class="box-link"
                                href="mailto:info@DoctorsInnElite.com">info@DoctorsInnElite.com</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="contact-card th_fade_anim">
                        <div class="box-icon" data-theme-color="#743EF9"><i class="fal fa-map-location-dot"></i>
                        </div>
                        <div class="box-content">
                            <h3 class="box-title">Our Location</h3>
                            <p class="box-text">Visit us today!</p><a class="box-link" href="https://www.google.com/maps">15
                                Maniel Lane, Berlin</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="contact-card th_fade_anim">
                        <div class="box-icon" data-theme-color="#FF5C2A"><i class="fal fa-grid-2"></i></div>
                        <div class="box-content">
                            <h3 class="box-title">Admission Apps</h3>
                            <p class="box-text">App for more details</p><a class="box-link"
                                href="mailto:www.DoctorsInnElite.com">www.DoctorsInnElite.com</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-page-form-wrap space-top">
                <div class="contact-form contact-page-form">
                    <form action="mail.php" method="POST" class="contact-form ajax-contact">
                        <h4 class="form-title">Get in Touch</h4>
                        <div class="row">
                            <div class="col-md-6 form-group style-border3"><input type="text" placeholder="Your Name"
                                    class="form-control"> <i class="fal fa-user"></i>
                            </div>
                            <div class="col-md-6 form-group style-border3"><input type="text" placeholder="Your Email"
                                    class="form-control"> <i class="fal fa-envelope"></i></div>
                            <div class="col-md-6 form-group style-border3"><input type="number" class="form-control"
                                    name="number" id="number" placeholder="Phone Number">
                                <i class="fal fa-phone-alt"></i>
                            </div>
                            <div class="col-md-6 form-group style-border3"><select name="subject" id="subject"
                                    class="form-select">
                                    <option value="" disabled="disabled" selected="selected" hidden="">Select
                                        Subjects</option>
                                    <option value="Software Development">Software Development</option>
                                    <option value="Website Development">Website Development</option>
                                    <option value="Digital Marketing">Digital Marketing</option>
                                    <option value="Business Management">Business Management</option>
                                </select> <i class="fal fa-chevron-down"></i></div>
                            <div class="col-12 form-group style-border3">
                                <textarea name="message" id="message" cols="30" rows="3" class="form-control"
                                    placeholder="Write Message...."></textarea> <i class="fal fa-pencil"></i>
                            </div>
                            <div class="form-group">
                                <div class="custom-checkbox"><input type="checkbox" id="privacyPolicy"> <label
                                        for="privacyPolicy">I agree with the privacy policy</label></div>
                            </div>
                            <div class="form-btn col-12"><button class="th-btn">SEND MESSAGE <svg class="ms-2"
                                        width="16" height="16" viewbox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_458_9379)">
                                            <path
                                                d="M14.0331 2.03512C12.5811 0.471411 1.65895 4.30197 1.66797 5.7005C1.6782 7.28644 5.93336 7.7743 7.11277 8.10524C7.82203 8.30417 8.01197 8.50817 8.1755 9.2519C8.91617 12.6202 9.28803 14.2955 10.1356 14.3329C11.4865 14.3926 15.4502 3.56117 14.0331 2.03512Z"
                                                fill="transparent" stroke="currentColor" stroke-width="1.5">
                                            </path>
                                            <path d="M7.66797 8.33333L10.0013 6" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </g>
                                        <defs>
                                            <clippath id="clip0_458_9379">
                                                <rect width="16" height="16" fill="currentColor"></rect>
                                            </clippath>
                                        </defs>
                                    </svg></button></div>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>

        </div>

        <div class="contact-map space-top">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.7310056272386!2d89.2286059153658!3d24.00527418490799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fe9b97badc6151%3A0x30b048c9fb2129bc!2sAngfuztheme!5e0!3m2!1sen!2sbd!4v1651028958211!5m2!1sen!2sbd"
                allowfullscreen="" loading="lazy"></iframe>
        </div>

    </div>


@endsection
