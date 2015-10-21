@extends('layouts.layout')

@section('meta-title')Guanacaste Vende | Comprobante de pago @stop
@section('meta-description')Comprobante de pago @stop
@section('content')

    <div class="payment">


           <!--<div class="alert alert-danger">Procedimiento de pago en periodo de prueba</div>-->
            <h1 class="payment__title">Comprobante de pago</h1>

            <section class="panel payment__method__card">

                @if(isset($authorizationResult) && isset($purchaseOperationNumber))

                    <div class="header-receipt {!! ($authorizationResult == 00) ? 'ok' : 'error' !!}">
                        <h2 class="header-receipt-number">Numero de operación: {!! $purchaseOperationNumber !!}</h2>
                        <h3 class="header-receipt-status">Estado:
                            @if($authorizationResult == 00)
                                <span>Autorizada</span>
                            @endif
                            @if($authorizationResult == 01)
                                <span>Denegada en el Banco Emisor</span>
                            @endif
                            @if($authorizationResult == 05)
                                <span>Rechazada</span>
                            @endif
                        </h3>
                    </div>
                @endif
                <div class="form">
                    @if(isset($items))
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
                    @endif



                    @if($currentUser)
                        <div class="form__group">
                            <a href="{!! URL::route('profile.show', [$currentUser->username]) !!}" class="btn btn-success"
                               title="Ir a tu perfil">Ir a tus productos</a>
                        </div>
                   @endif

                </div>
            </section>






    </div>

@stop




		
		


