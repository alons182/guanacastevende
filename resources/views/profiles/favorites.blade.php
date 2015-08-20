@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | Perfil de {!! $user->username !!}@stop
@section('meta-description')Perfil de {!! $user->username !!}@stop
@section('content')

    <div class="profile">
        <section class="profile__info">
            @include('profiles.partials.profile-info')
        </section>
        <article class="products__items">
            @if ($user->isCurrent())
                <div class="pull-right right">{!! link_to_route('products.create','Vender Articulo',null,['class'=>'btn btn-success']) !!}</div>
            @endif
            <h1>Tus Productos Favoritos</h1>

            @include('products.partials._products',['products' => $user->favorites()->orderBy('created_at','DESC')->paginate(10) ])
            @if ($user->favorites)
                <div class="pagination-container">{!!$user->favorites()->orderBy('created_at','DESC')->paginate(10)->render() !!}</div>
            @endif
        </article>
        <div class="clear"></div>
    </div>
@stop