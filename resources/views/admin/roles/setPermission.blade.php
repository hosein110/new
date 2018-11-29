@if(!isset($_GET['role_id']))
<?php $_GET['role_id']=1; ?>
@endif

@section('header')
    @parent

    <title>  Permission </title>

@endsection
@extends('layouts.adminto.layout')
@section('content')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet">
    <div class="container">
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading"> Set Permission</div>
                <div class="panel-body">


                    <div class="col-md-6 col-md-offset-0">

                        <form class="form-horizontal" method="POST" action="{{ route('modifyPermissionRole') }}">
                            {{ csrf_field() }}
                            {{method_field('patch')}}

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

                            <div class="form-group{{ $errors->has('permission') ? ' has-error' : '' }}">
                                <label for="permission" class="col-md-4 control-label">permission</label>

                                <div class="col-md-6">
                                    <select class="js-example-basic-multiple form-control" name="permission[]"
                                            multiple="multiple" required>

                                        {!! $arr_permission[]=""!!}
                                        {!! $permissions=(new App\Http\Controllers\admin\RolesController)->getAjaxPermission($_GET['role_id']) !!}

                                        @if(isset($permissions))
                                            @foreach($permissions as $permission)
                                                {!! $arr_permission[]=$permission->id !!}
                                            @endforeach
                                            @foreach($AllPermissions as $ALLPERMISSION)
                                                @if(in_array($ALLPERMISSION->id,$arr_permission))
                                                    <option selected
                                                            value="{{$ALLPERMISSION->id}}">{{$ALLPERMISSION->label}}</option>
                                                @else
                                                    <option value="{{$ALLPERMISSION->id}}">{{$ALLPERMISSION->label}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>

                                    @component('input_error',['name' => 'permission'])@endcomponent

                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>


                    </div>
                    <div class="list-group col-md-4 col-md-offset-0">

                        @foreach($AllRoles as $role)

                            <a href="#" class="list-group-item active"> {{$role->name}}--{{$role->label}}</a>
                            @foreach($role->permissions as $permission)

                                <a href="#" class="list-group-item "> {{$permission->name}} - - {{$permission->label}}</a>


                            @endforeach

                        @endforeach

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
    <script>
        $('#selected_role<?php echo $_GET['role_id'];?>').prop("selected", true);

        function change_roles() {
            role_id = $('#role').val();

            location.href = "setPermission?role_id=" + role_id;
        }

    </script>
@stop