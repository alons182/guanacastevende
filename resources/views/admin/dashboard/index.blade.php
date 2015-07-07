@extends('admin.layouts.layout')

@section('content')

	 <div class="row mg-b">
        <div class="col-xs-6">
            <h3 class="no-margin">Dashboard</h3>
            <small>Welcome back, {{ $currentUser->username }}</small>
        </div>
        <div class="col-xs-6 text-right">
            <a href="#" class="fa fa-flash pull-right pd-sm toggle-chat toggle-sidebar" data-toggle="off-canvas" data-move="rtl">
                <span class="badge bg-danger animated flash">6</span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="circle-icon bg-success">
                        <i class="fa fa-users"></i>
                    </div>
                    <div>

                         <a href="/admin/users">
                             <h3 class="no-margin">{{ $tu }}</h3>
                             Users
                         </a>
                    </div>
                </div>
            </section>
        </div>
         <div class="col-md-3 col-sm-6 col-xs-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="circle-icon bg-danger">
                        <i class="fa fa-coffee"></i>
                    </div>
                    <div>

                        <a href="/admin/products">
                            <h3 class="no-margin">{{ $tp }}</h3>
                            Products
                        </a>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="circle-icon bg-warning">
                        <i class="fa fa-folder"></i>
                    </div>
                    <div>

                        <a href="/admin/categories">
                            <h3 class="no-margin">{{ $tc }}</h3>
                            Categories
                        </a>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="circle-icon bg-info">
                        <i class="fa fa-tags"></i>
                    </div>
                    <div>

                        <a href="/admin/categories">
                            <h3 class="no-margin">{{ $tt }}</h3>
                            Tags
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>



@stop