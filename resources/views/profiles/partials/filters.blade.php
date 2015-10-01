
            <div class="filtros" >
               
               
                {!! Form::open(['route' => ['profile_reviews', $user->username],'method' => 'get', 'class'=>'form-inline']) !!}




                   


                             <div class=" form-group">
                                 <label for="star">Filtar por:</label>
                                {!! Form::select('star', ['' => '-- Todas las Estrellas --','1' => '1 Estrella','2' => '2 Estrellas','3' => '3 Estrellas','4' => '4 Estrellas','5' => '5 Estrellas'], $selectedStar, ['id'=>'star','class'=>'form__control'] ) !!}

                             </div>





                        

                {!! Form::close() !!}

            </div>
