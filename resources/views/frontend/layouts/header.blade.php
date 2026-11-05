@php
    $currentUser = auth()->user() ?? session('user');
    $currentUserName = is_array($currentUser) ? ($currentUser['name'] ?? 'Student') : ($currentUser->name ?? 'Student');
    $currentUserEmail = is_array($currentUser) ? ($currentUser['email'] ?? '') : ($currentUser->email ?? '');
    $currentUserAvatar = is_array($currentUser) ? ($currentUser['avatar'] ?? 'frontend/img/testimonial/testi_2_1.png') : ($currentUser->avatar ?? 'frontend/img/testimonial/testi_2_1.png');
@endphp
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

    @yield('extra_css')
</head>

<body>

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
                        <li><a href="{{ route('tests') }}">Mock Tests</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('faq') }}">FAQS</a></li>
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        @php
                            $loggedInUser = auth()->user() ?? session('user');
                        @endphp
                        @if ($loggedInUser)
                            <li><a href="{{ route('student.dashboard') }}" class="fw-bold" style="color: #5C32FF;">Student LMS Portal</a></li>
                            <li><a href="{{ route('student.courses') }}">My Courses</a></li>
                            <li><a href="{{ route('student.tests') }}">Mock Tests</a></li>
                            <li><a href="{{ route('student.elibrary') }}">E-Library Vault</a></li>
                            <li><a href="{{ route('student.settings') }}">Profile &amp; Settings ({{ $loggedInUser['name'] ?? 'Student' }})</a></li>
                            <li><a href="{{ route('logout') }}">Logout</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
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
            <div class="container-fluid px-3 px-xl-5" style="max-width: 1560px;">
                <div class="menu-area">
                    <div class="row align-items-center justify-content-between flex-nowrap">

                        <div class="col-auto flex-shrink-0">
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
                                    <li><a href="{{ route('tests') }}">Mock Tests</a></li>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                </ul>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-lg-none"><i
                                     class="fal fa-bars"></i></button>
                        </div>

                        <div class="col-auto flex-shrink-0">
                            <div class="header-profile-wrap">
                                @if ($currentUser)
                                    {{-- Authenticated Student Profile & Dropdown --}}
                                    <div class="header-profile-controls">
                                        <a href="{{ route('notifications') }}" class="notification-btn" title="Notifications">
                                            <i class="fa-regular fa-bell"></i>
                                            <span class="notification-dot"></span>
                                        </a>

                                        {{-- Clickable Profile Trigger & Menu --}}
                                        <div class="dropdown header-user-dropdown position-relative">
                                            <button class="header-profile-btn" type="button" id="headerUserMenuBtn" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="{{ asset($currentUserAvatar) }}" alt="{{ $currentUserName }}" class="header-profile-avatar">
                                                <span class="header-profile-name d-none d-sm-inline">{{ Str::limit($currentUserName, 15) }}</span>
                                                <i class="fa-solid fa-chevron-down header-profile-chevron ms-1"></i>
                                            </button>

                                            <!-- Dropdown Menu -->
                                            <ul class="dropdown-menu dropdown-menu-end header-profile-menu shadow-lg border-0" aria-labelledby="headerUserMenuBtn">
                                                <li class="header-dropdown-user-info">
                                                    <div class="user-info-name">{{ $currentUserName }}</div>
                                                    @if (!empty($currentUserEmail))
                                                        <div class="user-info-email">{{ $currentUserEmail }}</div>
                                                    @endif
                                                    <span class="user-info-badge">
                                                        <i class="fa-solid fa-circle-check me-1"></i> MDCAT Student
                                                    </span>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li>
                                                    <a href="{{ route('student.dashboard') }}" class="dropdown-item profile-menu-item">
                                                        <i class="fa-solid fa-gauge-high me-2 text-primary"></i>
                                                        <span>LMS Dashboard</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('student.settings') }}" class="dropdown-item profile-menu-item">
                                                        <i class="fa-regular fa-user me-2 text-info"></i>
                                                        <span>My Profile &amp; Settings</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('student.courses') }}" class="dropdown-item profile-menu-item">
                                                        <i class="fa-solid fa-graduation-cap me-2 text-warning"></i>
                                                        <span>My Courses</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('student.tests') }}" class="dropdown-item profile-menu-item">
                                                        <i class="fa-solid fa-list-check me-2 text-success"></i>
                                                        <span>Mock Tests</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('student.elibrary') }}" class="dropdown-item profile-menu-item">
                                                        <i class="fa-solid fa-book-medical me-2 text-secondary"></i>
                                                        <span>E-Library Vault</span>
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider my-1"></li>
                                                <li>
                                                    <a href="{{ route('logout') }}" class="dropdown-item profile-menu-item text-danger">
                                                        <i class="fa-solid fa-arrow-right-from-bracket me-2 text-danger"></i>
                                                        <span>Log Out</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    {{-- Guest / Unauthenticated Visitor View --}}
                                    <div class="header-auth-group">
                                        <a href="{{ route('login') }}" class="header-btn-login">Login</a>
                                        <a href="{{ route('register') }}" class="header-btn-register">Join Now</a>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="smooth-wrapper">
        <div id="smooth-content">
