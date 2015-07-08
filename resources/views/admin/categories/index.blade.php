@extends('admin.layouts.layout')

@section('content')
    @include('admin/layouts/partials/_breadcumbs', ['page' => 'Categories'])





    <section class="panel">
        <div class="panel-heading">
            {!! link_to_route('admin.categories.create','New Category',null,['class'=>'btn btn-success']) !!}
            @include('admin/categories/partials/_search')
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['destroy_multiple'],'method' => 'post', 'id' =>'form-delete-chk','data-confirm'
            => 'You are sure?']) !!}
            <button type="submit" class="delete-multiple btn btn-danger btn-sm "><i class="fa fa-trash-o"></i></button>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>

                            <td>{!!$category->id!!}</td>
                            <td>
                                @if ($category->depth > 0 )
                                    {!! get_depth($category->depth)!!} {!!$category->name!!}
                                @else
                                    {!!$category->name!!}
                                @endif
                            </td>
                            <td>{!! str_limit($category->description, 20) !!}</td>
                            <td class="center">{!! $category->created_at !!}</td>

                            <td class="center">
                                @if ($category->published)
                                    <button type="submit" class="btn btn-success btn-xs" form="form-pub-unpub"
                                            formaction="{!! URL::route('categories.unpub', [$category->id]) !!}">Active
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-danger btn-xs  " form="form-pub-unpub"
                                            formaction="{!! URL::route('categories.pub', [$category->id]) !!}">Inactive
                                    </button>
                                @endif

                                @if ($category->featured)
                                    <button type="submit" class="btn btn-primary btn-xs" form="form-feat-unfeat"
                                            formaction="{!! URL::route('categories.unfeat', [$category->id]) !!}">
                                        Featured
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-danger btn-xs" form="form-feat-unfeat"
                                            formaction="{!! URL::route('categories.feat', [$category->id]) !!}">Not
                                        Featured
                                    </button>
                                @endif

                            </td>
                            <td class="center">

                                <a class="btn btn-info"
                                   href="{!! URL::route('admin.categories.edit', [$category->id]) !!}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="submit" class="btn btn-danger" form="form-delete"
                                        formaction="{!! URL::route('admin.categories.destroy', [$category->id]) !!}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </td>
                            <td>
                                @if (!$category->isRoot())
                                    <div class="btn-group actions">

                                            <button class="btn btn-xs btn-link" type="submit" title="Move up"
                                                    form="form-up-down"
                                                    formaction="{!! URL::route('categories.up', array($category->id)) !!}" >
                                            <i class="glyphicon glyphicon-chevron-up"></i>
                                            </button>
                                            <button class="btn btn-xs btn-link" type="submit" title="Move down"
                                                    form="form-up-down"
                                                    formaction="{!! URL::route('categories.down', array($category->id)) !!}" >
                                                <i class="glyphicon glyphicon-chevron-down"></i>
                                            </button>


                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($categories)
                        <td colspan="10" class="pagination-container">{!!$categories->appends(['q' =>
                            $search,'published'=>$selectedStatus])->render()!!}
                        </td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>

    {!! Form::open(['method' => 'post', 'id' => 'form-up-down']) !!}{!! Form::close() !!}
    {!! Form::open(array('method' => 'post', 'id' => 'form-pub-unpub')) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'post', 'id' => 'form-feat-unfeat']) !!}{!! Form::close() !!}
    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}
@stop