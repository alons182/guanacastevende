<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="well well-sm">
                <div class="form">
                    {!! errors_for('body',$errors) !!} <br />
                  
                </div>

               
                <a class="btn btn-success btn-green open-reply-box btn-small" href="#reply-anchor" >Responder</a>
               

                <div class="row post-reply-box"  style="display:none;">
                    <div class="col-md-12 form">
                        {!! Form::open(['route'=>['comments.store', $product->id], 'class'=>'form-horizontal']) !!}

                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <input type="hidden" name="user_to_respond" value="{{ $comment->author->id }}">
                            <input type="hidden" name="author" value="{{ $comment->author->email }}">
                            <textarea class="form__control animated new-reply" cols="50" name="body" placeholder="Escribe tu respuesta aquí..." rows="5"></textarea>


                            <div class="text-right">

                               

                                <a class="btn btn-danger btn-small close-reply-box" href="#" style="display:none; margin-right: 10px;">
                                    <span class="glyphicon glyphicon-remove"></span>Cancelar</a>
                                <button class="btn btn-success btn-small btn-gray" type="submit">Guardar</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
