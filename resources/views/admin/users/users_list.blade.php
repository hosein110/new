@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title>   لیست کاربران </title>

@endsection
@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">


                <div class="table-rep-plugin">
                    <div class="table-wrapper">
                        <div class="btn-toolbar">
                            <div class="btn-group focus-btn-group">

                            </div>
                            <div class="btn-group dropdown-btn-group pull-right">
                                <form method="get" action="" class="input-group" style="width: 250px;">

                                    <input type="text" name="keyword" class="form-control input-sm pull-right"
                                           placeholder="Search">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-default"><i
                                                    class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive" data-pattern="priority-columns">

                            <table id="tech-companies-1" class="table  table-striped">
                                <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>mobile</th>
                                    <th>create_at</th>

                                    <th>Role</th>
                                    <th>Permissions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->fullname}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>@foreach($user->roles as $role)
                                                <code>{{$role->label}}</code>
                                        <td>
                                            @if(isset($role->permissions) )
                                                @foreach($role->permissions as $permission)
                                                    <code>[{{$permission->label}}]</code>
                                                @endforeach
                                            @endif
                                        </td>
                                        @endforeach






                                        </td>


                                        <td>
                                            {{--<a href="{{route('active_user',['id'=>$user->id,'status'=>$user->status])}}"> {{active($user->status)}}</a>--}}
                                            <a href="{{route('edit_user_form',['id'=>$user->id])}}"><span class="btn btn-info btn-xs >"> edit</span></a>

                                        </td>
                                    </tr>


                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>





        {{$users->appends($_GET)->links()}}
    </div>
@stop