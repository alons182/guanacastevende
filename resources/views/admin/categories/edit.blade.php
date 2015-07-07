@extends('admin.layouts.layout')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')
 @include('admin/layouts/partials/_breadcumbs', ['page' => 'Categories'])
	
	{!! Form::model($category, ['method' => 'put', 'route' => ['admin.categories.update', $category->id],'files'=> true,'class'=>'form-horizontal' ]) !!}
		
		@include('admin/categories/partials/_form', ['buttonText' => 'Update Category'])
	 
	{!! Form::close() !!}

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