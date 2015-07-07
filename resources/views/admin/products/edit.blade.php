@extends('admin.layouts.layout')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')
 @include('admin/layouts/partials/_breadcumbs', ['page' => 'Products'])
	
	{!! Form::model($product, ['method' => 'put', 'route' => ['admin.products.update', $product->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('admin/products/partials/_form', ['buttonText' => 'Update Product'])
	 
	{!! Form::close() !!}
    @include('admin/products/partials/_modal')
@stop
@section('scripts')
    <script src="/vendor/bootstrap-select/bootstrap-select.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script>

        CKEDITOR.replace( 'ckeditor' , {
            uiColor: '#FAFAFA'
        });
    </script>
@stop