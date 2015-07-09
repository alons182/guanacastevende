@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | Perfil de {!! $user->username !!}@stop
@section('meta-description')Perfil de {!! $user->username !!}@stop
@section('content')


    <section class="profile">
        @include('profiles.partials.profile-info')
    </section>
    <article class="reviews reviews__container">
        @include('profiles.partials.reviews')
    </article>
    <div class="clear"></div>

@stop