<!DOCTYPE html>
<html class="no-js">

<head>
    <!-- Some assets concatenated and minified to improve load speed. Download version includes source css, javascript and less assets -->
    <!-- meta -->
    <meta charset="utf-8">
    <meta name="description" content="Flat, Clean, Responsive, admin template built with bootstrap 3">
    <meta name="viewport" content="width=device-width, user-scalable=1, initial-scale=1, maximum-scale=1">

    <title>@yield('meta-title','Guanacaste Vende | Administration')</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- /bootstrap -->

    <!-- core styles -->
    <link rel="stylesheet" href="/css/main.min.css">
    <!-- /core styles -->

    <!-- page styles -->
    @yield('css')
    <link rel="stylesheet" href="{{ elixir('css/backend.css') }}">

    <!-- /page styles -->

    <!-- load modernizer -->
    <script src="/js/modernizr.js"></script>
</head>
<body class="bg-dark">
    <div class="app-user">
        <div class="user-container">
            @include('flash::message')
            @yield('content')
        </div>
    </div>


</body>

</html>
