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
        <title>{{ env('APP_NAME') }} | Forgot Password</title>
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
                            <x-auth-session-status class="mb-4 text-green" :status="session('status')" />
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <span class="login100-form-title pb-5">
                                    Forgot Password
                                </span>
                                <p class="text-muted">Enter the email address registered on your account</p>
                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red" />
                                <div class="wrap-input100 validate-input input-group py-4" data-bs-validate="Valid email is required: ex@abc.xyz">
                                    <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                        <i class="zmdi zmdi-email" aria-hidden="true"></i>
                                    </a>
                                    <x-text-input id="email" class="input100 border-start-0 ms-0 form-control" type="email" name="email"
                                        :value="old('email')" required autofocus autocomplete="username" />
                                </div>
                                <x-primary-button class="login100-form-btn btn-primary d-grid">
                                    {{ __('Submit') }}
                                </x-primary-button>
                                <div class="text-center mt-4">
                                    <p class="text-dark mb-0"><a class="text-primary ms-1" href="{{ route('login') }}">Back to Login</a></p>
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
