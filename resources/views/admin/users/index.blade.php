@extends('admin.layouts.layout')

@section('content')
	@include('admin/layouts/partials/_breadcumbs', ['page' => 'Users'])

	 <section class="panel">
        <div class="panel-heading">
            {!! link_to_route('user_register','New User',null,['class'=>'btn btn-success']) !!}
               @include('admin/users/partials/_search')
        </div>
        <div class="panel-body no-padding">


                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Username</th>
                                  <th>Email</th>
                                  <th>Created</th>
                                  <th>Status</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{!! $user->id !!}</td>
                                    <td>{!! $user->username !!}
                                    <td>{!! $user->email !!}</td>

                                    <td class="center">{!! $user->created_at !!}</td>

                                    <td class="center">
                                        @if ($user->active)
                                            <button type="submit"  class="btn btn-success btn-xs" form="form-active-inactive" formaction="{!! URL::route("users.inactive", [$user->id]) !!}">Active </button>
                                        @else
                                            <button type="submit"  class="btn btn-danger btn-xs"form="form-active-inactive" formaction="{!! URL::route("users.active", [$user->id]) !!}" > Inactive </button>
                                        @endif
                                        <!--<span class="label label-success">Active</span>-->
                                    </td>
                                    <td class="center">

                                        <a class="btn btn-info" href="{!! URL::route("admin.users.edit", [$user->id]) !!}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                         <button type="submit" class="btn btn-danger" form="form-delete" formaction="{!! URL::route("admin.users.destroy", [$user->id]) !!}">
                                            <i class="fa fa-trash-o"></i>
                                        </button>


                                    </td>
                                </tr>
                            @endforeach
                          </tbody>
                          <tfoot>

                                      @if ($users)
                                          <td  colspan="10" class="pagination-container">{!!$users->appends(['q' => $search])->render()!!}</td>
                                           @endif


                                  </tfoot>
                      </table>


                </div>
        </div>
     </section>




{!! Form::open(array('method' => 'post', 'id' => 'form-active-inactive')) !!}{!! Form::close() !!}
{!! Form::open(['method' => 'delete', 'id' =>'form-delete','data-confirm' => 'You are sure?']) !!}{!! Form::close() !!}
@stop