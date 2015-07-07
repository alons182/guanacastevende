@extends('admin.layouts.layout')

@section('content')

 @include('admin/layouts/partials/_breadcumbs', ['page' => 'Tags'])

            {!! Form::open(['route'=>'admin.tags.store', 'class'=>'form-horizontal']) !!}

                @include('admin/tags/partials/_form')

            {!! Form::close() !!}



@stop


