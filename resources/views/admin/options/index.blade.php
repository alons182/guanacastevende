@extends('admin.layouts.layout')

@section('content')
    @include('admin/layouts/partials/_breadcumbs', ['page' => 'Options'])





    <section class="panel">
        <div class="panel-heading">
            {!! link_to_route('admin.options.create','New Option',null,['class'=>'btn btn-success']) !!}

        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'You are sure?']) !!}
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($options as $option)
                        <tr>

                            <td>{!!$option->id!!}</td>
                            <td>{!!$option->name!!}</td>
                            <td>{!! money($option->price, '₡') !!}</td>
                            <td class="center">{!! $option->created_at !!}</td>


                            <td class="center">

                                <a class="btn btn-info" href="{!! URL::route('admin.options.edit', [$option->id]) !!}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="submit" class="btn btn-danger" form="form-delete"
                                        formaction="{!! URL::route('admin.options.destroy', [$option->id]) !!}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($options)
                        <td colspan="10" class="pagination-container">{!!$options->render()!!}
                        </td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>






    {!! Form::open(array('method' => 'post', 'id' => 'form-pub-unpub')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}
@stop