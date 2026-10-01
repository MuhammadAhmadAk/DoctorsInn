<!doctype html>
<html class="no-js" lang="zxx" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'DoctorsInnElite')</title>
    <meta name="author" content="DoctorsInnElite">
    <meta name="description" content="@yield('meta_description', 'DoctorsInnElite - Online course & Education Platform')">
    <meta name="keywords" content="@yield('meta_keywords', 'DoctorsInnElite, MDCAT, online courses')">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">

    <link rel="shortcut icon" href="{{ asset('frontend/img/logo/favicon.svg') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('frontend/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/fonts.css') }}">
</head>

<body class="th-magic-cursor">

    <div id="magic-cursor" class="cursor-black-bg">
        <div id="ball"></div>
    </div>

    <div class="page-preloader" id="page-preloader" role="status" aria-label="Page is loading">
        <div class="loading-container" aria-hidden="true">
            <div class="loading"></div>
            <img class="loading-icon" src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="">
        </div>
    </div>

    <div class="th-menu-wrapper">
        <div class="th-menu-area text-center"><button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="th-menu-content">

                <div class="mobile-logo">
                    <a href="{{ route('home') }}"><img src="{{ asset('frontend/img/logo/logo.svg') }}"
                            alt="DoctorsInnElite"></a>
                </div>

                <div class="th-mobile-menu">
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('course') }}">Courses</a></li>
                        <li><a href="{{ route('e-library') }}">E-Library</a></li>
                        <li><a href="{{ route('faq') }}">FAQS</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('my-courses') }}">My Courses</a></li>
                        <li><a href="{{ route('profile') }}">My Profile</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>

                <div class="th-mobile-menu-bottom">
                    <div class="contact-info-wrap">
                        <div class="contact-info"><i class="fa-regular fa-envelope"></i><a
                                href="mailto:info@DoctorsInnElite.com">info@DoctorsInnElite.com</a></div>
                        <div class="contact-info"><i class="fa-regular fa-phone"></i><a href="tel:256214203215">256 214
                                203 215</a></div>
                    </div>
                    <div class="th-social style4"><a href="https://www.facebook.com/"><i
                                class="fab fa-facebook-f"></i></a> <a href="https://www.twitter.com/"><i
                                class="fab fa-twitter"></i></a> <a href="https://www.linkedin.com/"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a> <a
                            href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <header class="th-header header-default">
        <div class="sticky-wrapper">
            <div class="container">
                <div class="menu-area">
                    <div class="row align-items-center justify-content-between">

                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('frontend/img/logo/logo.svg') }}"
                                        alt="DoctorsInnElite"></a>
                            </div>
                        </div>

                        <div class="col-auto">
                            <nav class="main-menu d-none d-lg-inline-block">
                                <ul>
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('about') }}">About Us</a></li>
                                    <li><a href="{{ route('course') }}">Courses</a></li>
                                    <li><a href="{{ route('e-library') }}">E-Library</a></li>
                                    {{-- <li><a href="{{ route('my-courses') }}">My Courses</a></li> --}}
                                    <li><a href="{{ route('faq') }}">FAQS</a></li>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                </ul>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-lg-none"><i
                                    class="fal fa-bars"></i></button>
                        </div>

                        <div class="col-auto d-none d-xl-block">
                            <div class="header-profile-wrap">
                                <a href="{{ route('register') }}" class="th-btn">JOIN NOW <svg class="ms-2"
                                        width="16" height="14" viewbox="0 0 16 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0"
                                            stroke="currentColor" stroke-width="1.5"></path>
                                    </svg> </a>

                                {{-- <div class="header-profile-controls">
                                    <a href="{{ route('notifications') }}" class="notification-btn"
                                        title="Notifications">
                                        <i class="fa-regular fa-bell"></i>
                                        <span class="notification-dot"></span>
                                    </a>

                                    <div class="profile-avatar-trigger">
                                        <img src="{{ asset('frontend/img/testimonial/testi_2_1.png') }}"
                                            alt="Ahmed Khan" class="avatar-img">

                                        <!-- Dropdown Menu -->
                                        <div class="profile-dropdown-menu">
                                            <a href="{{ route('profile') }}" class="dropdown-item">
                                                <i class="fa-regular fa-user"></i>
                                                <span>My Profile</span>
                                            </a>
                                            <a href="javascript:void(0)" class="dropdown-item logout-link">
                                                <i class="fa-regular fa-power-off"></i>
                                                <span>Log Out</span>
                                            </a>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="smooth-wrapper">
        <div id="smooth-content">
