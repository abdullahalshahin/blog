<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Registration | {{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{ asset('hyper/images/favicon.ico') }}">

        <link href="{{ asset('hyper/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('hyper/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
        <link href="{{ asset('hyper/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    </head>
    <body class="loading authentication-bg" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-8 col-lg-8">
                        <div class="card">
                            <div class="card-header pt-4 pb-4 text-center bg-primary">
                                <a href="{{ url('/') }}">
                                    <span><img src="{{ asset('hyper/images/logo.png') }}" alt="" height="18"></span>
                                </a>
                            </div>

                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 fw-bold">Free Sign Up</h4>
                                    <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute </p>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ url('client-panel/registration') }}" method="POST">
                                    @csrf

                                    <div class="row mb-1">
                                        <div class="col-md-8">
                                            <label for="name"> Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
                                        </div>

                                        <div class="mb-2 col-md-4">
                                            <label for="gender">Gender <span class="text-danger">*</span></label>
                                            <select id="gender" name="gender" class="form-select" required>
                                                <option value="">Choose Gender</option>
                                                @foreach ($genders as $gender)
                                                    <option value="{{ $gender }}" {{ old('gender') == $gender ? 'selected' : '' }}>
                                                        {{ $gender }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-md-4">
                                            <label for="date_of_birth"> Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" placeholder="" required>
                                        </div>

                                        <div class="col-md-8">
                                            <label for="email"> Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-1">
                                            <label for="password"> Password <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="" required>
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6 mb-1">
                                            <label for="password_confirmation"> Confirm Password <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control" placeholder="" required>
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-1">
                                        <div class="col-md-12">
                                            <label for="address"> Address <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="address" name="address" rows="5" required>{{ old('address') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="mb-1 mt-2 text-center">
                                        <button class="btn btn-primary" type="submit"> Next </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Already have account? <a href="{{ url('client-panel/login') }}" class="text-danger ms-1"><b>Log In</b></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer footer-alt">
            Copyright © <script>document.write(new Date().getFullYear())</script> <a href="https://oscorp.com">OSCORP Foundation </a> | All Rights Reserved
        </footer>
        
        <script src="{{ asset('hyper/js/vendor.min.js') }}"></script>
        <script src="{{ asset('hyper/js/app.min.js') }}"></script>
    </body>
</html>
