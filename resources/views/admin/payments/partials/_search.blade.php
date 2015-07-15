
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'payments','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">

                                {!! Form::label('q', 'Username:') !!}
                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Search'] ) !!}


                            </div>



                {!! Form::close() !!}

            </div>
