<!DOCTYPE html>
<html lang="en">

<head>
  <title>PT. Multi Arta Sekawan - Aplikasi PO Online</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="#">
  <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
  <meta name="author" content="#">
  <link rel="icon" href="https://omas-mfg.com/assets/images/logo1.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('files/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('files/assets/pages/chart/radial/css/radial.css') }}" media="all">
  <link rel="stylesheet" type="text/css" href="{{ asset('files/assets/icon/feather/css/feather.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('files/assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('files/assets/css/jquery.mCustomScrollbar.css') }}">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
</head>

<body>

  @include('layouts.loader')

  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

      @yield('nav')

      @yield('navmenu')

      @yield('inner_chat')

      @yield('content')
    </div>
  </div>

  <script type="text/javascript" src="{{ asset('files/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/modernizr/modernizr.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/modernizr/feature-detects/css-scrollbars.js') }}"></script>

  <script type="text/javascript" src="{{ asset('files/bower_components/chart.js/dist/Chart.js') }}"></script>

  <script src="{{ asset('files/assets/pages/widget/gauge/gauge.min.js') }}"></script>
  <script src="{{ asset('files/assets/pages/widget/amchart/amcharts.js') }}"></script>
  <script src="{{ asset('files/assets/pages/widget/amchart/serial.js') }}"></script>
  <script src="{{ asset('files/assets/pages/widget/amchart/gauge.js') }}"></script>
  <script src="{{ asset('files/assets/pages/widget/amchart/pie.js') }}"></script>
  <script src="{{ asset('files/assets/pages/widget/amchart/light.js') }}"></script>

  <script src="{{ asset('files/assets/js/pcoded.min.js') }}"></script>
  <script src="{{ asset('files/assets/js/vartical-layout.min.js') }}"></script>
  <script src="{{ asset('files/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
  <script src="{{ asset('files/assets/pages/dashboard/crm-dashboard.min.js') }}"></script>
  <script src="{{ asset('files/assets/js/script.js') }}"></script>

  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

  @yield('script')
</body>

</html>