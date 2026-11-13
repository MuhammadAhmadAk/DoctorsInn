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
    <script>
        (function(){
            var p = document.getElementById('page-preloader');
            if(!p) return;
            var hide = function(){ p.classList.add('is-hidden'); setTimeout(function(){ p.style.display = 'none'; }, 160); };
            if(document.readyState !== 'loading') hide();
            else { document.addEventListener('DOMContentLoaded', hide, { once: true }); setTimeout(hide, 220); }
        })();
    </script>


    <div id="smooth-wrapper">
        <div id="smooth-content">
            @yield('content')
        </div>
    </div>
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewbox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98">
            </path>
        </svg>
    </div>

    <script src="{{ asset('frontend/js/vendor/jquery-3.7.1.min.js') }}" defer></script>
    <script src="{{ asset('frontend/js/app.min.js') }}" defer></script>
    <script src="{{ asset('frontend/js/main.js') }}" defer></script>
    <script src="{{ asset('frontend/js/preloader.js') }}" defer></script>

    @yield('extra_js')

</body>

</html>
