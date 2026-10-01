@extends('frontend.layouts.main')
@section('title', '404 Page Not Found | DoctorsInnElite')
@section('meta_description', 'Oops! The page you are looking for does not exist. Go back to DoctorsInnElite homepage and continue your MDCAT preparation.')
@section('meta_keywords', 'DoctorsInnElite 404, page not found')
@section('content')

    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">404 Error</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>404 Error</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="space">
        <div class="container">
            <div class="error-img"><img src="{{ asset('frontend/img/home/icons/error.svg') }}" alt="404 image"></div>
            <div class="error-content">
                <h2 class="error-title fw-extrabold mt-50">Oops! That Page Can't Be Found</h2>
                <p class="error-text">It looks like nothing was found at this location. Try going back to the
                    homepage or browsing our courses.</p>
                <a href="{{ route('home') }}" class="th-btn"><svg class="me-2" width="16" height="14"
                        viewbox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.52829 0C7.52829 0.6962 6.83835 1.738 6.14089 2.61293C5.24275 3.7394 4.17089 4.72347 2.94095 5.4748C2.01955 6.0374 0.900688 6.57747 0.0018879 6.57747M7.52829 13.1712C7.52829 12.475 6.83835 11.4332 6.14089 10.5583C5.24275 9.43187 4.17089 8.44773 2.94095 7.6964C2.01955 7.1338 0.900688 6.59373 0.0018879 6.59373M0.0018879 6.5856H15.0547"
                            stroke="currentColor" stroke-width="1.5"></path>
                    </svg> Back To Home</a>
            </div>
        </div>
    </section>

@endsection
