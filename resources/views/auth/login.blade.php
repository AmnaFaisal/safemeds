<!doctype html>
<html lang="en" dir="ltr">

    <head>
        <!-- META DATA -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- FAVICON -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/images/brand/favicon.ico') }}" />
        <!-- TITLE -->
        <title>{{ env('APP_NAME') }} | Login</title>
        <!-- BOOTSTRAP CSS -->
        <link id="style" href="{{ asset('backend/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <!-- STYLE CSS -->
        <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/css/dark-style.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/css/transparent-style.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/css/skin-modes.css') }}" rel="stylesheet" />
        <!--- FONT-ICONS CSS -->
        <link href="{{ asset('backend/css/icons.css') }}" rel="stylesheet" />
        <!-- COLOR SKIN CSS -->
        <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('backend/colors/color1.css') }}" />
    </head>

    <body class="app sidebar-mini ltr login-img">
        <!-- BACKGROUND-IMAGE -->
        <div class="">
            <!-- GLOABAL LOADER -->
            <div id="global-loader">
                <img src="{{ asset('backend/images/loader.svg') }}" class="loader-img" alt="Loader">
            </div>
            <!-- /GLOABAL LOADER -->
            <!-- PAGE -->
            <div class="page">
                <div class="">
                    <!-- CONTAINER OPEN -->
                    <div class="mx-auto">
                        <div class="text-center">
                            <a href="javascript:void(0)"><img src="{{ asset('backend/images/brand/logo-white.png') }}" class="header-brand-img" alt="" style="max-height: 100px;"></a>
                        </div>
                    </div>
                    <div class="mx-auto" style="max-width: 500px;">
                        <div class="wrap-login100 p-6">
                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <span class="login100-form-title pb-5">
                                    Login
                                </span>
                                <div class="panel panel-primary">
                                    <div class="panel-body tabs-menu-body p-0 pt-3">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab5">
                                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red" />
                                                <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid email is required: ex@abc.xyz">
                                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                        <i class="zmdi zmdi-email text-muted" aria-hidden="true"></i>
                                                    </a>
                                                    <input id="email" class="input100 border-start-0 form-control ms-0" type="email" name="email" required autocomplete="email" value="{{ old('email') }}">
                                                </div>
                                                
                                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red" />
                                                <div class="wrap-input100 validate-input input-group" data-bs-validate="Password is required." id="Password-toggle">
                                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                        <i class="zmdi zmdi-eye text-muted" aria-hidden="true"></i>
                                                    </a>
                                                    <input id="password" class="input100 border-start-0 form-control ms-0" type="password" name="password" required autocomplete="current-password">
                                                </div>
                                                <div class="text-end pt-2">
                                                    <p class="mb-0">
                                                        @if (Route::has('password.request'))
                                                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                            href="{{ route('password.request') }}">
                                                            {{ __('Forgot your password?') }}
                                                        </a>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="container-login100-form-btn">
                                                    <x-primary-button class="login100-form-btn btn-primary">
                                                        {{ __('Log in') }}
                                                    </x-primary-button>
                                                </div>
                                                {{-- <div class="text-center pt-3">
                                                    <p class="text-dark mb-0">Not a member?<a href="{{ route('register') }}" class="text-primary ms-1">Sign UP</a></p>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- CONTAINER CLOSED -->
                </div>
            </div>
            <!-- End PAGE -->
        </div>
        <!-- BACKGROUND-IMAGE CLOSED -->

        <!-- JQUERY JS -->
        <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
        <!-- BOOTSTRAP JS -->
        <script src="{{ asset('backend/plugins/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- SHOW PASSWORD JS -->
        <script src="{{ asset('backend/js/show-password.min.js') }}"></script>
        <!-- GENERATE OTP JS -->
        <script src="{{ asset('backend/js/generate-otp.js') }}"></script>
        <!-- Perfect SCROLLBAR JS-->
        <script src="{{ asset('backend/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
        <!-- Color Theme js -->
        <script src="{{ asset('backend/js/themeColors.js') }}"></script>
        <!-- CUSTOM JS -->
        <script src="{{ asset('backend/js/custom.js') }}"></script>
    </body>

</html>