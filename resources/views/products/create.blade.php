@extends('layouts.layout')

@section('meta-title')Guanacaste Vende | Creando un nuevo producto @stop
@section('meta-description')Creando un nuevo producto @stop
@section('content')
    <div class="product">
            {!! Form::open(['route'=>'products.store','files'=> true, 'class'=>'form-horizontal']) !!}

                @include('products/partials/_form')

            {!! Form::close() !!}
    </div>


@stop
@section('scripts')
    <!--<script src="/vendor/ckeditor/ckeditor.js"></script>
    <script>

        CKEDITOR.replace( 'ckeditor' , {
            uiColor: '#FAFAFA',
            forcePasteAsPlainText : true,
            removePlugins : 'sourcearea'


        });
    </script>-->
@stop


