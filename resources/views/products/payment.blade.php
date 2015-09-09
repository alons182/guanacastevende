@extends('layouts.layout')

@section('meta-title')Guanacaste Vende | Creando un nuevo producto @stop
@section('meta-description')Creando un nuevo producto @stop
@section('content')

    <div class="payment">
        {!! Form::open(['route'=>'product_payment.store', 'class'=>'form-horizontal']) !!}
        <div class="left-section">
            <h1 class="payment__title">Opciones de pago</h1>

            <div class="payment__methods">
                <span class="pull-left left"><input type="radio" value="1" name="payment_method" checked data-method="card"> Tarjeta de credito o debito</span>
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
                        {!! Form::text('exp_card', null, ['id'=>'exp_card','class' => 'form__control','required' => 'required','placeholder' => '02/15']) !!}
                        {!! errors_for('exp_card',$errors) !!}
                    </div>


                    <div class="form__group">
                        {!! Form::submit('Ejecutar pago', ['class' => 'btn btn-primary']) !!}
                        <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('products.destroy', [$product->id]) !!}">
                            Cancelar<i class="fa fa-trash-o"></i>
                        </button>
                    </div>

                </div>
            </section>
            <section class="panel payment__method__paypal">
                    <h1 class="payment__title">Paypal</h1>
                @foreach($items as $item)
                    <script async="async" src="/vendor/paypal-button.min.js?merchant=SHAHQGFU3JV94"
                            data-button="buynow"
                            data-name="{!! $item['name'] !!}"
                            data-quantity="1"
                            data-amount="{!! $item['priceDollar'] !!}"
                            data-currency="USD"
                            data-shipping="0"
                            data-tax="0"
                            data-callback="http://guanacastevende.com/profile/admin"
                            data-env="sandbox"
                            ></script>
                @endforeach

            </section>

        </div>
        <div class="right-section">
            <h1 class="payment__title">Opciones compradas</h1>
            {!! Form::hidden('product_id', $product->id,['class'=>'form__control', 'readonly']) !!}

            <div class="table-responsive payment__options-table">

                <table class="table table-striped  table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Precio</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($items as $item)
                        <tr>
                            <td>{!! $item['name'] !!}</td>
                            <td> {!! money($item['price'],'₡') !!}</td>
                        </tr>
                    @endforeach

                    </tbody>

                </table>
                <h1 class="payment__title">Total: {!! money($total, '₡') !!} </h1>
            </div>


        </div>
        {!! Form::close() !!}

    </div>
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}
@stop




		
		


