@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title>  new role </title>

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">New Role</div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('createRole') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">عنوان</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}">

                                    @component('input_error',['name' => 'name'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                <label for="label" class="col-md-4 control-label">برچسب</label>

                                <div class="col-md-6">
                                    <input id="label" type="text" class="form-control" name="label"
                                           value="{{ old('label') }}">

                                    @component('input_error',['name' => 'label'])@endcomponent

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> ثبت
                                    </button>
                                </div>
                            </div>
                        </form>




                    </div>
                </div>
            </div>
             <div class="col-md-5 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">New Permission</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('createPermission') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name11') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">عنوان</label>

                                <div class="col-md-6">
                                    <input id="name1" type="text" class="form-control" name="name1"
                                           value="{{ old('name1') }}">

                                    @component('input_error',['name' => 'name1'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('label1') ? ' has-error' : '' }}">
                                <label for="label" class="col-md-4 control-label">برچسب</label>

                                <div class="col-md-6">
                                    <input id="label1" type="text" class="form-control" name="label1"
                                           value="{{ old('label1') }}">

                                    @component('input_error',['name' => 'label1'])@endcomponent

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> ثبت
                                    </button>
                                </div>
                            </div>
                        </form>




                    </div>
                </div>
            </div>

        </div>

       @include('admin.roles.roles_permissions_list')



    </div>
@stop