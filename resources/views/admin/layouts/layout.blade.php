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
    <!--<link rel="stylesheet" href="/css/bootstrap.min.css">-->
    <!-- /bootstrap -->

    <!-- core styles -->
    <link rel="stylesheet" href="/css/main.min.css">
    <!-- /core styles -->

    <!-- page styles -->
    @yield('css')
    <link rel="stylesheet" href="{{ elixir('css/backend.css') }}">

    <!-- /page styles -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- load modernizer -->
    <script src="/js/modernizr.js"></script>
</head>
<body>
    <div class="app">
        <!-- top header -->
        @include('admin/layouts/partials/_navbar')

        <!-- /top header -->

        <section class="layout">
            <!-- sidebar menu -->
            @include('admin/layouts/partials/_mainMenu')
            <!-- /sidebar menu -->

            <!-- main content -->
            <section class="main-content">

                <!-- content wrapper -->
                <div class="content-wrap">
                    @include('flash::message')
                    @yield('content')
                </div>
                <!-- /content wrapper -->
            </section>
            <!-- /main content -->
        </section>

    </div>

    <script src="/js/main.min.js"></script>
    @yield('scripts')
    <script src="{{ elixir('js/backend.js') }}"></script>

   </body>

</html>
