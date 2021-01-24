<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('bap/images/favicon.png') }}" type="image/png">

    <link href="{{ asset('bap/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    @stack('css-up')

    <script type="text/javascript" src="{{ asset('bap/plugins/jquery/jquery.min.js')}}"></script>

        <!-- Css -->
        {!!  Packer::css([
            asset('/bap/plugins/bootstrap/css/bootstrap.css'),
            asset('/bap/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'),
            asset('/bap/plugins/node-waves/waves.css'),
            asset('/bap/plugins/animate-css/animate.css'),
            asset('/bap/plugins/bootstrap-select/css/bootstrap-select.css'),
            asset('/bap/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css'),
            asset('/bap/plugins/jquery-datatable/extensions/responsive/css/responsive.dataTables.css'),
            asset('/bap/scss/style.css'),
            asset('/bap/plugins/offlinejs/offline-theme-chrome.css'),
            asset('/bap/plugins/offlinejs/offline-language-english.css'),
            asset('/bap/plugins/select2-4.0.3/dist/css/select2.min.css'),
            asset('/bap/plugins/select2-4.0.3/dist/css/select2-bootstrap.css'),
            asset('/bap/plugins/select2-4.0.3/dist/css/pmd-select2.css'),
            asset('/bap/plugins/bootstrap-daterangepicker/daterangepicker.css'),
            asset('/bap/plugins/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.min.css'),
            asset('/bap/plugins/jquery-datatable/yadcf/jquery.dataTables.yadcf.css'),
            asset('/bap/plugins/bootstrap-fileinput/css/fileinput.min.css'),
            asset('/bap/plugins/jquery-comments/css/jquery-comments.css'),
            ],
            asset('/storage/cache/css/main.css')
        ) !!}

    @stack('css')


    @include('partial.header_js')

    <script type="text/javascript">
        window.APPLICATION_USER_DATE_FORMAT = "YYYY-MM-DD";
        window.APPLICATION_USER_TIME_FORMAT = "HH:mm";
        window.APPLICATION_USER_LANGUAGE = "en";
        @if(Auth::check())
        window.UID = '{{ Auth::user()->id }}';
        @endif
        window.APPLICATION_USER_TIME_FORMAT_24 = true;
    </script>

</head>

<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

@include('partial.search-bar')
@include('partial.top-bar')
<section>

  @if(Auth::check())
    @include('partial.left-sidebar')
  @else
    @include('partial.left-sidebar-noauth')
  @endif



    @include('partial.right-sidebar')
</section>

<section class="content">
    <div class="container-fluid">


<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">


                @yield('content')


        </div>
    </div>
</div>


    </div>
</section>


@include('partial.bottom_js')
<script src="{{asset('vendor/datatables/buttons.server-side.js')}}"></script>
@stack('scripts')

<div class="modal fade" id="genericModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 10080!important;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"></h4>
            </div>

            <div class="modal-body ">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">ppp</button>
            </div>
        </div>
    </div>
</div>



</body>
</html>
