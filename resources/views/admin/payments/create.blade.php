@extends('admin.layouts.layout')

@section('content')

 @include('admin/layouts/partials/_breadcumbs', ['page' => 'Options'])

            {!! Form::open(['route'=>'admin.options.store', 'class'=>'form-horizontal']) !!}

                @include('admin/options/partials/_form')

            {!! Form::close() !!}



@stop


