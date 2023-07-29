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
  <link rel="stylesheet" type="text/css" href="{{ asset('files/assets/icon/themify-icons/themify-icons.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('files/assets/icon/icofont/css/icofont.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('files/assets/css/style.css') }}">
</head>

<body class="fix-menu">

  <div class="theme-loader">
    <div class="ball-scale">
      <div class='contain'>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
      </div>
    </div>
  </div>

  @yield('content')

  <script type="text/javascript" src="{{ asset('files/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

  <script type="text/javascript" src="{{ asset('files/bower_components/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

  <script type="text/javascript" src="{{ asset('files/bower_components/modernizr/modernizr.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/modernizr/feature-detects/css-scrollbars.js') }}"></script>

  <script type="text/javascript" src="{{ asset('files/bower_components/i18next/i18next.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/bower_components/jquery-i18next/jquery-i18next.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/assets/js/common-pages.js') }}"></script>
  <script type="text/javascript" src="{{ asset('files/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @yield('js-login')
</body>

</html>