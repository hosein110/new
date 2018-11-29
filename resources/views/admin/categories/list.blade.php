@extends('layouts.adminto.layout')

@section('header')
    @parent

    <title> دسته بندی ها </title>
    <link href="{{ asset('template/adminto/assets/plugins/custombox/dist/custombox.min.css' ) }}" rel="stylesheet">

@endsection
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">

                <div class="panel ">

                    <div class="panel-heading">
                        <div class="pull-left">
                               دسته بندی ها
                        </div>

                        <div class="pull-right">
                            <a href="#custom-modal" class="btn btn-success btn-md waves-effect waves-light m-b-30" data-animation="fadein" data-plugin="custommodal"
                               data-overlaySpeed="200" data-overlayColor="#36404a"><i class="md md-add"></i> افزودن دسته بندی </a>

                        </div>

                    </div>


                    <br> <br>
                </div>
                <div class="card-box">
                    <form role="search" method="get" class="">

                        <div class="col-md-4 col-xs-3">
                            <select class="form-control " name="target">
                                <option value=""> نوع دسته بندی </option>
                                <option value="0">مکان</option>
                                <option value="1">پست</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-xs-3">
                            <button class="btn btn-success btn-sm btn-block">جستجو</button>
                        </div>
                        <br>
                        <br>
                </form>
                <div class="panel-body">
                    @foreach($categories as $category)
                        <div class="col-md-3 col-xs-6">

                            <div class="thumbnail">
                                <div class=" box-profile">
                                        <img class="profile-user-img img-responsive  img-rounded"
                                             src="{{asset($category->image_path)}}"
                                             alt="Categories picture">

                                    <h5 class="profile-username text-center"> {{$category->title}}</h5>
                                    @if($category->type==1)
                                        <a href="{{ route('sub_categories',$category->id) }}" class="btn btn-facebook btn-xs btn-block">نمایش زیر دسته بندی ها</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{$categories->appends($_GET)->links()}}
        </div>
    </div>
    </div>

@stop
        @section('footer')
            <!-- Modal -->
                <div id="custom-modal" class="modal-demo">
                    <button type="button" class="close" onclick="Custombox.close();">
                        <span>&times;</span><span class="sr-only">بستن</span>
                    </button>
                    <h4 class="custom-modal-title">افزودن دسته بندی</h4>
                    <div class="custom-modal-text text-left">
                        <form method="POST" action="{{route('categories_create')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">نام</label>
                                <input type="text" class="form-control" name="title" placeholder="نام را وارد کنید">
                            </div>
                            <div class="form-group">
                                <select class="form-control " name="type">
                                    <option value=""> نوع دسته بندی </option>
                                    <option value="0">مکان</option>
                                    <option value="1">پست</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="image_path"> تصویر </label>
                                <input type="file" name="image_path" class="dropify"/>
                            </div>
                            <button type="submit" class="btn btn-default waves-effect waves-light">ذخیره کردن</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10">لغو</button>
                        </form>
                    </div>
                </div>


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
                <!-- Modal-Effect -->
                <script src="{{ asset('template/adminto/assets/plugins/custombox/dist/custombox.min.js' ) }}"></script>
                <script src="{{ asset('template/adminto/assets/plugins/custombox/dist/legacy.min.js' ) }}"></script>
                <!-- file uploads js -->

        @endsection
