@extends('admin.layouts.layout')


@section('content')
 @include('admin/layouts/partials/_breadcumbs', ['page' => 'Options'])
	
	{!! Form::model($option, ['method' => 'put', 'route' => ['admin.options.update', $option->id],'class'=>'form-horizontal' ]) !!}
		
		@include('admin/options/partials/_form', ['buttonText' => 'Update Option'])
	 
	{!! Form::close() !!}

@stop
