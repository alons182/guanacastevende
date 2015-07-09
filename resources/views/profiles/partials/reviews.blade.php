<h1 class="reviews__title">Calificaciones</h1>
@foreach($reviews as $review)
    <hr>
    <div class="row">
        <div class="col-md-12">
            @for ($i=1; $i <= 5 ; $i++)
                <span class="glyphicon glyphicon-star{{ ($i <= $review->rating) ? '' : '-empty'}}"></span>
            @endfor

                <a href="{{ route('profile.show', $review->author->username) }}" class="reviews__author__link">{!! $review->author->username !!}</a> <span class="pull-right right">{{$review->timeago}}</span>

            <p>{{{$review->comment}}}</p>
        </div>
    </div>
@endforeach