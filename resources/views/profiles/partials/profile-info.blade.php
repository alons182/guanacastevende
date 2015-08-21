<h2 class="profile__title">
        @if ($user->isCurrent() && !Auth::guest())
            Tu Perfil <small class="profile__edit-link">
                | {!! link_to_route('profile.edit', 'Edita Tu Perfil', $currentUser->username) !!}
            </small>
        @else
            Perfil de Usuario
        @endif
</h2>

<div class="profile__ratings">
    <p class="pull-right right">{!! link_to_route('profile_reviews', 'Comentarios: '.$user->rating_count, $user->username) !!}</p>
    <p>
        @for ($i=1; $i <= 5 ; $i++)
            <span class="glyphicon glyphicon-star{!! ($i <= $user->rating_cache) ? '' : '-empty'!!}"></span>
        @endfor
        {!! number_format($user->rating_cache, 1) !!} stars
    </p>
</div>
<p class="profile__item"> <strong>Username:</strong> {!! $user->username !!} </p>
<p class="profile__item"> <strong>Nombre:</strong> {!! $user->profile->first_name !!} {!! $user->profile->last_name !!} </p>
<p class="profile__item"> <strong>Ciudad:</strong> {!! $user->profile->city !!} </p>
<p class="profile__item"> <strong>Teléfono #1:</strong> {!! $user->profile->telephone !!} </p>
<p class="profile__item"> <strong>Teléfono #2:</strong> {!! $user->profile->telephone2 !!} </p>
@if(!$user->isCurrent() && !Auth::guest())
    @include('profiles.partials.review-form')
@endif