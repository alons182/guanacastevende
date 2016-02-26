@extends('layouts.layout')

@section('meta-title')Guanacaste Vende | Creando un nuevo producto @stop
@section('meta-description')Creando un nuevo producto @stop
@section('content')
    <div class="product">
            {!! Form::open(['route'=>'products.store','files'=> true, 'class'=>'form-horizontal dropzone']) !!}

                @include('products/partials/_form')

            {!! Form::close() !!}
    </div>


@stop
@section('scripts')
   
@stop


