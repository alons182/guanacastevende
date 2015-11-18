
            <div class="filtros" >
               
               
                {!! Form::open(['route' => 'products','method' => 'get', 'class'=>'form-inline']) !!}


                            <div class="form-group">


                                {!! Form::text('q',$search, ['class'=>'form-control','placeholder'=>'Search'] ) !!}


                            </div>

                   


                             <div class=" form-group">

                                {!! Form::select('published', ['' => '-- Select Status --','0' => 'Inactive','1' => 'Active','2' => 'Waiting','3' => 'Payment Failure', '4' => 'Selled'], $selectedStatus, ['id'=>'published','class'=>'form-control'] ) !!}

                             </div>





                        

                {!! Form::close() !!}

            </div>
