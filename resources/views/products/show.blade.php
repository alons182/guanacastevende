@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | {!! $product->name !!}@stop
@section('meta-description'){!! trim(strip_tags( $product->description ))!!} | @foreach ($product->tags as $tag)
{!! trim($tag->name) !!}@endforeach
@stop
@section('content')
    @include('categories.partials._list')
    <article class="product product__container">
        <div class="product__media">
            <div class="product__img">
                @if($product->image)
                    <img class="img" src="{!! photos_path('products').'thumb_'.$product->image !!}" alt="{!! $product->name !!}" width="500"  height="400"/>
                @else
                    <img class="img" src="holder.js/481x531/text:No-image" alt="{!! $product->name !!}">
                @endif
            </div>
            @if (count($photos)>0)

                <div class="product__media__gallery">
                    <h3 class="product__media__title">Más imagenes</h3>

                    @foreach ($photos as $photo)
                        <a class="product__media__gallery__link" href="{!! photos_path('products') !!}{!! $photo->product_id !!}/{!! $photo->url !!}" data-lightbox="gallery">
                            <img src="{!! photos_path('products') !!}{!! $photo->product_id !!}/{!! $photo->url !!}"
                                 data-src="{!! photos_path('products') !!}{!! $photo->product_id !!}/{!! $photo->url!!}"
                                 alt="{!! $product->name !!}">
                        </a>
                    @endforeach


                    <div class="clear"></div>

                </div>
            @endif
        </div>
        <div class="product__info">
            <h1 class="product__title">
                {!! $product->name !!}
            </h1>
            <div class="product__description">
                {!! $product->description !!}
            </div>
            <div class="product__price">
                {!! money($product->price, '₡') !!}
            </div>
            <div class="product__share">
                <span class="product__share__title">Compartir</span>
                <a class="icon-facebook" title="Facebook" href="#"
                   onclick="
                                window.open(
                                  'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),
                                  'facebook-share-dialog',
                                  'width=626,height=436');
                                return false;">

                </a>

                <a class="icon-twitter" href="https://twitter.com/share?url={!! Request::url()!!}" target="_blank"></a>
                <a class="icon-google-plus" href="https://plus.google.com/share?url={!! Request::url()!!}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a>
            </div>
        </div>

    </article>

@stop