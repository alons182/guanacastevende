@extends('admin.layouts.layout')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')
    @include('admin/layouts/partials/_breadcumbs', ['page' => 'Users'])

        {!! Form::open(['route'=>'user_register.store','class'=>'form-horizontal']) !!}

            @include('admin/users/partials/_form')

        {!! Form::close() !!}

@stop
@section('scripts')
    <script src="/vendor/bootstrap-select/bootstrap-select.js"></script>

@stop


