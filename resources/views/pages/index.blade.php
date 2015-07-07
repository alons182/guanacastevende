@extends('layouts.layout')

@section('content')
    <div class="banner">
        <div class="cycle-slideshow"
             data-cycle-fx="scrollHorz"
             data-cycle-timeout="4000"
             data-cycle-slides=".banner__slide"
                >

            <div class="cycle-pager banner__pager"></div>
            <div class="cycle-prev"><i class="icon-angle-left"></i></div>
            <div class="cycle-next"><i class="icon-angle-right"></i></div>
            @foreach ($featured as $product)
                <div class="banner__slide" style="background-image: url('media/products/{!! $product->image !!}')">
                    <h2 class="banner__slide__title cursive">{!! $product->name !!}</h2>
                    <a href="{!! URL::route('product_path', [$product->slug]) !!}" class="banner__slide__link"></a>
                </div>
            @endforeach
            

        </div>
    </div>
    @include('products.partials._products')

@stop