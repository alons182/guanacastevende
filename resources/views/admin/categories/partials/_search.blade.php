
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'categories','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Search'] ) !!}


                            </div>

                   


                             <div class=" form-group">

                                {!! Form::select('published', ['' => '-- Select Status --','0' => 'Inactive','1' => 'Active'], $selectedStatus, ['id'=>'published','class'=>'form-control'] ) !!}

                             </div>





                        

                {!! Form::close() !!}

            </div>
