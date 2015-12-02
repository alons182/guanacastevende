<blockquote>
  <p>{{$comment->body}}</p>
  <footer>
    Comentario por <a href="{!! URL::route('profile.show', [$comment->author->username]) !!}">{{ $comment->author->username}}</a>
     on <span>{{ $comment->getTimeagoAttribute() }}</span>
     @include('products.partials.reply-form')
  </footer>
    @foreach($comment->replies as $reply)
         @include('products.partials.comments', ['comment' => $reply ])
    @endforeach
</blockquote>