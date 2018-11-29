@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title>  edit Permission </title>

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Permission</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('modifyPermission',['id'=>$permissions->id]) }}">
                            {{ csrf_field() }}
                            {{method_field('patch')}}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ $permissions->name }}">

                                    @component('input_error',['name' => 'name'])@endcomponent

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                <label for="label" class="col-md-4 control-label">Label</label>

                                <div class="col-md-6">
                                    <input id="label" type="text" class="form-control" name="label"
                                           value="{{ $permissions->label }}">

                                    @component('input_error',['name' => 'label'])@endcomponent

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
                </div>
            </div>
        </div>




    </div>
@stop