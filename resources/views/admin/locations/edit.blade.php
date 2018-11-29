@extends('layouts.adminto.layout')
@section('header')
    <style>
        #map {
            direction: rtl !important;
        }
    </style>
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all"
          rel="stylesheet" type="text/css"/>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css' rel='stylesheet' />

    <title> ویرایش مکان جدید</title>


    @parent
@endsection
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel   panel-default">
                    <div class="panel-heading">
                        <h4 class="header-title m-t-0 m-b-30">ویرایش مکان </h4>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="POST" class="form-horizontal group-border-dashed"
                                      action="{{route('update_location',$location->id)}}"
                                      enctype="multipart/form-data">
                                    {{ method_field('PATCH') }}
                                    @csrf
                                    <input name="longitude" id="lat" type="">
                                    <input name="lat" id="long" type="">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label">نام مکان</label>
                                        <div class="col-sm-6">
                                            <input name="name" type="text" class="form-control"
                                                   value="{{ $location->name }}"
                                                   placeholder=" نام مکان  را وارد کنید"/>
                                            @component('input_error',['name' => 'name'])@endcomponent

                                        </div>

                                    </div>


                                    <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label"> دسته بندی </label>
                                        <div class="col-sm-6">
                                            <select name="category_id" class="form-control has-error">
                                                <option value=""></option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}"
                                                            @if($category->id==$location->category_id) selected @endif>   {{$category->title}}</option>
                                                @endforeach


                                            </select>
                                            @component('input_error',['name' => 'category_id'])@endcomponent

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-3">شماره تماس</label>
                                        <div class="col-sm-6">
                                            <div class="input-group">
                                                <input type="text" name="tel" class="form-control"
                                                       placeholder="شماره تماس را وارد کنید" value="{{$location->tel}}">
                                                <span class="input-group-addon"><i class="zmdi zmdi-phone"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('state_id') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label"> استان </label>
                                        <div class="col-sm-6">
                                            <select id="edit_state" name="state_id" class="form-control"
                                                    data-placeholder="با کلیک کردن روی این قسمت استان مورد نظر را انتخاب کنید...">
                                                <option value=""></option>
                                                @foreach($state as $id => $name)
                                                    <option value="{{ $id }}"
                                                            @if($id==$location->state_id) selected @endif>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @component('input_error',['name' => 'state_id'])@endcomponent

                                        </div>
                                    </div>
                                    <div class="form-group  {{ $errors->has('city_id') ? ' has-error' : '' }}"
                                         id="cities">
                                        <label class="col-sm-3 control-label"> شهر </label>
                                        <div class="col-sm-6">
                                            <select id="edit_city" name="city_id" class="form-control"
                                                    data-placeholder="با کلیک کردن روی این قسمت شهر مورد نظر را انتخاب کنید...">
                                                <option value=""></option>
                                                @foreach($city as $id => $name)
                                                    <option value="{{ $id }}"
                                                            @if($id==$location->city_id) selected @endif>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @component('input_error',['name' => 'city_id'])@endcomponent

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> هزینه : </label>
                                        <div class="col-sm-6">
                                            <input name="price" type="text" class="form-control"
                                                   placeholder="   " value="{{ $location->price }}"/>
                                        </div>
                                    </div>
                                    <!-- end-project-profile -->
                                    <br>
                                    <hr>
                                    <br>
                                    <div id='map' style='width:100%; height: 400px;'></div>


                                    <br>
                                    <hr>
                                    <br>
                                    <!-- Start description -->
                                    <h4 class="header-title m-t-0 m-b-30"> امکانات تفریحی </h4>
                                    <div class="form-group">

                                        @foreach($environments as $environment)

                                            <div class="col-md-3">
                                                <label class="col-md-6 control-label"> {{$environment->title}} </label>

                                                <input name="environment[]" type="checkbox"  value="{{$environment->id}}"
                                                       class="checkbox-info"
                                                       @if(in_array($environment->id,$location_environments)) checked @endif>
                                            </div>
                                        @endforeach
                                    </div>

                                    <br>
                                    <hr>
                                    <br>
                                    <h4 class="header-title m-t-0 m-b-30"> حمل و نقل </h4>
                                    <div class="form-group">
                                        @foreach($transfers as $transfer)
                                            <div class="col-md-3">
                                                <label class="col-md-6 control-label"> {{$transfer->title}} </label>
                                                <input name="transfer[]" type="checkbox"   class="checkbox-info"
                                                       @if(in_array($transfer->id,$location_transfers)) checked @endif
                                                       value="{{$transfer->id}}">
                                            </div>
                                        @endforeach


                                    </div>


                                    <br>
                                    <hr>
                                    <br>
                                    <h4 class="header-title m-t-0 m-b-30"> تصاویر مکان </h4>
                                    <div class="form-group " id="image_area">
                                        <div class="col-lg-12 col-sm-12 col-11 main-section">
                                            <h1 class="text-center text-danger"></h1><br>
                                            <div class="form-group">

                                                <div class="file-loading">


                                                    <input id="file-1" type="file" name="images[]" multiple class="file"
                                                           data-overwrite-initial="false" data-min-file-count="2">
                                                </div>
                                            </div>

                                            @component('input_error',['name' => 'images'])@endcomponent

                                        </div>
                                    </div>

                                    <br>
                                    <hr>
                                    <br>
                                    <div class="form-group ">
                                        <div class="col-md-12">
                                            <div class="panel-group" id="accordion" role="tablist"
                                                 aria-multiselectable="true">
                                                <?php $i = 0;?>
                                                @foreach($location->infos as $loc_info )
                                                    <?php $i++;?>
                                                    <div class="panel panel-default bx-shadow-none">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordion" href="#collapseOne{{$i}}"
                                                                   aria-expanded="false"
                                                                   aria-controls="collapseOne{{$i}}"
                                                                   class="collapsed">
                                                                    تیتر {{$i}}
                                                                </a>
                                                            </h4>
                                                        </div>


                                                        <div id="collapseOne{{$i}}" class="panel-collapse collapse"
                                                             role="tabpanel" aria-labelledby="headingOne"
                                                             aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">

                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label"> تیتر </label>
                                                                    <div class="col-sm-6">
                                                                        <input name="title[]" type="text"
                                                                               class="form-control"
                                                                               placeholder=" "
                                                                               value="{{ $loc_info->title }}"/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">
                                                                        توضیحات </label>
                                                                    <div class="col-sm-6">
                                                                            <textarea name="description[]"
                                                                                      class="form-control">{{ $loc_info->description }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                @endforeach

                                                @for($j=$i+1;$j<6;$j++)

                                                    <div class="panel panel-default bx-shadow-none">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordion" href="#collapseOne{{$j}}"
                                                                   aria-expanded="false"
                                                                   aria-controls="collapseOne{{$j}}"
                                                                   class="collapsed">
                                                                    تیتر {{$j}}
                                                                </a>
                                                            </h4>
                                                        </div>


                                                        <div id="collapseOne{{$j}}" class="panel-collapse collapse"
                                                             role="tabpanel" aria-labelledby="headingOne"
                                                             aria-expanded="false" style="height: 0px;">
                                                            <div class="panel-body">

                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label"> تیتر </label>
                                                                    <div class="col-sm-6">
                                                                        <input name="title[]" type="text"
                                                                               class="form-control"
                                                                               placeholder=" "
                                                                               value=""/>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">
                                                                        توضیحات </label>
                                                                    <div class="col-sm-6">
                                                                            <textarea name="description[]"
                                                                                      class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-9 m-t-15">
                                            <button name="submit" type="submit"
                                                    class="btn btn-primary waves-effect waves-light">ویرایش و تایید
                                            </button>


                                                @if($location->reports_count>0)
                                                    <a href="{{route('location_report_not_correct',['id'=>$location->id,'type'=>$type])}}"
                                                       class="btn btn-success waves-effect waves-light">گزارش تخلف صحیح نیست
                                                    </a>
                                                @endif

                                                <a href="{{route('admin_delete_location',['id'=>$location->id,'type'=>$type])}}"
                                                   name="cancel" type="reset"
                                                   class="btn btn-danger waves-effect m-l-5">حدف مکان </a>


                                                @if($location->is_confirm==0)
                                                    <a href="{{route('admin_confirm_location',['id'=>$location->id,'type'=>$type])}}"
                                                       name="cancel" type="reset"
                                                       class="btn btn-info waves-effect m-l-5">تایید مکان </a>
                                                @endif
                                            </div>
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


@section('footer')

    <script src="https://api.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js"></script>

    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiZWVzc3NuIiwiYSI6ImNqbmg5eXRsNDA4NWEzcnI3cnRqYm5lOG0ifQ.P4Qn6ea8eeeg-QuLPwZZcQ';
        mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.0/mapbox-gl-rtl-text.js');
        var lat = document.getElementById('lat');
        var long = document.getElementById('long');
        lat.value={{$location->lat}};
        long.value={{$location->longitude}};
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v9',
            center: [{{$location->lat}},{{$location->longitude}}],
            zoom: 6
        });

        var marker = new mapboxgl.Marker({
            draggable: true
        })
            .setLngLat([{{$location->lat}},{{$location->longitude}}])
            .addTo(map);

        function onDragEnd() {
            var lngLat = marker.getLngLat();
            lat.value=lngLat.lat;
            long.value=lngLat.lng;
        }

        marker.on('dragend', onDragEnd);

    </script>

    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js"
            type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
            type="text/javascript"></script>
    <script type="text/javascript">


        $("#file-1").fileinput({

            theme: 'fa',

            uploadUrl: "/imageUpload.php",

            allowedFileExtensions: ['jpg', 'png', 'gif'],

            overwriteInitial: false,

            maxFileSize: 2000,

            maxFilesNum: 10,

            slugCallback: function (filename) {

                return filename.replace('(', '_').replace(']', '_');

            }
            ,
            initialPreview: [@foreach($location->images as $image)
                "<img id='{{$image->id}}' onclick='image_delete(this.id)' width='200px' height='200px' src='{{url($image->image_path)}}' class='file-preview-frame krajee-default  kv-preview-thumb' alt='Desert' title='Desert'>",
                @endforeach]

        });

    </script>

    <script>

        //file upload script
        $('.dropify').dropify({
            messages: {
                'default': 'یک فایل را به اینجا بکشید و رها کنید یا اینجا کلیک کنید',
                'replace': 'برای جایگزینی یک فایل را بکشید و رها کنید یا اینجا کلیک کنید',
                'remove': 'پاک کردن',
                'error': 'خطایی رخ داده است.'
            },
            error: {
                'fileSize': 'اندازه فایل بزرگ است. (حداکثر 1 مگابایت)'
            }
        });
    </script>
    <script>


        function image_delete(id) {


            $.get('image_delete/' + id, function (data) {
                alert(data.message);
                $('#' + id).parent().parent().remove();
            }, 'json');
        }

        $("#edit_state").change(function () {

            var id = $(this).val();
            // $('#cities').show();

            $.get('getCity/' + id, function (data) {
                $city = $('select#edit_city option').remove();
                $.each(data, function (index, element) {

                    $('select#edit_city').append('<option value="' + element.id + '" >' + element.name + '</option>');

                });
            }, 'json');
        });
    </script>
@endsection


