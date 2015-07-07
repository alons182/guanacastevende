@extends('admin.layouts.layout')


@section('content')
 @include('admin/layouts/partials/_breadcumbs', ['page' => 'Tags'])
	
	{!! Form::model($tag, ['method' => 'put', 'route' => ['admin.tags.update', $tag->id],'class'=>'form-horizontal' ]) !!}
		
		@include('admin/tags/partials/_form', ['buttonText' => 'Update Tag'])
	 
	{!! Form::close() !!}

@stop
