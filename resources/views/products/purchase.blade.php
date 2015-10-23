@extends('layouts.layout')

@section('meta-title')Guanacaste Vende | Confirmación de pago @stop
@section('meta-description')Confirmación de pago @stop
@section('content')

    <div class="payment">
        <form action="https://vpayment.verifika.com/VPOS/MM/transactionStart20.do" method="POST" class="form-horizontal">

        <div class="left-section">
            <h1 class="payment__title">Confirmación de pago</h1>

            <section class="panel payment__method__card">

                <div class="form">
                    {!! Form::hidden('IDACQUIRER',  $idAcquirer) !!}
                    {!! Form::hidden('IDCOMMERCE',  $idCommerce) !!}
                    {!! Form::hidden('XMLREQ',  $array_get['XMLREQ']) !!}
                    {!! Form::hidden('DIGITALSIGN',  $array_get['DIGITALSIGN']) !!}
                    {!! Form::hidden('SESSIONKEY',  $array_get['SESSIONKEY']) !!}


                    <p class="profile__item"> <strong>Nombre:</strong> {!! $input["first_name"] !!} </p>
                    <p class="profile__item"> <strong>Apellidos:</strong> {!! $input["last_name"] !!} </p>
                    <p class="profile__item"> <strong>Teléfono:</strong> {!! $input["telephone"] !!} </p>
                    <p class="profile__item"> <strong>Dirección:</strong> {!! $input["address"] !!} </p>
                    <p class="profile__item"> <strong>Ciudad:</strong> {!! $input["city"] !!} </p>
                    <p class="profile__item"> <strong>Provincia:</strong> {!! $input["state"] !!} </p>
                    <p class="profile__item"> <strong>País:</strong> {!! $input["country"] !!} </p>
                    <p class="profile__item"> <strong>Zipcode:</strong> {!! $input["zipcode"] !!} </p>




                    <div class="form__group">
                        {!! Form::submit('Ejecutar pago', ['class' => 'btn btn-primary']) !!}
                        <button type="submit" class="btn btn-gray" form="form-delete" formaction="{!! URL::route('products.destroy', [$product->id]) !!}">
                            Cancelar<i class="fa fa-trash-o"></i>
                        </button>
                    </div>

                </div>
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
                <div class="logos-payment">
                    <a href="https://www.mastercard.us/en-us/merchants/safety-security/securecode.html" target="_blank"><img
                                src="/img/logo-mastercard.png" alt="Mastercard" /></a>
                    <a href="http://www.visalatam.com/s_verified/verified.jsp" target="_blank"><img
                                src="/img/logo-verified-by-visa.png" alt="Verified by Visa" /></a>
                </div>

            </div>


        </div>
        </form>

    </div>
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'Estas seguro? Se eliminaran los datos del producto recien ingresado']) !!}{!! Form::close() !!}
@stop




		
		


