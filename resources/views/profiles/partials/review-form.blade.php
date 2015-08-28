<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="well well-sm">
                <div class="form">
                    {!! errors_for('comment',$errors) !!} <br />
                    {!! errors_for('rating',$errors) !!}
                </div>

                <div class="text-right">
                    <a class="btn btn-success btn-green" href="#reviews-anchor" id="open-review-box">Calificar usuario</a>
                </div>

                <div class="row" id="post-review-box" style="display:none;">
                    <div class="col-md-12 form">
                        {!! Form::open(['route'=>['profile_review',$user->username], 'class'=>'form-horizontal']) !!}

                            <input id="ratings-hidden" name="rating" type="hidden">
                            <textarea class="form__control animated" cols="50" id="new-review" name="comment" placeholder="Escribe tu comentario aquí..." rows="5"></textarea>


                            <div class="text-right">

                                <div class="stars starrr" data-rating="0">Puntos: </div>

                                <a class="btn btn-danger btn-sm" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                                    <span class="glyphicon glyphicon-remove"></span>Cancelar</a>
                                <button class="btn btn-success btn-lg" type="submit">Guardar</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
