@extends('layouts.layout')
@section('meta-title')Guanacaste Vende | Editando Perfil de {!! $user->username !!}@stop
@section('meta-description')Editando Perfil de {!! $user->username !!}@stop
@section('content')

        <div class="profile__edit left-section">
            <h1 class="profile__edit__title">Editando Perfil</h1>
            {!! Form::model($user->profile, ['method' => 'PATCH', 'route' => ['profile.update', $user->username]]) !!}
            <div class="form">
                <!-- First name Form Input -->
                <div class="form__group">
                    {!! Form::label('first_name', 'Nombre:') !!}
                    {!! Form::text('first_name', null, ['class' => 'form__control','required' => 'required']) !!}
                    {!! errors_for('first_name',$errors) !!}
                </div>
                <!-- Last name Form Input -->
                <div class="form__group">
                    {!! Form::label('last_name', 'Apellidos:') !!}
                    {!! Form::text('last_name', null, ['class' => 'form__control','required' => 'required']) !!}
                    {!! errors_for('last_name',$errors) !!}
                </div>
                <!-- Identification Form Input -->
                <div class="form__group">
                    {!! Form::label('ide', 'Identificación:') !!}
                    {!! Form::text('ide', null, ['class' => 'form__control','required' => 'required']) !!}
                    {!! errors_for('ide',$errors) !!}
                </div>
                <!-- Address Form Input -->
                <div class="form__group">
                    {!! Form::label('address', 'Dirección:') !!}
                    {!! Form::text('address', null, ['class' => 'form__control','required' => 'required']) !!}
                    {!! errors_for('address',$errors) !!}

                </div>

                <!-- Telephone Form Input -->
                <div class="form__group">
                    {!! Form::label('telephone', 'Teléfono:') !!}
                    {!! Form::text('telephone', null, ['class' => 'form__control','required' => 'required']) !!}
                    {!! errors_for('telephone',$errors) !!}
                </div>
                <div class="form__group">
                    {!! Form::label('city', 'Ciudad:') !!}
                    {!! Form::text('city', null, ['class' => 'form__control','required' => 'required']) !!}
                    {!! errors_for('city',$errors) !!}
                </div>
            </div>

            <div class="form__group">
                {!! Form::submit('Actualizar Perfil', ['class' => 'btn btn-primary']) !!}
            </div>


            {!! Form::close() !!}

        </div>
        <div class="user__edit right-section">
            <h1 class="user__edit__title">Cambiar Contraseña</h1>
            {!! Form::model($user, ['method' => 'put', 'route' => ['users.update', $user->id],'class'=>'form-horizontal' ]) !!}
            <div class="form">
                <div class="form__group">
                    {!! Form::label('password','Password:')!!}
                    {!! Form::password('password',['class'=>'form__control','required' => 'required'])!!}
                    {!! errors_for('password',$errors) !!}
                </div>
                <div class="form__group">
                    {!! Form::label('password_confirmation','Password Confirmation:')!!}
                    {!! Form::password('password_confirmation',['class'=>'form__control','required' => 'required'])!!}
                </div>
            </div>
            <div class="form__group">
                {!! Form::submit('Cambiar Contraseña', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <div class="clear"></div>



@stop