@extends('admin.layouts.layout')

@section('css')
    <link rel="stylesheet" href="/vendor/bootstrap-select/bootstrap-select.css">

@stop
@section('content')
    @include('admin/layouts/partials/_breadcumbs', ['page' => 'Users'])

        {!! Form::model($user, ['method' => 'put', 'route' => ['admin.users.update', $user->id],'class'=>'form-horizontal' ]) !!}
        		 @include('admin/users/partials/_form',['buttonText' => 'Update User'])
        {!! Form::close() !!}


@stop
@section('scripts')
    <script src="/vendor/bootstrap-select/bootstrap-select.js"></script>

@stop

