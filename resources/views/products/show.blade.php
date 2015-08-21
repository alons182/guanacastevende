@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | {!! $product->name !!}@stop
@section('meta-description'){!! trim(strip_tags( $product->description ))!!} | @foreach ($product->tags as $tag)
    {!! trim($tag->name) !!}@endforeach
@stop
@section('content')
    <div class="product">
        @include('categories.partials._list')
        <article class="product__container">
            <div class="product__media">
                <div class="product__img">
                    @if($product->image)
                        <a class="product__img__link" href="{!! photos_path('products') !!}{!! $product->image !!}">
                            <img class="img" src="{!! photos_path('products').'thumb_'.$product->image !!}"
                                 alt="{!! $product->name !!}" width="500" height="400"/>
                        </a>
                    @else
                        <img class="img" src="holder.js/481x531/text:No-image" alt="{!! $product->name !!}">
                    @endif
                </div>
                @if (count($photos)>0)

                    <div class="product__media__gallery">
                        <h3 class="product__media__title">Más imagenes</h3>

                        @foreach ($photos as $photo)
                            <a class="product__media__gallery__link"
                               href="{!! photos_path('products') !!}{!! $photo->product_id !!}/{!! $photo->url !!}">
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

                <div class="product__tags">
                    @foreach($product->tags as $tag)
                        <span class="product__tags__item">{!! $tag->name !!}</span>
                    @endforeach
                </div>
                <div class="product__description">
                    {!! $product->description !!}
                </div>
                <div class="product__price">
                    {!! money($product->price, '₡') !!}
                </div>
                <div class="product__view__seller">
                    <a href="{!! URL::route('profile.show', [$product->user->username]) !!}" class="btn btn-success" title="Inicia Sesion para ver los datos del vendedor!">Ver datos del vendedor</a>
                @if (! Auth::guest())

                        @if($currentUser->hasFavorite($product))

                            <button type="submit"  class="btn btn-remove" style="float: right;" form="form-favorites" formaction="{!! URL::route('delete_favorites', [$product->id]) !!}" >Quitar de favoritos</button>
                        @else
                            <button type="submit"  class="btn btn-success" style="float: right;" form="form-favorites" formaction="{!! URL::route('save_favorites', [$product->id]) !!}" >Guardar en favoritos</button>
                        @endif

                @endif
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

                    <a class="icon-twitter" href="https://twitter.com/share?url={!! Request::url()!!}"
                       target="_blank"></a>
                    <a class="icon-google-plus" href="https://plus.google.com/share?url={!! Request::url()!!}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"></a>
                </div>
                <div class="product__likes">

                    <div class="fb-like"></div>
                    <div class="g-plusone" data-annotation="inline" data-width="300"></div>
                    <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>

                </div>
                <div class="product__comments">
                    @if(! auth()->guest())

                    <div class="fb-comments" data-href="{!! Request::url()!!}" data-numposts="5"></div>

                    @else
                        <a href="{!! URL::to('auth/login') !!}" class="btn btn-success" title="Inicia Sesion para ver los comentarios!">Ver comentarios</a>
                    @endif
                </div>
            </div>

        </article>
    </div>

    {!! Form::open(['method' => 'post', 'id' => 'form-favorites']) !!}{!! Form::close() !!}

@stop
@section('scripts')

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.4&appId=363306470411928";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <script src="https://apis.google.com/js/platform.js" async defer>
        {lang: 'es'}
    </script>


    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

@stop