
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('bap/images/favicon.png') }}" type="image/png">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Css -->
    {!!  Packer::css([
        asset('/bap/plugins/bootstrap/css/bootstrap.css'),
        asset('/bap/plugins/node-waves/waves.css'),
        asset('/bap/plugins/animate-css/animate.css'),
        asset('/bap/scss/style.css'),
        asset('/bap/scss/auth.css'),
        ],asset('/storage/cache/css/main.css')
    ) !!}


</head>

<body style="background: url({{ asset('/bg/login/colourful-2691170_1920.jpg') }})" class="login-page ls-closed auth-background">

@yield('content')



    <!-- Scripts -->
    {!! Packer::js([
        asset('/bap/plugins/jquery/jquery.min.js'),
        asset('/bap/plugins/bootstrap/js/bootstrap.js'),
        asset('/bap/plugins/node-waves/waves.js'),
        asset('/bap/js/admin.js')],
        asset('/storage/cache/js/main.js')
    )  !!}


</body>
</html>
