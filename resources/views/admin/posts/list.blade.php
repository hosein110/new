@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title> لیست پست ها  {{$type}}  </title>

@endsection
@section('content')
    <div class="container">
        <div class="row">


            <div class="col-md-12 col-md-offset-0">

                <div class="panel ">

                    <div class="panel-heading">
                        {{$type}} Posts


                    </div>


                </div>
                <div class="card-box">
                    {{--<form role="search" method="get" class="">--}}

                    {{--<div class="col-md-4 col-xs-3">--}}
                    {{--<select class="form-control " name="state">--}}
                    {{--<option value="">تعیین استان</option>--}}
                    {{--@foreach($states as $state)--}}
                    {{--@if( isset($_GET['state']) && $_GET['state']==$state->id)--}}
                    {{--<option selected value="{{$state->id}}">{{$state->name}}</option>--}}
                    {{--@else--}}
                    {{--<option value="{{$state->id}}">{{$state->name}}</option>--}}
                    {{--@endif--}}
                    {{--@endforeach--}}

                    {{--</select>--}}
                    {{--</div>--}}

                    {{--<div class="col-md-4 col-xs-3">--}}
                    {{--<select class="form-control" name="category">--}}
                    {{--<option value="">تعیین دسته بندی</option>--}}

                    {{--@foreach($categories as $category)--}}
                    {{--@if( isset($_GET['category']) && $_GET['category']==$category->id)--}}
                    {{--<option selected value="{{$category->id}}">{{$category->title}}</option>--}}
                    {{--@else--}}
                    {{--<option value="{{$category->id}}">{{$category->title}}</option>--}}
                    {{--@endif--}}
                    {{--@endforeach--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 col-xs-3">--}}
                    {{--<button class="btn btn-success btn-sm btn-block">جستجو</button>--}}
                    {{--</div>--}}
                    {{--<br>--}}
                    {{--<br>--}}
                    {{----}}
                    {{--</form>--}}
                    {{----}}


                    <div class="panel-body">
                        @if(sizeof($posts)>0)
                            @foreach($posts as $post)
                                <div class="col-md-3 col-xs-6">

                                    <div class="thumbnail">
                                        <div class=" box-profile">

                                            <span style="position: absolute;"
                                                  class="btn  btn-xs btn-facebook circle-icon">{{$post->reports_count}}</span>

                                            @if(isset($post->image->image_path))
                                                <img class="profile-user-img img-responsive  img-rounded"
                                                     src="{{asset($post->image->image_path)}}"
                                                     alt="User profile picture">
                                            @endif

                                            <h5 class="profile-username text-center"> {{$post->name}}</h5>
                                            <a href="{{route('admin_post_confirm',['post_id'=>$post->id])}}"
                                               class="btn btn-info btn-xs btn-block">Show</a>

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">no reported Post</div>
                        @endif

                    </div>
                </div>

                {{$posts->appends($_GET)->links()}}
            </div>
        </div>
@stop
