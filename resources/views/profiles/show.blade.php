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
            <div class="pull-right right">{!! link_to_route('products.create','Nuevo Producto',null,['class'=>'btn btn-success']) !!}</div>
        @endif
        <h1>{!! ($user->isCurrent()) ? 'Tus Productos' : 'Productos del Usuario' !!} </h1>

        @include('products.partials._products',['products' => $user->products()->orderBy('created_at','DESC')->paginate(10) ])
        @if ($user->products)
            <div class="pagination-container">{!!$user->products()->orderBy('created_at','DESC')->paginate(10)->render() !!}</div>
        @endif
    </article>
    <div class="clear"></div>
</div>


@stop