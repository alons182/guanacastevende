@extends('admin.layouts.layout')

@section('content')
    @include('admin/layouts/partials/_breadcumbs', ['page' => 'Products'])





    <section class="panel">
        <div class="panel-heading" style="overflow: hidden;">
            {!! link_to_route('admin.products.create','New Product',null,['class'=>'btn btn-success']) !!}
            @include('admin/products/partials/_search')
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'You are sure?']) !!}
            <button type="submit" class="btn-multiple btn btn-success btn-sm " data-action="active" title="Active"><i class="fa fa-check-circle"></i></button>
            <button type="submit" class="btn-multiple btn btn-danger btn-sm " data-action="inactive" title="Inactive"><i class="fa fa-times-circle"></i></button>
            <!--<button type="submit" class="btn-multiple btn btn-danger btn-sm " data-action="delete" title="Delete"><i class="fa fa-trash-o"></i></button>-->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>{!! Form::checkbox('select_all', 0, null, ['id' => 'select-all']) !!}
                            {!! Form::hidden('select_action', null, ['id' => 'select-action']) !!} 
                         </th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>

                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($products as $product)
                        <tr>
                            <td>{!! Form::checkbox('chk_product[]', $product->id, null, ['class' => 'chk-product']) !!}</td>
                            <td>{!!$product->id!!}</td>
                            <td>{!!$product->name!!}</td>
                            <td>{!! str_limit($product->description, 20) !!}</td>
                            <td class="center">{!! $product->created_at !!}</td>

                            <td class="center">
                                @if ($product->published)
                                    @if($product->published == 1)
                                        <button type="submit"  class="btn btn-success btn-xs" form="form-pub-unpub" formaction="{!! URL::route('products.unpub', [$product->id]) !!}">Active</button>
                                    @elseif($product->published == 2)
                                        <button type="submit"  class="btn btn-warning btn-xs" form="form-pub-unpub" formaction="{!! URL::route('products.pub', [$product->id]) !!}">Waiting</button>
                                    @elseif($product->published == 3)
                                        <button type="submit"  class="btn btn-danger btn-xs" form="form-pub-unpub" formaction="{!! URL::route('products.pub', [$product->id]) !!}">Inactive(Pago rechazado o denegado)</button>
                                    @elseif($product->published == 4)
                                        <button type="submit"  class="btn btn-default btn-xs" form="form-pub-unpub" formaction="{!! URL::route('products.pub', [$product->id]) !!}">Selled</button>
                                    @endif

                                @else
                                    <button type="submit"  class="btn btn-danger btn-xs  "form="form-pub-unpub" formaction="{!! URL::route('products.pub', [$product->id]) !!}" >Inactive</button>
                                @endif

                                @if ($product->featured)
                                    <button type="submit"  class="btn btn-primary btn-xs" form="form-feat-unfeat" formaction="{!! URL::route('products.unfeat', [$product->id]) !!}" >Featured</button>
                                @else
                                    <button type="submit"  class="btn btn-danger btn-xs" form="form-feat-unfeat" formaction="{!! URL::route('products.feat', [$product->id]) !!}">Not Featured</button>
                                    @endif
                                            <!--<span class="label label-success">Active</span>-->
                            </td>
                            <td class="center">

                                <a class="btn btn-info" href="{!! URL::route('admin.products.edit', [$product->id]) !!}">
                                <i class="fa fa-edit"></i>
                                </a>
                                <!--<button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route('admin.products.destroy', [$product->id]) !!}">
                                <i class="fa fa-trash-o"></i>
                                </button>-->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($products)
                        <td  colspan="10" class="pagination-container">{!!$products->appends(['q' => $search,'published'=>$selectedStatus])->render()!!}</td>
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