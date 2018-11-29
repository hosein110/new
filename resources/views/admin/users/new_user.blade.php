@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title> کاربر جدید </title>

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">New user</div>


                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('save') }}">
                            {{ csrf_field() }}



                            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                <label for="role" class="col-md-4 control-label">role</label>

                                <div class="col-md-6">
                                    <select onchange="change_roles()" id="role" type="text" class="form-control"
                                            name="role">

                                        @foreach($AllRoles as $role)
                                            <option id="selected_role{{$role->id}}"
                                                    value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>

                                    @component('input_error',['name' => 'role'])@endcomponent

                                </div>
                            </div>



                            {{--<div class="form-group{{ $errors->has('template') ? ' has-error' : '' }}">--}}
                                {{--<label for="name" class="col-md-4 control-label">Template</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<select id="template"  class="form-control" name="template"  >--}}
                                        {{--<option value="1">sb_admin</option>--}}
                                        {{--<option value="2">admin_lte</option>--}}
                                        {{--<option value="3">adminto</option>--}}
                                    {{--</select>--}}

                                    {{--@if ($errors->has('template'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('template') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">

                                    @component('input_error',['name' => 'name'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @component('input_error',['name' => 'email'])@endcomponent

                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label for="mobile" class="col-md-4 control-label">Mobile</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="number" class="form-control" name="mobile" value="{{ old('mobile') }}">

                                    @component('input_error',['name' => 'mobile'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @component('input_error',['name' => 'password'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">



                                    @component('input_error',['name' => 'password_confirmation'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop