@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | Perfil de {!! $user->username !!}@stop
@section('meta-description')Perfil de {!! $user->username !!}@stop
@section('content')


    <section class="profile">
        <h2 class="profile__title">Tu Perfil <small class="profile__edit-link">
                @if ($user->isCurrent())
                  | {!! link_to_route('profile.edit', 'Edita Tu Perfil', $currentUser->username) !!}
                    {!! link_to_route('products.create','Nuevo Producto',null,['class'=>'btn btn-success']) !!}
                @endif

            </small></h2>

        <p class="profile__item"> <strong>Username:</strong> {!! $user->username !!} </p>
        <p class="profile__item"> <strong>Nombre:</strong> {!! $user->profile->first_name !!} {!! $user->profile->last_name !!} </p>
        <p class="profile__item"> <strong>Email:</strong> {!! $user->email !!} </p>
        <p class="profile__item"> <strong>Direccion:</strong> {!! $user->profile->address !!} </p>


    </section>
    <article class="products__container">
        <h1>{!! ($user->isCurrent()) ? 'Tus Productos' : 'Productos del Usuario' !!} </h1>

        @include('products.partials._products',['products' => $user->products ])

    </article>
    <div class="clear"></div>

@stop