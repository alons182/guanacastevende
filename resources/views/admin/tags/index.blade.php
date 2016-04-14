@extends('admin.layouts.layout')

@section('content')
    @include('admin/layouts/partials/_breadcumbs', ['page' => 'Tags'])





    <section class="panel">
        <div class="panel-heading">
            {!! link_to_route('admin.tags.create','New Tag',null,['class'=>'btn btn-success']) !!}
            @include('admin/tags/partials/_search')
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'You are sure?']) !!}
            <button type="submit" class="delete-multiple btn btn-danger btn-sm "><i class="fa fa-trash-o"></i></button>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tags as $tag)
                        <tr>

                            <td>{!!$tag->id!!}</td>
                            <td>{!!$tag->name!!}</td>
                            <td>{!!$tag->products()->count() !!}</td>
                            <td class="center">{!! $tag->created_at !!}</td>


                            <td class="center">

                                <a class="btn btn-info" href="{!! URL::route('admin.tags.edit', [$tag->id]) !!}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="submit" class="btn btn-danger" form="form-delete"
                                        formaction="{!! URL::route('admin.tags.destroy', [$tag->id]) !!}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($tags)
                        <td colspan="10" class="pagination-container">{!!$tags->appends(['q' => $search])->render()!!}
                        </td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>






    {!! Form::open(array('method' => 'post', 'id' => 'form-pub-unpub')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'post', 'id' => 'form-feat-unfeat']) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}
@stop