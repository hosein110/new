@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title>     ویرایش کاربر {{$users->name}} </title>

@endsection
@section('content')
    <div class="container">
        <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit User</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('edit_user',['id'=>$users->id]) }}">
                            {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="fullname"
                                           value="{{ $users->fullname }}">

                                    @component('input_error',['name' => 'fullname'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ $users->email }}">

                                    @component('input_error',['name' => 'email'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                <label for="mobile" class="col-md-4 control-label">Mobile</label>

                                <div class="col-md-6">
                                    <input id="mobile" type="number" class="form-control" name="mobile"
                                           value="{{ $users->mobile }}">

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

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Role</label>

                                <div class="col-md-6">
                                    <select name="roles[]" multiple class="form-control">
                                        @if(sizeof($users->roles)>0)
                                            @foreach($users->roles as $role1)
                                                {!! $arr_role[]=$role1->name !!}
                                            @endforeach
                                        @else
                                            {!! $arr_role[]='' !!}
                                        @endif
                                        @foreach($AllRoles as $role)

                                            @if(in_array($role->name,$arr_role))
                                                <option value="{{$role->id}}" selected>{{$role->name}}</option>
                                            @else
                                                <option value="{{$role->id}}">{{$role->name}}</option>

                                            @endif


                                        @endforeach

                                    </select>
                                    @component('input_error',['name' => 'password'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Permission</label>

                                <div class="col-md-6">
                                    <select multiple class="form-control js-example-basic-multiple">
                                        @if(sizeof($users->roles)>0)
                                            @foreach($role1->permissions as $permission1)
                                                {!! $arr_permission[]=$permission1->name !!}
                                            @endforeach
                                        @else
                                            {!! $arr_permission[]='' !!}
                                        @endif
                                        @foreach($AllPermissions as $permission)

                                            @if(in_array($permission->name,$arr_permission))
                                                <option selected>{{$permission->name}}</option>
                                            @else
                                                <option>{{$permission->name}}</option>

                                            @endif


                                        @endforeach


                                    </select>
                                    @component('input_error',['name' => 'password'])@endcomponent

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Update Profile
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();

        });
    </script>
@stop
