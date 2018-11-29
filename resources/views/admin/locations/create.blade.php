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

    <title> افزودن مکان جدید</title>
    @parent
@endsection
@section('content')



    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel   panel-default">
                    <div class="panel-heading">
                        <h4 class="header-title m-t-0 m-b-30">افزودن مکان جدید‌</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="POST" class="form-horizontal group-border-dashed"
                                      action="{{route('store_location')}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <input name="longitude" id="lat" type="hidden">
                                    <input name="lat" id="long" type="hidden">
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label">نام مکان</label>
                                        <div class="col-sm-6">
                                            <input name="name" type="text" class="form-control"
                                                  value="{{ old('name') }}" placeholder=" نام مکان جدید را وارد کنید"/>
                                            @component('input_error',['name' => 'name'])@endcomponent

                                        </div>

                                    </div>


                                    <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label"> دسته بندی </label>
                                        <div class="col-sm-6">
                                            <select name="category_id" class="form-control has-error"  >
                                                <option value=""></option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">   {{$category->title}}</option>
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
                                                       placeholder="شماره تماس را وارد کنید">
                                                <span class="input-group-addon"><i class="zmdi zmdi-phone"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group {{ $errors->has('state_id') ? ' has-error' : '' }}">
                                        <label class="col-sm-3 control-label"> استان </label>
                                        <div class="col-sm-6">
                                            <select id="state" name="state_id" class="form-control"
                                                    data-placeholder="با کلیک کردن روی این قسمت استان مورد نظر را انتخاب کنید...">
                                                <option value=""></option>
                                                @foreach($state as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @component('input_error',['name' => 'state_id'])@endcomponent

                                        </div>
                                    </div>
                                    <div class="form-group  {{ $errors->has('city_id') ? ' has-error' : '' }}" id="cities" style="display: none">
                                        <label class="col-sm-3 control-label"> شهر </label>
                                        <div class="col-sm-6">
                                            <select id="city" name="city_id" class="form-control"
                                                    data-placeholder="با کلیک کردن روی این قسمت شهر مورد نظر را انتخاب کنید...">
                                                <option value=""></option>
                                                @foreach($city as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @component('input_error',['name' => 'city_id'])@endcomponent

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> هزینه : </label>
                                        <div class="col-sm-6">
                                            <input name="price" type="text" class="form-control"
                                                   placeholder="   "/>
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
                                                <label for="environment[]" class="col-md-6 control-label"><span data-labelfor="environment{{$environment->id}}">{{$environment->title}}</span></label>

                                                <input name="environment[]" type="checkbox" id="environment{{$environment->id}}" value="{{$environment->id}}"
                                                       class="checkbox-info">
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
                                                <label for="transfer[]" class="col-md-6 control-label"><span data-labelfor="environment{{$transfer->id}}"> {{$transfer->title}} </span></label>

                                                <input name="transfer[]" type="checkbox" id="environment{{$transfer->id}}" class="checkbox-info" value="{{$transfer->id}}">
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


                                                @for($i=1;$i<6;$i++)
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
                                                                               placeholder=" "/>
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
                                                    class="btn btn-primary waves-effect waves-light">افزودن
                                            </button>
                                            <a href="#" name="cancel" type="reset"
                                               class="btn btn-default waves-effect m-l-5">لغو</a>
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

        });

    </script>


    <script>


        $("#state").change(function () {

            var id = $(this).val();
            $('#cities').show();

            $.get('getCity/' + id, function (data) {
                $city = $('select#city option').remove();
                $.each(data, function (index, element) {

                    $('select#city').append('<option value="' + element.id + '" >' + element.name + '</option>');

                });
            }, 'json');
        });
    </script>




    <script src="https://api.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js"></script>

    <script>



        $(document).ready(function() {



            $("[data-labelfor]").click(function() {
                $('#' + $(this).attr("data-labelfor")).prop('checked',
                    function(i, oldVal) { return !oldVal; });
            });

        });
        mapboxgl.accessToken = 'pk.eyJ1IjoiZWVzc3NuIiwiYSI6ImNqbmg5eXRsNDA4NWEzcnI3cnRqYm5lOG0ifQ.P4Qn6ea8eeeg-QuLPwZZcQ';
        mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.0/mapbox-gl-rtl-text.js');
        var lat = document.getElementById('lat');
        var long = document.getElementById('long');
        lat.value=51.399881866805686;
        long.value=34.85766113502646;
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v9',
            center: [51.399881866805686, 34.85766113502646],
            zoom: 6
        });

        var marker = new mapboxgl.Marker({
            draggable: true
        })


            .setLngLat([51.38835193356465,35.77144401974623])
            .addTo(map);

        function onDragEnd() {
            var lngLat = marker.getLngLat();
            // coordinates.style.display = 'block';
            // coordinates.innerHTML = 'Longitude: ' + lngLat.lng + '<br />Latitude: ' + lngLat.lat;

            lat.value=lngLat.lat;
            long.value=lngLat.lng;
        }

        marker.on('dragend', onDragEnd);

    </script>



    @parent
    <script src="{{asset('template/adminto/assets/plugins/morris/morris.min.js')}}"></script>
    <script src="{{asset('template/adminto/assets/plugins/raphael/raphael-min.js')}}"></script>
    <!-- Dashboard init -->
    <script src="{{asset('template/adminto/assets/pages/jquery.dashboard.js')}}"></script>

@endsection
