@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | {!! $product->name !!}@stop
@section('meta-description'){!! trim(strip_tags( $product->description ))!!} | @foreach ($product->tags as $tag)
    {!! trim($tag->name) !!}@endforeach
@stop
@section('meta-share')
    <meta property="og:title" content="Guanacaste Vende | {!! $product->name !!}" />
    <meta property="og:description" content="{!! trim(strip_tags( $product->description ))!!} | @foreach ($product->tags as $tag)
    {!! trim($tag->name) !!}@endforeach" />
    <meta property="og:image" content="{!! photos_path('products').'thumb_'.$product->image !!}" />
    <meta property="og:url" content="{!! Request::url() !!}"/>
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


                <div class="box">
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
                        <a href="{!! URL::route('profile.show', [$product->user->username]) !!}" class="btn btn-success"
                           title="Inicia Sesion para ver los datos del vendedor!">Ver datos del vendedor</a>
                        @if (! Auth::guest())

                            @if($currentUser->hasFavorite($product))

                                <button type="submit" class="btn btn-remove btn-favorites" form="form-favorites-delete"
                                        formaction="{!! URL::route('delete_favorites', [$product->id]) !!}">Quitar de
                                    favoritos
                                </button>
                            @else
                                <button type="submit" class="btn btn-success btn-favorites"
                                        form="form-favorites-save"
                                        formaction="{!! URL::route('save_favorites', [$product->id]) !!}">Guardar en
                                    favoritos
                                </button>
                            @endif

                        @endif
                    </div>
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

                        <!--<div class="fb-comments" data-href="{!! Request::url()!!}" data-numposts="5"></div>-->
                        {!! Form::open(['route'=>['comments.store', $product->id], 'class'=>'form-horizontal']) !!}

                        <strong>{{ $comments->total() }} Preguntas </strong>
                       <hr />
                        <div class="form">
                            <div class="form__group">
                                 
                               
                                    {!! Form::textarea('body',null,['class'=>'form__control','required'=>'required','placeholder'=>'Escribe una pregunta para el vendedor']) !!}
                                    {!! errors_for('body',$errors) !!}

                            </div>
                            <div class="form__group">
                                {!! Form::submit('Preguntar',['class'=>'btn btn-primary'])!!}
                            </div>
                        </div>


                        {!! Form::close() !!}

                        <div class="comments">

                           @foreach($comments as $comment)
                                @include('products.partials.comments')
                            @endforeach
                            @if ($comments->total())
                                <div class="pagination-container">{!! $comments->render() !!}</div>
                            @endif
                        </div>
                        



                    @else
                        <a href="{!! URL::to('auth/login') !!}" class="btn btn-success"
                           title="Inicia Sesion para ver los comentarios!">Preguntar al vendedor</a>
                    @endif
                </div>
            </div>

        </article>
    </div>

    {!! Form::open(['route'=>['save_favorites', $product->id],'method' => 'post', 'id' => 'form-favorites-save','data-remote'=>'data-remote', 'data-remote-success-message'=>'Propiedad Guardada en tus favoritos!']) !!}{!! Form::close() !!}
    {!! Form::open(['route'=>['delete_favorites', $product->id],'method' => 'post', 'id' => 'form-favorites-delete','data-remote'=>'data-remote', 'data-remote-success-message'=>'Propiedad eliminada de tus favoritos!']) !!}{!! Form::close() !!}
    <div class="alert alert-info" style="display: none;"></div>

@stop
@section('scripts')

    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.4&appId=363306470411928";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <script src="https://apis.google.com/js/platform.js" async defer>
        {
            lang: 'es'
        }
    </script>


    <script>!function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
            if (!d.getElementById(id)) {
                js = d.createElement(s);
                js.id = id;
                js.src = p + '://platform.twitter.com/widgets.js';
                fjs.parentNode.insertBefore(js, fjs);
            }
        }(document, 'script', 'twitter-wjs');</script>

@stop