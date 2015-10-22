@extends('layouts.layout')

@section('content')
    <div class="home">
        <div class="banner">
            <div class="cycle-slideshow"
                 data-cycle-fx="scrollHorz"
                 data-cycle-timeout="4000"
                 data-cycle-slides=".banner__slide"
                    >

                <div class="cycle-pager banner__pager"></div>
                <div class="cycle-prev"><i class="icon-angle-left"></i></div>
                <div class="cycle-next"><i class="icon-angle-right"></i></div>

                    <div class="banner__slide" style="background-image: url('/img/banner.jpg')">
                        <!--<h2 class="banner__slide__title cursive">Publicidad</h2>-->
                        <a href="#" class="banner__slide__link"></a>
                    </div>
                <div class="banner__slide" style="background-image: url('/img/banner2.jpg')">

                    <a href="#" class="banner__slide__link"></a>
                </div>



            </div>
        </div>
        @include('products.partials._products',['isHome'=>true])
    </div>


@stop