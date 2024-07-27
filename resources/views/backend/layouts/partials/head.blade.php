<!-- META DATA -->
<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- FAVICON -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend/images/brand/favicon.ico') }}" />

<!-- TITLE -->
<title>{{ env('APP_NAME') }} @yield('title') </title>

<!-- BOOTSTRAP CSS -->
<link id="style" href="{{ asset('backend/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

<!-- STYLE CSS -->
<link href="{{ asset('backend/css/style.css') }}" rel="stylesheet" />
<link href="{{ asset('backend/css/dark-style.css') }}" rel="stylesheet" />
<link href="{{ asset('backend/css/transparent-style.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/skin-modes.css') }}" rel="stylesheet" />

{{-- <link href="{{ asset('backend/css/icons.css') }}" rel="stylesheet" /> --}}

<!--- FONT-ICONS CSS -->
<link href="{{ asset('backend/css/icons.css') }}" rel="stylesheet" />

<!-- COLOR SKIN CSS -->
<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('backend/colors/color1.css') }}" />
