@extends('layouts.layout')

@section('meta-title')Guanacaste Vende | Creando un nuevo producto @stop
@section('meta-description')Creando un nuevo producto @stop
@section('content')


    {!! Form::open(['route'=>'product_payment.store', 'class'=>'form-horizontal']) !!}
    <div class="product__payment__left">
        <header class="panel-heading">
            <h1 class="product__payment__title">Opciones de pago</h1>
        </header>
        <div class="payment__methods">
            <span class="pull-left left"><input type="radio" value="1" name="payment_method" checked data-method="card"> Datafono Tarjeta de credito o debito</span>
            <span class="pull-right right"><input type="radio" value="2" name="payment_method" data-method="paypal"> Paypal</span>
        </div>
        <section class="panel payment__method__card">

            <div class="form">
                    <!-- First name Form Input -->
                    <div class="form__group">
                        {!! Form::label('first_name', 'Nombre:') !!}
                        {!! Form::text('first_name', $currentUser->profile->first_name , ['class' => 'form__control','required' => 'required']) !!}
                        {!! errors_for('first_name',$errors) !!}
                    </div>
                    <!-- Last name Form Input -->
                    <div class="form__group">
                        {!! Form::label('last_name', 'Apellidos:') !!}
                        {!! Form::text('last_name', $currentUser->profile->last_name, ['class' => 'form__control','required' => 'required']) !!}
                        {!! errors_for('last_name',$errors) !!}
                    </div>
                    <!-- Identification Form Input -->
                    <div class="form__group">
                        {!! Form::label('ide', 'Identificación:') !!}
                        {!! Form::text('ide', $currentUser->profile->ide, ['class' => 'form__control','required' => 'required']) !!}
                        {!! errors_for('ide',$errors) !!}
                    </div>
                    <!-- Address Form Input -->
                    <div class="form__group">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('email', $currentUser->email, ['class' => 'form__control','required' => 'required']) !!}
                        {!! errors_for('email',$errors) !!}

                    </div>

                    <!-- Telephone Form Input -->
                    <div class="form__group">
                        {!! Form::label('card_number', 'Numero de tarjeta:') !!}
                        {!! Form::text('card_number', null, ['class' => 'form__control','required' => 'required']) !!}
                        {!! errors_for('card_number',$errors) !!}
                    </div>
                    <div class="form__group">
                        {!! Form::label('exp_card', 'Fecha de expiracion de tarjeta:') !!}
                        {!! Form::text('exp_card', null, ['class' => 'form__control','required' => 'required']) !!}
                        {!! errors_for('exp_card',$errors) !!}
                    </div>


                <div class="form__group">
                    {!! Form::submit('Pagar', ['class' => 'btn btn-primary']) !!}
                </div>

            </div>
        </section>
        <section class="panel payment__method__paypal">
            <header class="panel-heading">
                <h1 class="product__payment__title">Paypal</h1>
            </header>

        </section>

</div>
    <div class="product__payment__right">
        <h1 class="product__payment__title">Opciones compradas</h1>
        {!! Form::hidden('product_id', $product->id,['class'=>'form__control', 'readonly']) !!}

        <div class="table-responsive options-table">

            <table class="table table-striped  table-bordered table-responsive">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Precio</th>
                </tr>
                </thead>
                <tbody>

                @if($option)
                    <tr>
                        <td>{!! $option->name !!}</td>
                        <td> {!! money($option->price,'₡') !!}</td>

                    </tr>
                @endif
                    <tr>
                        <td> Etiqueta: {!! $product->tags->first()->name  !!}</td>
                        <td> {!! money($product->tags->first()->price,'₡') !!}</td>

                    </tr>

                </tbody>

            </table>
            <h1 class="product__payment__title">Total: {!! money($product->tags->first()->price + ($option) ? $option->price : 0, '₡') !!}</h1>
        </div>


    </div>
{!! Form::close() !!}

@stop


		
		


