@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title>   پروفایل {{ $users->name }}  </title>

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">My Profile</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('admin_modify_profile') }}"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{method_field('patch')}}
                            <input name="image_path" value="{{$users->image_path}}" type="hidden">
                            <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">fullname</label>

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


                            <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
                                <label for="language" class="col-md-4 control-label">Language</label>

                                <div class="col-md-6">
                                    <select id="language" class="form-control" name="language">
                                        @if($users->language=='fa')
                                            <option value="fa"> Farsi</option>
                                            <option value="en"> English</option>
                                        @elseif($users->language=='en')
                                            <option value="en"> English</option>
                                            <option value="fa">Farsi</option>
                                        @endif
                                    </select>
                                    @component('input_error',['name' => 'language'])@endcomponent

                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                <label for="file" class="col-md-4 control-label">Photo</label>

                                <div class="col-md-6">
                                    <input id="file" type="file" class="form-control" name="file">

                                    <i><img src="{{url($users->image_path)}}" class="img-responsive" height="60px"
                                            width="60px"></i>

                                    @component('input_error',['name' => 'file'])@endcomponent

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
@stop
