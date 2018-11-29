@extends('layouts.adminto.layout')
@section('header')
    @parent

    <title>   بررسی پست {{$location->name}} </title>

@endsection
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all"
          rel="stylesheet" type="text/css"/>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel   panel-default">
                    <div class="panel-heading">
                        <h4 class="header-title m-t-0 m-b-30"> Confirm post </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="POST" class="form-horizontal group-border-dashed"
                                      action="{{route('store_location')}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input name="lat" id="lat" type="hidden">
                                    <input name="longitude" id="long" type="hidden">
                                    <div class="form-group {{ $errors->has('caption') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label"> caption</label>
                                        <div class="col-sm-6">
                                            <input disabled name="name" type="text" class="form-control"
                                                   value="{{ $post->caption}}" placeholder=" caption"/>
                                            @component('input_error',['name' => 'caption'])@endcomponent

                                        </div>

                                    </div>


                                    <div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label"> دسته بندی </label>
                                        <div class="col-sm-6">
                                            <select  disabled name="category_id" class="form-control has-error">


                                                    <option  selected value="{{$location->id}}">   {{$location->name}}</option>



                                            </select>
                                            @component('input_error',['name' => 'location_id'])@endcomponent

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> هزینه : </label>
                                        <div class="col-sm-6">
                                            <input disabled name="price" type="text" class="form-control"
                                                   placeholder="   " value="{{$post->ptotal}}"/>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <br>
                                    <!-- Start description -->


                                    <h4 class="header-title m-t-0 m-b-30"> تصاویر Post </h4>

                                    <div class="form-group " >
                                        <div class="col-lg-12 col-sm-12 col-11 main-section">

                                            <div class="panel-body">

                                                @foreach($post->images as $image)
                                                    <div class="col-md-3 col-xs-6">

                                                        <div class="thumbnail">
                                                            <div class=" box-profile">
                                                                @if(isset($image->image_path))
                                                                    <img class="profile-user-img img-responsive  img-rounded"
                                                                         src="{{asset($image->image_path)}}"
                                                                         alt="User profile picture">
                                                                @endif

                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <br>


                                    <h4 class="header-title m-t-0 m-b-30">  Cost Post </h4>

                                    <div class="form-group " >
                                        <div class="col-lg-12 col-xs-12 ">

                                            <div class="panel-body">

                                                @foreach($post->prices as $price)
                                                    <div class="col-md-6 col-xs-12">

                                                        <div class="card-box" style="min-height: 80px">

                                                            <div class="col-md-4 col-xs-6">
                                                                {{$price->price}} تومان
                                                            </div>

                                                            <div class="col-md-6 col-xs-6">
                                                                {{$price->description}}
                                                            </div>



                                                            <div class="col-md-2 col-xs-6">
                                                                <div class="pull-left">
                                                                    <img width="50px" height="50px" class="img-circle"
                                                                         src="{{asset($price->image_path)}}"
                                                                         alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <br>

                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-9 m-t-15">
                                            <a href="{{route('report_not_correct',['id'=>$post->id])}}"
                                                    class="btn btn-success waves-effect waves-light">Is OK
                                            </a>



                                            <a href="{{route('admin_delete_post',['id'=>$post->id])}}" name="cancel" type="reset"
                                               class="btn btn-danger waves-effect m-l-5">DELETE </a>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- end col -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div> <!-- container -->






@stop
