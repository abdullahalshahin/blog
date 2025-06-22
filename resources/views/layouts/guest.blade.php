<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $page_title ?? config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="{{ asset('onsus/fonts/font.css') }}">
        <link rel="stylesheet" href="{{ asset('onsus/icons/icomoon/style.css') }}">
        <link rel="stylesheet" href="{{ asset('onsus/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('onsus/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('onsus/css/animate.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('onsus/css/styles.css') }}">

        <link rel="shortcut icon" href="{{ asset('onsus/images/logo/short-logo.svg') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('onsus/images/logo/short-logo.svg') }}">

        {{ $style ?? "" }}
    </head>

    <body>
        <button id="goTop">
            <span class="border-progress"></span>
            <span class="icon icon-arrow-right"></span>
        </button>

        <div class="preload preload-container" id="preload">
            <div class="preload-logo">
                <div class="spinner"></div>
            </div>
        </div>

        <div id="wrapper">
            <div class="tf-topbar line-bt">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div class="topbar-left justify-content-xl-start h-100">
                                <p class="body-small text-main-2">
                                    <i class="icon-headphone"></i>
                                    Email:
                                    <a href="mailto:example@support.com" class="text-primary link-secondary fw-semibold">example@support.com</a>
                                </p>
                            </div>
                        </div>

                        <div class="col-xl-6 d-none d-xl-block">
                            <div class="tf-cur justify-content-end bar-lang">
                                <div class="tf-cur-item tf-languages gap-0">
                                    <i class="icon icon-global"></i>
                                    <div class="tf-lans">
                                        <select class="image-select center style-default type-lan">
                                            <option>English</option>
                                            <option>বাংলা</option>
                                        </select>
                                    </div>
                                </div>

                                <a href="#log" data-bs-toggle="modal" class="tf-cur-item link">
                                    <i class="icon-user-3"></i>
                                    <span class="body-small">My account:</span>
                                    <i class="icon-arrow-down"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <header class="tf-header style-2">
                <div class="inner-header p-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-7 d-flex align-items-center">
                                <div class="logo-site">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset('onsus/images/logo/blog_logo.png') }}" alt="Logo" width="120">
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6 d-none d-md-block">
                                <div class="header-center justify-content-end">
                                    <form action="#" class="form-search-product style-2">
                                        <fieldset>
                                            <input type="text" placeholder="Search for posts">
                                        </fieldset>

                                        <button type="submit" class="btn-submit-form">
                                            <i class="icon-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="col-md-3 col-5 d-flex align-items-center justify-content-end">
                                <div class="header-right">
                                    <ul class="nav-icon justify-content-xl-center d-xl-none">
                                        <li class="d-flex align-items-center d-xl-none">
                                            <a href="#mobileMenu" class="mobile-button" data-bs-toggle="offcanvas" aria-controls="mobileMenu">
                                                <span></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-bottom bg-gray-5 d-none d-xl-block">
                    <div class="container relative">
                        <div class="row">
                            <div class="col-xl-12 col-12">
                                <div class="header-bt-left">
                                    <nav class="main-nav-menu">
                                        <ul class="nav-list">
                                            <li class="nav-item pst-unset {{ (Request::segment(1) == "") ? "active" : "" }}">
                                                <a href="{{ url('/') }}" class="item-link link body-md-2 fw-semibold">
                                                    <span>Home</span>
                                                </a>
                                            </li>

                                            <li class="nav-item pst-unset {{ (Request::segment(1) == "posts") ? "active" : "" }}">
                                                <a href="{{ url('posts') }}" class="item-link link body-md-2 fw-semibold">
                                                    <span>Posts</span>
                                                </a>
                                            </li>

                                            <li class="nav-item pst-unset {{ (Request::segment(1) == "faq") ? "active" : "" }}">
                                                <a href="{{ url('faq') }}" class="item-link link body-md-2 fw-semibold">
                                                    <span>FAQ</span>
                                                </a>
                                            </li>

                                            <li class="nav-item pst-unset {{ (Request::segment(1) == "about-us") ? "active" : "" }}">
                                                <a href="{{ url('about-us') }}" class="item-link link body-md-2 fw-semibold">
                                                    <span>About us</span>
                                                </a>
                                            </li>

                                            <li class="nav-item pst-unset {{ (Request::segment(1) == "contact-us") ? "active" : "" }}">
                                                <a href="{{ url('contact-us') }}" class="item-link link body-md-2 fw-semibold">
                                                    <span>Contact us</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            {{ $slot ?? "" }}

            <footer class="tf-footer">
                <div class="ft-body-wrap">
                    <div class="ft-body-inner">
                        <div class="container">
                            <div class="ft-inner flex-wrap flex-xl-nowrap">
                                <div class="ft-logo">
                                    <a href="{{ url('/') }}" class="logo-site">
                                        <img src="{{ asset('onsus/images/logo/blog_logo.png') }}" alt="Logo" width="120">
                                    </a>
                                </div>

                                <ul class="ft-link-wrap w-100 tf-grid-layout md-col-2 lg-col-4">
                                    <li class="footer-col-block">
                                        <h6 class="ft-heading footer-heading-mobile fw-semibold">Get help</h6>
                                        <div class="tf-collapse-content">
                                            <ul class="ft-menu-list">
                                                <li><a href="faq.html" class="link">Terms & Conditions</a></li>
                                                <li><a href="privacy.html" class="link">Privacy Notice</a></li>
                                                <li><a href="faq.html" class="link">FAQs</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="footer-col-block">
                                        <h6 class="ft-heading footer-heading-mobile fw-semibold">Popular categories</h6>
                                        <div class="tf-collapse-content">
                                            <ul class="ft-menu-list">
                                                <li><a href="#" class="link">Personal Development</a></li>
                                                <li><a href="#" class="link">Health & Wellness</a></li>
                                                <li><a href="#" class="link">Food & Recipes</a></li>
                                                <li><a href="#" class="link">Travel</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li class="footer-col-block type-sp-2">
                                        <h6 class="ft-heading footer-heading-mobile fw-semibold">Contact</h6>
                                        <div class="tf-collapse-content">
                                            <ul class="ft-menu-list ft-contact-list">
                                                <li>
                                                    <span class="icon"><i class="icon-location"></i></span>
                                                    <a href="#" class="link">
                                                        8500 Lorem Street
                                                        Chicago, IL 55030 Dolor sit amet
                                                    </a>
                                                </li>

                                                <li>
                                                    <span class="icon"><i class="icon-direction"></i></span>
                                                    <a href="#" class="">
                                                        <span class="text-primary">
                                                            example@support.com
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="ft-body-center bg-gray">
                        <div class="container">
                            <div class="ft-center justify-content-xxl-between">
                                <p class="notice text-white justify-content-xxl-between">
                                    <span class="main-title fw-semibold ">
                                        <img src="{{ asset('onsus/images/mail.svg') }}" alt="">
                                        Get Weekly Insights in Your Inbox
                                    </span>
                                    <span class="body-text-3">
                                        Stay updated with the latest posts, tips, and inspiration from our blog.
                                    </span>
                                </p>

                                <form action="#" class="form-newsletter" method="post" accept-charset="utf-8" data-mailchimp="true">
                                    <div class="subscribe-content">
                                        <fieldset class="email">
                                            <input type="email" name="email-form" class="subscribe-email type-fs-2" placeholder="Enter your email address"
                                                tabindex="0" aria-required="true" required="">
                                        </fieldset>

                                        <div class="button-submit">
                                            <button class="subscribe-button tf-btn btn-large hover-shine" type="submit">
                                                <span class="body-md-2 fw-semibold text-white">
                                                    Subscribe
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="ft-body-bottom">
                        <div class="container">
                            <div class="ft-bottom">
                                <ul class="social-list">
                                    <li><a href="https://www.facebook.com/"><i class="icon-facebook"></i></a></li>
                                    <li><a href="https://x.com/"><i class="icon-x"></i></a></li>
                                    <li><a href="https://www.instagram.com/"><i class="icon-instagram"></i></a></li>
                                    <li><a href="https://www.linkedin.com/"><i class="icon-linkin"></i></a></li>
                                    <li><a href="https://web.whatsapp.com/"><i class="icon-whatapp"></i></a></li>
                                </ul>

                                <ul class="ft-menu-list-2 body-text-3">
                                    <li><a href="blog-grid.html" class="title-sidebar link fw-bold">Latest Posts</a></li>
                                    <li><a href="blog-grid.html" class="title-sidebar link fw-bold">Popular Articles</a></li>
                                    <li><a href="blog-grid.html" class="title-sidebar link fw-bold">Categories</a></li>
                                    <li><a href="blog-grid.html" class="title-sidebar link fw-bold">About the Author</a></li>
                                    <li><a href="blog-grid.html" class="title-sidebar link fw-bold">Contact</a></li>
                                    <li><a href="blog-grid.html" class="title-sidebar link fw-bold"><i class="icon-fire"></i> Privacy Policy</a>
                                    </li>
                                </ul>

                                <p class="nocopy caption text-center">
                                    <span class="fw-medium">{{ config('app.name', 'Laravel') }}.</span> © <script>document.write(new Date().getFullYear())</script>. All right reserved - Developed by <a class="border-bottom" href="https://abc.com">ABC</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        
        <div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
            <span class="icon-close btn-close-mb link" data-bs-dismiss="offcanvas"></span>

            <div class="logo-site">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('onsus/images/logo/blog_logo.png') }}" alt="">
                </a>
            </div>

            <div class="mb-canvas-content">
                <div class="mb-body">
                    <div class="flat-animate-tab">
                        <div class="flat-title-tab-nav-mobile">
                            <ul class="menu-tab-line" role="tablist">
                                <li class="nav-tab-item" role="presentation">
                                    <a href="#main-menu" class="tab-link link fw-semibold active" data-bs-toggle="tab">Menu</a>
                                </li>

                                <li class="br-line type-vertical bg-line h23"></li>

                                <li class="nav-tab-item" role="presentation">
                                    <a href="#category" class="tab-link link fw-semibold" data-bs-toggle="tab">Categories</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane active show" id="main-menu" role="tabpanel">
                                <div class="mb-content-top">
                                    <form action="#" class="form-search">
                                        <fieldset>
                                            <input class="" type="text" placeholder="Search blog posts..." name="text" tabindex="2" value=""
                                                aria-required="true" required="">
                                        </fieldset>
                                        <button type="submit" class="button-submit">
                                            <i class="icon-search"></i>
                                        </button>
                                    </form>
                                    
                                    <ul class="nav-ul-mb" id="wrapper-menu-navigation">
                                        <li class="nav-mb-item">
                                            <a href="index.html" class="mb-menu-link"><span>Home</span></a>
                                        </li>
                                    
                                        <li class="nav-mb-item">
                                            <a href="latest-posts.html" class="mb-menu-link"><span>Latest Posts</span></a>
                                        </li>
                                    
                                        <li class="nav-mb-item">
                                            <a href="#dropdown-menu-categories" class="collapsed mb-menu-link" data-bs-toggle="collapse" aria-expanded="false"
                                                aria-controls="dropdown-menu-categories">
                                                <span>Categories</span>
                                                <span class="btn-open-sub"></span>
                                            </a>
                                    
                                            <div id="dropdown-menu-categories" class="collapse">
                                                <ul class="sub-nav-menu">
                                                    <li><a href="category-tech.html" class="sub-nav-link body-md-2"><span>Tech</span></a></li>
                                                    <li><a href="category-lifestyle.html" class="sub-nav-link body-md-2"><span>Lifestyle</span></a></li>
                                                    <li><a href="category-travel.html" class="sub-nav-link body-md-2"><span>Travel</span></a></li>
                                                    <li><a href="category-tutorials.html" class="sub-nav-link body-md-2"><span>Tutorials</span></a></li>
                                                </ul>
                                            </div>
                                        </li>
                                    
                                        <li class="nav-mb-item">
                                            <a href="about.html" class="mb-menu-link"><span>About</span></a>
                                        </li>
                                    
                                        <li class="nav-mb-item">
                                            <a href="contact.html" class="mb-menu-link"><span>Contact</span></a>
                                        </li>
                                    </ul>                                    
                                </div>

                                <div class="mb-other-content">
                                    <ul class="mb-info">
                                        <li>
                                            <p>
                                                Address:
                                                <a target="_blank" href="https://www.google.com/maps?q=8500LoremStreetChicago,IL55030Dolorsitamet">
                                                    <span class="fw-medium">
                                                        8500 Lorem Street Chicago, IL 55030 Dolor
                                                    </span>
                                                </a>
                                            </p>
                                        </li>
                                        <li>
                                            <p>
                                                Email:
                                                <a href="mailto:example@support.com">
                                                    <span class="fw-medium">example@support.com</span>
                                                </a>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-pane" id="category" role="tabpanel">
                                <div class="mb-content-top">
                                    <ul class="nav-ul-mb">
                                        <li class="nav-mb-item">
                                            <a href="#drd-categories-tech" class="collapsed mb-menu-link" data-bs-toggle="collapse"
                                                aria-expanded="false" aria-controls="drd-categories-tech">
                                                <span>Technology</span>
                                                <span class="btn-open-sub"></span>
                                            </a>
                                            <div id="drd-categories-tech" class="collapse">
                                                <ul class="sub-nav-menu">
                                                    <li><a href="#" class="sub-nav-link">AI & Machine Learning</a></li>
                                                    <li><a href="#" class="sub-nav-link">Software Development</a></li>
                                                </ul>
                                            </div>
                                        </li>
                            
                                        <li class="nav-mb-item">
                                            <a href="#drd-categories-lifestyle" class="collapsed mb-menu-link" data-bs-toggle="collapse"
                                                aria-expanded="false" aria-controls="drd-categories-lifestyle">
                                                <span>Lifestyle</span>
                                                <span class="btn-open-sub"></span>
                                            </a>
                                            <div id="drd-categories-lifestyle" class="collapse">
                                                <ul class="sub-nav-menu">
                                                    <li><a href="#" class="sub-nav-link">Health & Wellness</a></li>
                                                    <li><a href="#" class="sub-nav-link">Productivity</a></li>
                                                </ul>
                                            </div>
                                        </li>
                            
                                        <li class="nav-mb-item">
                                            <a href="#" class="mb-menu-link"><span>Travel</span></a>
                                        </li>
                            
                                        <li class="nav-mb-item">
                                            <a href="#" class="mb-menu-link"><span>Food & Recipes</span></a>
                                        </li>
                            
                                        <li class="nav-mb-item">
                                            <a href="#" class="mb-menu-link"><span>Tutorials</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>

                <div class="mb-bottom">
                    <div class="bottom-bar-language bar-lang">
                        <div class="tf-lans">
                            <select class="image-select center style-default type-lan">
                                <option>English</option>
                                <option>বাংলা</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modalCentered fade modal-log" id="log">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <span class="icon icon-close btn-hide-popup" data-bs-dismiss="modal"></span>

                    <div class="modal-log-wrap list-file-delete">
                        <h5 class="title fw-semibold">Log In</h5>

                        <form action="#" class="form-log">
                            <div class="form-content">
                                <fieldset>
                                    <label class="fw-semibold body-md-2">Email *</label>
                                    <input type="text" placeholder="Enter your email address">
                                </fieldset>

                                <fieldset>
                                    <label class="fw-semibold body-md-2">Password *</label>
                                    <input type="password" placeholder="Enter your password">
                                </fieldset>

                                <a href="#" class="link text-end body-text-3">Forgot password ?</a>
                            </div>

                            <button type="submit" class="tf-btn w-100 text-white">Login</button>

                            <p class="body-text-3 text-center">
                                Don't you have an account?
                                <a href="#register" data-bs-toggle="modal" class="text-primary">
                                    Register
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modalCentered fade modal-log" id="register">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <span class="icon icon-close btn-hide-popup" data-bs-dismiss="modal"></span>

                    <div class="modal-log-wrap list-file-delete">
                        <h5 class="title fw-semibold">Sign Up</h5>

                        <form action="#" class="form-log">
                            <div class="form-content">
                                <fieldset>
                                    <label class="fw-semibold body-md-2">Phone Email *</label>
                                    <input type="text" placeholder="Enter your email address">
                                </fieldset>
                            </div>

                            <button type="button" class="tf-btn w-100 text-white" id="registration_email_submit_button">Submit</button>

                            <p class="body-text-3 text-center">
                                Already have an account?
                                <a href="#log" data-bs-toggle="modal" class="text-primary">
                                    Sign in
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modalCentered fade modal-log" id="otp_verification">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <span class="icon icon-close btn-hide-popup" data-bs-dismiss="modal"></span>

                    <div class="modal-log-wrap list-file-delete">
                        <h5 class="title fw-semibold">OTP Verification</h5>

                        <form action="#" class="form-log">
                            <div class="form-content">
                                <fieldset>
                                    <label class="fw-semibold body-md-2">OTP *</label>
                                    <input type="text" placeholder="Enter OTP">
                                </fieldset>
                            </div>

                            <button type="submit" class="tf-btn w-100 text-white">Next</button>

                            <p class="body-text-3 text-center">
                                Already have an account?
                                <a href="#log" data-bs-toggle="modal" class="text-primary">
                                    Sign in
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('onsus/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('onsus/js/jquery.min.js') }}"></script>
        <script src="{{ asset('onsus/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('onsus/js/carousel.js') }}"></script>
        <script src="{{ asset('onsus/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('onsus/js/lazysize.min.js') }}"></script>
        <script src="{{ asset('onsus/js/count-down.js') }}"></script>
        <script src="{{ asset('onsus/js/wow.min.js') }}"></script>
        <script src="{{ asset('onsus/js/multiple-modal.js') }}"></script>
        <script src="{{ asset('onsus/js/infinityslide.js') }}"></script>
        <script src="{{ asset('onsus/js/main.js') }}"></script>

        {{ $script ?? "" }}
    </body>
</html>
