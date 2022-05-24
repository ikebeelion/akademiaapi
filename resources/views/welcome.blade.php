<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Akademia</title>
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png ')}}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist.min.css') }}">
        <link href="{{ asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        {{--  <!--*******************
            Preloader start
        ********************-->  --}}
        <div id="preloader">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>

        <div id="main-wrapper">
            <div id="app">
                <router-view></router-view>
            </div>
            <h1>Welcome </h1>
        </div>
        <script src="{{ asset('/js/app.js') }}"></script>
        <script data-cfasync="false" src="{{ asset('../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>

        {{--  <!-- Chart piety plugin files -->  --}}
        <script src="{{ asset('assets/vendor/peity/jquery.peity.min.js') }}"></script>

        {{--  <!-- Apex Chart -->  --}}
        <script src="{{ asset('assets/vendor/apexchart/apexchart.js') }}"></script>
        {{--  <!-- Dashboard 1 -->  --}}
        <script src="{{ asset('assets/js/dashboard/dashboard-1.js') }}"></script>
        <script src="{{ asset('assets/vendor/owl-carousel/owl.carousel.js') }}"></script>
        <script src="{{ asset('assets/js/custom.min.js') }}"></script>
        <script src="{{ asset('assets/js/deznav-init.js') }}"></script>
        <script src="{{ asset('assets/js/demo.js') }}"></script>
        {{--  <script src="{{ asset('assets/js/styleSwitcher.js') }}"></script>  --}}
        {{--  <!-- Datatable -->  --}}
        <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins-init/datatables.init.js') }}"></script>
        {{--  <!-- Chart piety plugin files -->  --}}
        <script src="vendor/peity/jquery.peity.min.js"></script>

        {{--  <!-- Apex Chart -->  --}}
        <script src="vendor/apexchart/apexchart.js"></script>


    </body>
</html>
