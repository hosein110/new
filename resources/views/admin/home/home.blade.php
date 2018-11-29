@extends('layouts.adminto.layout')

@section('header')
    <link rel="stylesheet" href="{{asset('template/adminto/assets/plugins/morris/morris.css')}}">
    <title>داشبورد</title>
    @parent
@endsection
@section('content')



    <div class="card-box">
        <div class="row">

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>

                    </div>

                    <h4 class="header-title m-t-0 m-b-30">کاربران امسال</h4>

                    <div class="widget-chart-1">


                        <div class="widget-detail">

                            <h2 class="p-t-10 m-b-0"> {{$summary['last_year_user_count']}}</h2>
                            <p class="text-muted"> نفر</p>
                        </div>

                        <div class="progress progress-bar-success-alt progress-sm m-b-0">

                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>

                    </div>

                    <h4 class="header-title m-t-0 m-b-30"> کاربران این ماه</h4>

                    <div class="widget-chart-1">

                        <div class="widget-detail">

                            <h2 class="p-t-10 m-b-0"> {{$summary['last_month_user_count']}} </h2>
                            <p class="text-muted"> نفر </p>
                        </div>

                        <div class="progress progress-bar-success-alt progress-sm m-b-0">

                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>

                    </div>

                    <h4 class="header-title m-t-0 m-b-30">کاربران دیروز </h4>

                    <div class="widget-chart-1">
                        {{--<span class="badge badge-success pull-left m-t-20">32% <i class="zmdi zmdi-trending-up"></i> </span>--}}


                        <div class="widget-detail">

                            <h2 class="p-t-10 m-b-0"> {{$summary['yesterday_user_count']}} </h2>
                            <p class="text-muted"> نفر</p>
                        </div>

                        <div class="progress progress-bar-success-alt progress-sm m-b-0">

                        </div>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-3 col-md-6">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>

                    </div>

                    <h4 class="header-title m-t-0 m-b-30"> کاربران امروز </h4>

                    <div class="widget-chart-1">
                        {{--<span class="badge badge-success pull-left m-t-20">32% <i class="zmdi zmdi-trending-up"></i> </span>--}}


                        <div class="widget-detail">

                            <h2 class="p-t-10 m-b-0"> {{$summary['today_user_count']}}</h2>
                            <p class="text-muted"> نفر </p>
                        </div>

                        <div class="progress progress-bar-success-alt progress-sm m-b-0">

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->


        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">گزینه 1</a></li>
                            <li><a href="#">گزینه 2</a></li>
                            <li><a href="#">گزینه 3</a></li>
                            <li class="divider"></li>
                            <li><a href="#">نمودار خطی</a></li>
                        </ul>
                    </div>

                    <h4 class="header-title m-t-0 m-b-30">   نمودار وضعیت ثبت نام کاربران    </h4>

                    <div class="text-center">
                        <ul class="list-inline chart-detail-list">
                            <li>
                                <h5 style="color: #ff8acc;"><i class="fa fa-circle m-r-5"></i>  نصب کرده و ثبت نام نکرده</h5>
                            </li>
                            <li>
                                <h5 style="color: #2ebc6a;"><i class="fa fa-circle m-r-5"></i> ثبت نام کرده  </h5>
                            </li>
                            <li>
                                <h5 style="color: #ff0000;"><i class="fa fa-circle m-r-5"></i>حذف کرده  </h5>
                            </li>
                        </ul>
                    </div>
                    <div id="users_register_status" style="height: 300px;"></div>

                </div>
            </div><!-- end col-->
            <div class="col-md-12">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">گزینه 1</a></li>
                            <li><a href="#">گزینه 2</a></li>
                            <li><a href="#">گزینه 3</a></li>
                            <li class="divider"></li>
                            <li><a href="#">نمودار خطی</a></li>
                        </ul>
                    </div>

                    <h4 class="header-title m-t-0 m-b-30">   نمودار وضعیت مکانهای ایجاد شده     </h4>

                    <div class="text-center">
                        <ul class="list-inline chart-detail-list">

                            <li>
                                <h5 style="color: #5b69bc;"><i class="fa fa-circle m-r-5"></i>مکانهای ایجاد شده  </h5>
                            </li>

                        </ul>
                    </div>
                    <div id="location_create" style="height: 300px;"></div>

                </div>
            </div><!-- end col-->
            <div class="col-md-12">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">گزینه 1</a></li>
                            <li><a href="#">گزینه 2</a></li>
                            <li><a href="#">گزینه 3</a></li>
                            <li class="divider"></li>
                            <li><a href="#">نمودار خطی</a></li>
                        </ul>
                    </div>

                    <h4 class="header-title m-t-0 m-b-30">   نمودار وضعیت  پستهای ایجاد شده  به ازای هر کاربر   </h4>

                    <div class="text-center">
                        <ul class="list-inline chart-detail-list">



                        </ul>
                    </div>
                    <div id="post_create" style="height: 300px;"></div>

                </div>
            </div><!-- end col-->



            <div class="col-md-12">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">گزینه 1</a></li>
                            <li><a href="#">گزینه 2</a></li>
                            <li><a href="#">گزینه 3</a></li>
                            <li class="divider"></li>
                            <li><a href="#">نمودار خطی</a></li>
                        </ul>
                    </div>

                    <h4 class="header-title m-t-0 m-b-30">   نمودار کاربران استفاده کننده از اپلیکیشن     </h4>

                    <div class="text-center">
                        <ul class="list-inline chart-detail-list">
                            <li>
                                <h5 style="color: #253cff;"><i class="fa fa-circle m-r-5"></i>     کاربران استفاده کننده از اپلیکیشن </h5>
                            </li>


                        </ul>
                    </div>
                    <div id="users_uses_app" style="height: 300px;"></div>

                </div>
            </div><!-- end col-->
            <div class="col-md-12">
                <div class="card-box">
                    <div class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle card-drop" data-toggle="dropdown"
                           aria-expanded="false">
                            <i class="zmdi zmdi-more-vert"></i>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">گزینه 1</a></li>
                            <li><a href="#">گزینه 2</a></li>
                            <li><a href="#">گزینه 3</a></li>
                            <li class="divider"></li>
                            <li><a href="#">نمودار خطی</a></li>
                        </ul>
                    </div>

                    <h4 class="header-title m-t-0 m-b-30">   نمودار کاربران استفاده کننده از مشاوره     </h4>

                    <div class="text-center">
                        <ul class="list-inline chart-detail-list">
                            <li>
                                <h5 style="color: #ff4925;"><i class="fa fa-circle m-r-5"></i>     کاربران استفاده کننده از مشاوره </h5>
                            </li>


                        </ul>
                    </div>
                    <div id="users_uses_Advice" style="height: 300px;"></div>

                </div>
            </div><!-- end col-->



        </div>
    </div>




@stop

@section('footer')
    @parent
    <script src="{{asset('template/adminto/assets/plugins/morris/morris.min.js')}}"></script>
    <script src="{{asset('template/adminto/assets/plugins/raphael/raphael-min.js')}}"></script>
    <!-- Dashboard init -->
    <script src="{{asset('template/adminto/assets/pages/jquery.dashboard.js')}}"></script>

@endsection

