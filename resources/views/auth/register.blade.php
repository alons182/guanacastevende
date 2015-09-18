@extends('layouts.layout')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 register__page">
			<div class="panel panel-default">
				<div class="panel-heading register__page__title">Registro</div>
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form">
                            <div class="form__group">
                                <label class="col-md-4 control-label">Usuario</label>
                                <div class="col-md-6">
                                    <input type="text" class="form__control" name="username" value="{{ old('username') }}">
                                </div>
                                {!! errors_for('username',$errors) !!}
                            </div>

                            <div class="form__group">
                                <label class="col-md-4 control-label">E-Mail</label>
                                <div class="col-md-6">
                                    <input type="email" class="form__control" name="email" value="{{ old('email') }}">
                                </div>
                                {!! errors_for('email',$errors) !!}
                            </div>

                            <div class="form__group">
                                <label class="col-md-4 control-label">Contraseña</label>
                                <div class="col-md-6">
                                    <input type="password" class="form__control" name="password">
                                </div>
                                {!! errors_for('password',$errors) !!}
                            </div>

                            <div class="form__group">
                                <label class="col-md-4 control-label">Confirmar Contraseña</label>
                                <div class="col-md-6">
                                    <input type="password" class="form__control" name="password_confirmation">
                                </div>
                                {!! errors_for('password_confirmation',$errors) !!}
                            </div>
                            <div class="form-group terms-input">
                                {!! Form::label('terms', 'Acepta:',['class'=>'terms-input__label']) !!}
                                <a href="/terms" target="_blank" class="terms-input__link">Términos y condiciones</a>
                                {!! Form::checkbox('terms') !!}
                                {!! errors_for('terms',$errors) !!}
                            </div>
                            <div class="form__group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Crear cuenta
                                    </button>
                                </div>
                            </div>
                        </div>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
