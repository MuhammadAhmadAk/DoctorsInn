@extends('frontend.layouts.main')
@section('title', 'FAQs | DoctorsInnElite')
@section('meta_description', 'Got questions about DoctorsInnElite courses, enrollment, payment or MDCAT preparation? Find answers to all frequently asked questions here.')
@section('meta_keywords', 'DoctorsInnElite FAQ, MDCAT course questions, how to enroll MDCAT course, MDCAT preparation questions Pakistan')
@section('content')


    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Faq’s</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Faq’s</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space">
        <div class="container">
            <div class="row gy-40 gx-80 justify-content-center justify-content-lg-start">
                <div class="col-xl-5">
                    <div class="title-area"><span class="sub-title text-theme th_fade_anim"><img
                                src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">Faq’s</span>
                        <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">Frequently Asked
                                have any questions?</span></h2>
                        <p class="th_fade_anim">These events—such as seminars, workshops, exhibitions, and conferences—offer
                            valuable opportunities for participants to engage with the latest educational trends,
                            technologies, and methodologies. Education events often
                            feature keynote speakers,</p>
                    </div>
                    <ul class="nav nav-tabs faq-tabs th_fade_anim" role="tablist">
                        <li class="nav-item" role="presentation"><button class="nav-link th-btn style-border5 active"
                                id="faq-tab1" data-bs-toggle="tab" data-bs-target="#faq-tab1-pane" type="button"
                                role="tab" aria-controls="faq-tab1-pane" aria-selected="true">General Questions <svg
                                    class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link th-btn style-border5"
                                id="faq-tab2" data-bs-toggle="tab" data-bs-target="#faq-tab2-pane" type="button"
                                role="tab" aria-controls="faq-tab2-pane" aria-selected="false">Regular Questions
                                <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link th-btn style-border5"
                                id="faq-tab3" data-bs-toggle="tab" data-bs-target="#faq-tab3-pane" type="button"
                                role="tab" aria-controls="faq-tab3-pane" aria-selected="false">Advance Questions
                                <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link th-btn style-border5"
                                id="faq-tab4" data-bs-toggle="tab" data-bs-target="#faq-tab4-pane" type="button"
                                role="tab" aria-controls="faq-tab4-pane" aria-selected="false">Beginner
                                Questions <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link th-btn style-border5"
                                id="faq-tab5" data-bs-toggle="tab" data-bs-target="#faq-tab5-pane" type="button"
                                role="tab" aria-controls="faq-tab5-pane" aria-selected="false">Intermediate
                                Questions <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link th-btn style-border5"
                                id="faq-tab6" data-bs-toggle="tab" data-bs-target="#faq-tab6-pane" type="button"
                                role="tab" aria-controls="faq-tab6-pane" aria-selected="false">Expert Questions
                                <svg class="ms-2" width="16" height="14" viewbox="0 0 16 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg></button></li>
                    </ul>
                </div>
                <div class="col-xl-7">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="faq-tab1-pane" role="tabpanel"
                            aria-labelledby="faq-tab1" tabindex="0">
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-card style2 active">
                                    <div class="accordion-header" id="collapse-item-1"><button class="accordion-button"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse-1"
                                            aria-expanded="true" aria-controls="collapse-1">What is online education
                                            learning?</button></div>
                                    <div id="collapse-1" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-2"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-2" aria-expanded="false"
                                            aria-controls="collapse-2">Do I need to attend
                                            classes at specific times?</button></div>
                                    <div id="collapse-2" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-3"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-3" aria-expanded="false"
                                            aria-controls="collapse-3">Are online courses
                                            recognized by employers?</button></div>
                                    <div id="collapse-3" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-4"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-4" aria-expanded="false"
                                            aria-controls="collapse-4">What are the
                                            benefits of online courses?</button></div>
                                    <div id="collapse-4" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-5"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-5" aria-expanded="false"
                                            aria-controls="collapse-5">How do online
                                            courses compare to traditional education?</button></div>
                                    <div id="collapse-5" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-6"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-6" aria-expanded="false"
                                            aria-controls="collapse-6">Can online courses
                                            help with career advancement?</button></div>
                                    <div id="collapse-6" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-7"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-7" aria-expanded="false"
                                            aria-controls="collapse-7">What platforms
                                            offer the best online courses?</button></div>
                                    <div id="collapse-7" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-8"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-8" aria-expanded="false"
                                            aria-controls="collapse-8">Are there any
                                            drawbacks to online learning?</button></div>
                                    <div id="collapse-8" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-9"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-9" aria-expanded="false"
                                            aria-controls="collapse-9">How to choose the
                                            right online course for your career?</button></div>
                                    <div id="collapse-9" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-10"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-10" aria-expanded="false"
                                            aria-controls="collapse-10">What skills can
                                            you gain from online courses?</button></div>
                                    <div id="collapse-10" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="faq-tab2-pane" role="tabpanel" aria-labelledby="faq-tab2"
                            tabindex="0">
                            <div class="accordion" id="faqAccordion2">
                                <div class="accordion-card style2 active">
                                    <div class="accordion-header" id="collapse-item-11"><button class="accordion-button"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse-11"
                                            aria-expanded="true" aria-controls="collapse-11">What is online education
                                            learning?</button></div>
                                    <div id="collapse-11" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-12"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-12" aria-expanded="false"
                                            aria-controls="collapse-12">Do I need to
                                            attend classes at specific times?</button></div>
                                    <div id="collapse-12" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-13"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-13" aria-expanded="false"
                                            aria-controls="collapse-13">Are online courses
                                            recognized by employers?</button></div>
                                    <div id="collapse-13" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-14"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-14" aria-expanded="false"
                                            aria-controls="collapse-14">What are the
                                            benefits of online courses?</button></div>
                                    <div id="collapse-14" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-15"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-15" aria-expanded="false"
                                            aria-controls="collapse-15">How do online
                                            courses compare to traditional education?</button></div>
                                    <div id="collapse-15" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-16"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-16" aria-expanded="false"
                                            aria-controls="collapse-16">Can online courses
                                            help with career advancement?</button></div>
                                    <div id="collapse-16" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-17"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-17" aria-expanded="false"
                                            aria-controls="collapse-17">What platforms
                                            offer the best online courses?</button></div>
                                    <div id="collapse-17" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-18"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-18" aria-expanded="false"
                                            aria-controls="collapse-18">Are there any
                                            drawbacks to online learning?</button></div>
                                    <div id="collapse-18" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-19"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-19" aria-expanded="false"
                                            aria-controls="collapse-19">How to choose the
                                            right online course for your career?</button></div>
                                    <div id="collapse-19" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-20"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-20" aria-expanded="false"
                                            aria-controls="collapse-20">What skills can
                                            you gain from online courses?</button></div>
                                    <div id="collapse-20" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion2">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="faq-tab3-pane" role="tabpanel" aria-labelledby="faq-tab3"
                            tabindex="0">
                            <div class="accordion" id="faqAccordion3">
                                <div class="accordion-card style2 active">
                                    <div class="accordion-header" id="collapse-item-21"><button class="accordion-button"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse-21"
                                            aria-expanded="true" aria-controls="collapse-21">What is online education
                                            learning?</button></div>
                                    <div id="collapse-21" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-22"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-22" aria-expanded="false"
                                            aria-controls="collapse-22">Do I need to
                                            attend classes at specific times?</button></div>
                                    <div id="collapse-22" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-23"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-23" aria-expanded="false"
                                            aria-controls="collapse-23">Are online courses
                                            recognized by employers?</button></div>
                                    <div id="collapse-23" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-24"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-24" aria-expanded="false"
                                            aria-controls="collapse-24">What are the
                                            benefits of online courses?</button></div>
                                    <div id="collapse-24" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-25"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-25" aria-expanded="false"
                                            aria-controls="collapse-25">How do online
                                            courses compare to traditional education?</button></div>
                                    <div id="collapse-25" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-26"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-26" aria-expanded="false"
                                            aria-controls="collapse-26">Can online courses
                                            help with career advancement?</button></div>
                                    <div id="collapse-26" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-27"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-27" aria-expanded="false"
                                            aria-controls="collapse-27">What platforms
                                            offer the best online courses?</button></div>
                                    <div id="collapse-27" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-28"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-28" aria-expanded="false"
                                            aria-controls="collapse-28">Are there any
                                            drawbacks to online learning?</button></div>
                                    <div id="collapse-28" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-29"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-29" aria-expanded="false"
                                            aria-controls="collapse-29">How to choose the
                                            right online course for your career?</button></div>
                                    <div id="collapse-29" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-30"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-30" aria-expanded="false"
                                            aria-controls="collapse-30">What skills can
                                            you gain from online courses?</button></div>
                                    <div id="collapse-30" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion3">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="faq-tab4-pane" role="tabpanel" aria-labelledby="faq-tab4"
                            tabindex="0">
                            <div class="accordion" id="faqAccordion4">
                                <div class="accordion-card style2 active">
                                    <div class="accordion-header" id="collapse-item-31"><button class="accordion-button"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse-31"
                                            aria-expanded="true" aria-controls="collapse-31">What is online education
                                            learning?</button></div>
                                    <div id="collapse-31" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-32"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-32" aria-expanded="false"
                                            aria-controls="collapse-32">Do I need to
                                            attend classes at specific times?</button></div>
                                    <div id="collapse-32" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-33"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-33" aria-expanded="false"
                                            aria-controls="collapse-33">Are online courses
                                            recognized by employers?</button></div>
                                    <div id="collapse-33" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-34"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-34" aria-expanded="false"
                                            aria-controls="collapse-34">What are the
                                            benefits of online courses?</button></div>
                                    <div id="collapse-34" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-35"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-35" aria-expanded="false"
                                            aria-controls="collapse-35">How do online
                                            courses compare to traditional education?</button></div>
                                    <div id="collapse-35" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-36"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-36" aria-expanded="false"
                                            aria-controls="collapse-36">Can online courses
                                            help with career advancement?</button></div>
                                    <div id="collapse-36" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-37"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-37" aria-expanded="false"
                                            aria-controls="collapse-37">What platforms
                                            offer the best online courses?</button></div>
                                    <div id="collapse-37" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-38"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-38" aria-expanded="false"
                                            aria-controls="collapse-38">Are there any
                                            drawbacks to online learning?</button></div>
                                    <div id="collapse-38" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-39"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-39" aria-expanded="false"
                                            aria-controls="collapse-39">How to choose the
                                            right online course for your career?</button></div>
                                    <div id="collapse-39" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-40"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-40" aria-expanded="false"
                                            aria-controls="collapse-40">What skills can
                                            you gain from online courses?</button></div>
                                    <div id="collapse-40" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion4">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="faq-tab5-pane" role="tabpanel" aria-labelledby="faq-tab5"
                            tabindex="0">
                            <div class="accordion" id="faqAccordion5">
                                <div class="accordion-card style2 active">
                                    <div class="accordion-header" id="collapse-item-41"><button class="accordion-button"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse-41"
                                            aria-expanded="true" aria-controls="collapse-41">What is online education
                                            learning?</button></div>
                                    <div id="collapse-41" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-42"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-42" aria-expanded="false"
                                            aria-controls="collapse-42">Do I need to
                                            attend classes at specific times?</button></div>
                                    <div id="collapse-42" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-43"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-43" aria-expanded="false"
                                            aria-controls="collapse-43">Are online courses
                                            recognized by employers?</button></div>
                                    <div id="collapse-43" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-44"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-44" aria-expanded="false"
                                            aria-controls="collapse-44">What are the
                                            benefits of online courses?</button></div>
                                    <div id="collapse-44" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-45"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-45" aria-expanded="false"
                                            aria-controls="collapse-45">How do online
                                            courses compare to traditional education?</button></div>
                                    <div id="collapse-45" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-46"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-46" aria-expanded="false"
                                            aria-controls="collapse-46">Can online courses
                                            help with career advancement?</button></div>
                                    <div id="collapse-46" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-47"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-47" aria-expanded="false"
                                            aria-controls="collapse-47">What platforms
                                            offer the best online courses?</button></div>
                                    <div id="collapse-47" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-48"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-48" aria-expanded="false"
                                            aria-controls="collapse-48">Are there any
                                            drawbacks to online learning?</button></div>
                                    <div id="collapse-48" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-49"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-49" aria-expanded="false"
                                            aria-controls="collapse-49">How to choose the
                                            right online course for your career?</button></div>
                                    <div id="collapse-49" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-50"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-50" aria-expanded="false"
                                            aria-controls="collapse-50">What skills can
                                            you gain from online courses?</button></div>
                                    <div id="collapse-50" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion5">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="faq-tab6-pane" role="tabpanel" aria-labelledby="faq-tab6"
                            tabindex="0">
                            <div class="accordion" id="faqAccordion6">
                                <div class="accordion-card style2 active">
                                    <div class="accordion-header" id="collapse-item-51"><button class="accordion-button"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse-51"
                                            aria-expanded="true" aria-controls="collapse-51">What is online education
                                            learning?</button></div>
                                    <div id="collapse-51" class="accordion-collapse collapse show"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-52"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-52" aria-expanded="false"
                                            aria-controls="collapse-52">Do I need to
                                            attend classes at specific times?</button></div>
                                    <div id="collapse-52" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-53"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-53" aria-expanded="false"
                                            aria-controls="collapse-53">Are online courses
                                            recognized by employers?</button></div>
                                    <div id="collapse-53" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-54"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-54" aria-expanded="false"
                                            aria-controls="collapse-54">What are the
                                            benefits of online courses?</button></div>
                                    <div id="collapse-54" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-55"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-55" aria-expanded="false"
                                            aria-controls="collapse-55">How do online
                                            courses compare to traditional education?</button></div>
                                    <div id="collapse-55" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-56"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-56" aria-expanded="false"
                                            aria-controls="collapse-56">Can online courses
                                            help with career advancement?</button></div>
                                    <div id="collapse-56" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-57"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-57" aria-expanded="false"
                                            aria-controls="collapse-57">What platforms
                                            offer the best online courses?</button></div>
                                    <div id="collapse-57" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-58"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-58" aria-expanded="false"
                                            aria-controls="collapse-58">Are there any
                                            drawbacks to online learning?</button></div>
                                    <div id="collapse-58" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-59"><button
                                            class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse-59" aria-expanded="false"
                                            aria-controls="collapse-59">How to choose the
                                            right online course for your career?</button></div>
                                    <div id="collapse-59" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-card style2">
                                    <div class="accordion-header" id="collapse-item-60"><button
                                            class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse-60"
                                            aria-expanded="false" aria-controls="collapse-60">What skills can
                                            you gain from online courses?</button></div>
                                    <div id="collapse-60" class="accordion-collapse collapse"
                                        data-bs-parent="#faqAccordion6">
                                        <div class="accordion-body">
                                            <p class="faq-text">Online education allows students to learn through digital
                                                platforms using the internet. It includes video lessons, live classes,
                                                assignments, and discussions — all accessible anytime, anywhere.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
