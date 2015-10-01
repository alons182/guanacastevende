@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | Perfil de {!! $user->username !!}@stop
@section('meta-description')Perfil de {!! $user->username !!}@stop
@section('content')

    <div class="reviews">
        <section class="profile__info">
            @include('profiles.partials.profile-info')
        </section>

        <article class="reviews__items">
            @include('profiles.partials.reviews')
        </article>
        @if ($reviews)
            <div class="pagination-container">{!! $reviews->render() !!}</div>
        @endif
        <div class="clear"></div>
    </div>



@stop