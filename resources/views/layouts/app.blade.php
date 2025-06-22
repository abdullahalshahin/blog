<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $page_title ?? '' }} {{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('hyper/images/favicon.ico') }}">

        <link href="{{ asset('hyper/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('hyper/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
        <link href="{{ asset('hyper/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />

        {{ $style ?? '' }}
    </head>
    <body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":{{ (Auth::user()->theme_color == "dark") ? "true" : "false" }}, "showRightSidebarOnStart": false}'>
        <div class="wrapper">
            <div class="leftside-menu">
                <a href="{{ url('admin-panel/dashboard') }}" class="logo text-center logo-light">
                    <span class="logo-lg">
                        <img src="{{ asset('hyper/images/logo.png') }}" alt="" height="16">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('hyper/images/logo_sm.png') }}" alt="" height="16">
                    </span>
                </a>

                <a href="{{ url('admin-panel/dashboard') }}" class="logo text-center logo-dark">
                    <span class="logo-lg">
                        <img src="{{ asset('hyper/images/logo-dark.png') }}" alt="" height="16">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('hyper/images/logo_sm_dark.png') }}" alt="" height="16">
                    </span>
                </a>
    
                <div class="h-100" id="leftside-menu-container" data-simplebar>
                    <ul class="side-nav">

                        <li class="side-nav-title side-nav-item">Navigation</li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false" aria-controls="sidebarDashboards" class="side-nav-link">
                                <i class="uil-home-alt"></i>
                                <span class="badge bg-success float-end">1</span>
                                <span> Dashboards </span>
                            </a>

                            <div class="collapse" id="sidebarDashboards">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ url('admin-panel/dashboard') }}">Analytics</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-title side-nav-item">Apps</li>

                        <li class="side-nav-item">
                            <a href="{{ url('admin-panel/categories') }}" class="side-nav-link">
                                <i class="uil-box"></i>
                                <span> Category </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ url('admin-panel/posts') }}" class="side-nav-link">
                                <i class="uil-clipboard-alt"></i>
                                <span> Posts </span>
                            </a>
                        </li>

                        <li class="side-nav-title side-nav-item mt-1"> User Management </li>

                        <li class="side-nav-item">
                            <a href="{{ url('admin-panel/clients') }}" class="side-nav-link">
                                <i class="uil-user-circle"></i>
                                <span> Clients </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ url('admin-panel/users') }}" class="side-nav-link">
                                <i class="uil-users-alt"></i>
                                <span> User </span>
                            </a>
                        </li>

                        <li class="side-nav-title side-nav-item mt-1"> System Settings </li>
                        
                        <li class="side-nav-item">
                            <a href="{{ url('admin-panel/roles') }}" class="side-nav-link">
                                <i class="uil-file-lock-alt"></i>
                                <span> Role & Permissions </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#Settings" aria-expanded="false" aria-controls="Settings" class="side-nav-link">
                                <i class="uil-clipboard-alt"></i>
                                <span> Settings </span>
                                <span class="menu-arrow"></span>
                            </a>

                            <div class="collapse" id="Settings">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="{{ url('admin-panel/site-settings') }}"> Site Settings </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('admin-panel/home-settings') }}"> Home Settings </a>
                                    </li>

                                    <li>
                                        <a href="{{ url('admin-panel/mail-configuration') }}"> Mail Configuration </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a href="{{ url('seller-panel/my-account') }}" class="side-nav-link">
                                <i class="uil-user-square"></i>
                                <span> My Account </span>
                            </a>
                        </li>
                    </ul>

                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="content-page">
                <div class="content">
                    <div class="navbar-custom">
                        <ul class="list-unstyled topbar-menu float-end mb-0">
                            <li class="notification-list">
                                @if (Auth::user()->theme_color == "light")
                                    <a class="nav-link end-bar-toggle" href="javascript: void(0);" onclick="changeThemeColor('dark')">
                                        <i class="uil-moon noti-icon"></i>
                                    </a>
                                @elseif(Auth::user()->theme_color == "dark")
                                    <a class="nav-link end-bar-toggle" href="javascript: void(0);" onclick="changeThemeColor('light')">
                                        <i class="uil-sun noti-icon"></i>
                                    </a>
                                @endif
                            </li>

                            <li class="dropdown notification-list d-lg-none">
                                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="dripicons-search noti-icon"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                    <form class="p-3">
                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    </form>
                                </div>
                            </li>

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <span class="account-user-avatar"> 
                                        @if (Auth::user()->profile_image)
                                            <img src="{{ url('images/clients', Auth::user()->profile_image) }}" alt="{{ Auth::user()->full_name ?? "" }}" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('hyper/images/avator.png') }}" alt="user-image" class="rounded-circle">
                                        @endif
                                    </span>
                                    <span>
                                        <span class="account-user-name">{{ Auth::user()->name ?? "" }}</span>
                                        <span class="account-position">{{ Auth::user()->email ?? "" }}</span>
                                    </span>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                    <div class=" dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <a href="{{ url('admin-panel/my-account') }}" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-circle me-1"></i>
                                        <span>My Account</span>
                                    </a>

                                    <a href="{{ url('/') }}" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-edit me-1"></i>
                                        <span>Home</span>
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
    
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item notify-item">
                                            <i class="mdi mdi-logout me-1"></i>
                                            <span>Logout</span>
                                        </a>
                                    </form>
                                </div>
                            </li>
                        </ul>

                        <button class="button-menu-mobile open-left">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </div>

                     <!-- =============================================================== -->
                    <main>
                        {{ $slot }}
                    </main>
                    <!-- =============================================================== -->

                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                {{ config('app.name', 'Laravel') }}. © <script>document.write(new Date().getFullYear())</script>. All right reserved - Developed by <a class="border-bottom" href="https://abc.com">ABC</a>
                            </div>

                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <div class="rightbar-overlay"></div>

        <script src="{{ asset('hyper/js/vendor.min.js') }}"></script>

        {{ $script ?? '' }}

        <script src="{{ asset('hyper/js/app.min.js') }}"></script>

        <script type="text/javascript">
            function changeThemeColor(color) {
                var change_theme_color_url = "{{ url('admin-panel/change-theme-color') }}";

                window.location.href = change_theme_color_url + "?theme_color=" + color;
            }
        </script>
    </body>
</html>
