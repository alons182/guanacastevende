@extends('layouts.layout')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 reset__page">
			<div class="panel panel-default">
				<div class="panel-heading reset__page__title">Resetear Contraseña</div>
				<div class="panel-body">
                    @if (session('status'))
                        <div class="alert-block alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="token" value="{{ $token }}">
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
                                <label class="col-md-4 control-label">Confirmar Contraseña</label>
                                <div class="col-md-6">
                                    <input type="password" class="form__control" name="password_confirmation">
                                </div>
                                {!! errors_for('password_confirmation',$errors) !!}
                            </div>

                            <div class="form__group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Resetear Contraseña
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
