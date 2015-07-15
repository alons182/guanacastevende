
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'tags','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Search'] ) !!}


                            </div>



                {!! Form::close() !!}

            </div>
