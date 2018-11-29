@extends('layouts.adminto.layout')

@section('header')
    @parent

    <title> لیست مکانها  {{$type}}  </title>

@endsection
@section('content')


    <div class="container">
        <div class="row">


            <div class="col-md-12 col-md-offset-0">

                <div class="panel ">

                    <div class="panel-heading">
                        <div class="pull-left">
                            {{$type}}   Locations
                        </div>

                        <div class="pull-right">
                            <a href="{{route('create_location')}}" class="btn btn-facebook">مکان جدبد</a>
                        </div>

                    </div>


                    <br> <br>
                </div>
                <div class="card-box">
                    <form role="search" method="get" class="">

                        <div class="col-md-4 col-xs-3">
                            <select class="form-control " name="state">
                                <option value="">تعیین استان</option>
                                @foreach($states as $state)
                                    @if( isset($_GET['state']) && $_GET['state']==$state->id)
                                        <option selected value="{{$state->id}}">{{$state->name}}</option>
                                    @else
                                        <option value="{{$state->id}}">{{$state->name}}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-4 col-xs-3">
                            <select class="form-control" name="category">
                                <option value="">تعیین دسته بندی</option>

                                @foreach($categories as $category)
                                    @if( isset($_GET['category']) && $_GET['category']==$category->id)
                                        <option selected value="{{$category->id}}">{{$category->title}}</option>
                                    @else
                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-xs-3">
                            <button class="btn btn-success btn-sm btn-block">جستجو</button>
                        </div>
                        <br>
                        <br>


                </form>
                <div class="panel-body">

                    @foreach($locations as $location)
                        <div class="col-md-3 col-xs-6">

                            <div class="thumbnail">
                                <div class=" box-profile">
                                    @if($location->reports_count>0)
                                        <span style="position: absolute;" class="btn  btn-xs btn-facebook circle-icon">{{$location->reports_count}}</span>
                                    @endif
                                    @if(isset($location->image->image_path))
                                        <img class="profile-user-img img-responsive  img-rounded"
                                             src="{{asset($location->image->image_path)}}"
                                             alt="User profile picture">
                                    @endif

                                    <h5 class="profile-username text-center"> {{$location->name}}</h5>
                                    <a href="{{route('edit_location',['id'=>$location->id,'type'=>$type])}}" class="btn btn-facebook btn-xs btn-block">نمایش مکان</a>

                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            {{$locations->appends($_GET)->links()}}
        </div>
    </div>
@stop
