@extends('layouts.layout')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 login__page">
			<div class="panel panel-default">
				<div class="panel-heading login__page__title">Inicio de sesión</div>
				<div class="panel-body">


					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form">

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
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Recuerdame
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form__group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">Iniciar</button>
                                    <br />
                                    <a class="btn-link" href="{{ url('/password/email') }}">Olvidaste tu contraseña?</a><br />
                                    <a class="btn-link" href="{{ url('/auth/register')  }}">No tenés una cuenta? Haz click aquí</a>


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
