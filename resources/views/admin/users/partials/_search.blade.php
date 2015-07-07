
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'users','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Search'] ) !!}


                            </div>

                   


                             <div class=" form-group">

                                {!! Form::select('active', ['' => '-- Select Status --','0' => 'Inactive','1' => 'Active'], $selectedStatus, ['id'=>'active','class'=>'form-control'] ) !!}

                             </div>

                        

                {!! Form::close() !!}

            </div>
