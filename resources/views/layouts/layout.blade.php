@include('layouts/partials/_header')


<main class="main">
    <div class="inner">
        @include('flash::message')
        @yield('content')
    </div>

</main>

@include('layouts/partials/_footer')