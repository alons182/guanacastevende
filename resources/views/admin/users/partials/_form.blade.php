<div class="col-lg-6">
    <section class="panel">
        <header class="panel-heading">
                    {!! Form::submit(isset($buttonText) ? $buttonText : 'Create User',['class'=>'btn btn-primary'])!!}
                    {!! link_to_route('users',  'Cancel' , null, ['class'=>'btn btn-default'])!!}
         </header>
        <div class="panel-body">



                <div class="form-group">
                    {!! Form::label('username','Username:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::text('username',null,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('username',$errors) !!}
                    </div>


                </div>
                <div class="form-group">
                    {!! Form::label('email','Email:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                        {!! Form::email('email',null,['class'=>'form-control','required'=>'required'])!!}
                        {!! errors_for('email',$errors) !!}
                    </div>

                </div>

                <div class="form-group">
                    {!! Form::label('password','Password:',['class'=>'col-sm-2 control-label'])!!}
                    <div class="col-sm-10">
                         {!! Form::password('password',['class'=>'form-control'])!!}
                         {!! errors_for('password',$errors) !!}
                    </div>


                </div>
                <div class="form-group">
                    {!! Form::label('password_confirmation','Password Confirmation:',['class'=>'col-sm-2 control-label'])!!}
                     <div class="col-sm-10">
                        {!! Form::password('password_confirmation',['class'=>'form-control'])!!}
                      </div>
                </div>


        </div>
    </section>
		
</div>