@extends('admin.layouts.layout')

@section('content')
    @include('admin/layouts/partials/_breadcumbs', ['page' => 'Payments'])





    <section class="panel">
        <div class="panel-heading">
            @include('admin/payments/partials/_search')
        </div>
        <div class="panel-body no-padding">
            {!! Form::open(['route' =>['option_multiple'],'method' => 'post', 'id' =>'form-option-chk','data-confirm' => 'You are sure?']) !!}
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>user</th>
                        <th>product</th>
                        <th>Amount</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payments as $payment)
                        <tr>

                            <td>{!!$payment->id!!}</td>
                            <td>{!!$payment->user->username !!} ( {!!$payment->user->profile->first_name !!} )</td>
                            <td>{!!$payment->product->name !!}</td>
                            <td>{!! money($payment->amount, '₡') !!}</td>
                            <td class="center">{!! $payment->created_at !!}</td>


                            <td class="center">

                               <!-- <a class="btn btn-info" href="{!! URL::route('admin.payments.edit', [$payment->id]) !!}">
                                    <i class="fa fa-edit"></i>
                                </a>-->
                                <button type="submit" class="btn btn-danger" form="form-delete"
                                        formaction="{!! URL::route('admin.payments.destroy', [$payment->id]) !!}">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>

                    @if ($payments)
                        <td colspan="10" class="pagination-container">{!!$payments->render()!!}
                        </td>
                    @endif


                    </tfoot>
                </table>
            </div>
            {!! Form::close() !!}
        </div>
    </section>


    {!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}
@stop