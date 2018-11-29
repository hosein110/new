<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>

    @section('header')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="یک قالب مدیریتی حرفه ای با امکانات کامل">
        <meta name="author" content="ای تمز">
        <link rel="shortcut icon" href="{{asset('template/adminto/assets/images/favicon.ico')}}">
        <!--Morris Chart CSS -->

        <!-- App css -->
        <link href="{{asset('template/adminto/assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/adminto/assets/css/core.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/adminto/assets/css/components.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/adminto/assets/css/icons.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/adminto/assets/css/pages.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/adminto/assets/css/menu.css')}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('template/adminto/assets/css/responsive.css')}}" rel="stylesheet" type="text/css"/>

        <!-- form Uploads -->
        <link href="{{ asset('template/adminto/assets/plugins/fileuploads/css/dropify.min.css') }}" rel="stylesheet"
              type="text/css"/>
        <!-- Plugins css-->
        <link href="{{ asset('template/adminto/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet"
              type="text/css"/>
        <link href="{{ asset('template/adminto/assets/plugins/select2/dist/css/select2.css') }}" rel="stylesheet"
              type="text/css">
        <link href="{{ asset('template/adminto/assets/plugins/select2/dist/css/select2-bootstrap.css') }}"
              rel="stylesheet" type="text/css">

        <!-- HTML5 Shiv and Respond.js')}} IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js')}}/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="{{asset('template/adminto/assets/js/modernizr.min.js')}}"></script>
        <link href="{{asset('css/sweetalert2.min.css')}}" rel="stylesheet">
        {{--<link href="{{asset('css/all.css')}}" rel="stylesheet">--}}




    @show

</head>


<body class="fixed-left">

<?php



KKK();
?>



<!-- Begin page -->
<div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <a href="index.html" class="logo"><span>مدیریت<span> پنل </span></span><i class="zmdi zmdi-layers"></i></a>
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">

                <!-- Page title -->
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <button class="button-menu-mobile open-left">
                            <i class="zmdi zmdi-menu"></i>
                        </button>
                    </li>
                    <li>
                        <h4 class="page-title">پیشخوان</h4>
                    </li>
                </ul>

                <!-- Right(Notification and Searchbox -->
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <!-- Notification -->
                        <div class="notification-box">
                            <ul class="list-inline m-b-0">
                                <li>
                                    <a href="javascript:void(0);" class="right-bar-toggle">
                                        <i class="zmdi zmdi-notifications-none"></i>
                                    </a>
                                    <div class="noti-dot">
                                        <span class="dot"></span>
                                        <span class="pulse"></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- End Notification bar -->
                    </li>

                </ul>

            </div><!-- end container -->
        </div><!-- end navbar -->
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">


            <!--- Sidemenu -->
        @include('layouts.adminto.sidebar_menu')
        <!-- Sidebar -->
            <div class="clearfix"></div>

        </div>

    </div>
    <!-- Left Sidebar End -->


    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->

        <div class="content">
            <div class="container">
                    @yield('content')
            </div>
        </div>
        @include('layouts.adminto.footer')

    </div>


    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->


    <!-- Right Sidebar -->
    <div class="side-bar right-bar">
        <a href="javascript:void(0);" class="right-bar-toggle">
            <i class="zmdi zmdi-close-circle-o"></i>
        </a>
        <h4 class="">اطلاعیه ها</h4>
        <div class="notification-list nicescroll">
            <ul class="list-group list-no-border user-list">
                <li class="list-group-item">
                    <a href="#" class="user-list-item">
                        <div class="avatar">
                            <img src="{{asset('template/adminto/assets/images/users/avatar-2.jpg')}}" alt="">
                        </div>
                        <div class="user-desc">
                            <span class="name">وحید حسنی</span>
                            <span class="desc">تنظیمات تازه در دسترس هستند</span>
                            <span class="time">2 ساعت پیش</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="user-list-item">
                        <div class="icon bg-info">
                            <i class="zmdi zmdi-account"></i>
                        </div>
                        <div class="user-desc">
                            <span class="name">ثبت نام تازه</span>
                            <span class="desc">تنظیمات تازه در دسترس هستند</span>
                            <span class="time">5 ساعت پیش</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="user-list-item">
                        <div class="icon bg-pink">
                            <i class="zmdi zmdi-comment"></i>
                        </div>
                        <div class="user-desc">
                            <span class="name">یک پیام تازه دریافت شد</span>
                            <span class="desc">تنظیمات تازه در دسترس هستند</span>
                            <span class="time">1 روز پیش</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item active">
                    <a href="#" class="user-list-item">
                        <div class="avatar">
                            <img src="{{asset('template/adminto/assets/images/users/avatar-3.jpg')}}" alt="">
                        </div>
                        <div class="user-desc">
                            <span class="name">ای تمز</span>
                            <span class="desc">تنظیمات تازه در دسترس هستند</span>
                            <span class="time">2 روز پیش</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item active">
                    <a href="#" class="user-list-item">
                        <div class="icon bg-warning">
                            <i class="zmdi zmdi-settings"></i>
                        </div>
                        <div class="user-desc">
                            <span class="name">تنظیمات</span>
                            <span class="desc">تنظیمات تازه در دسترس هستند</span>
                            <span class="time">1 روز پیش</span>
                        </div>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <!-- /Right-bar -->

</div>
<!-- END wrapper -->


<script>
    var resizefunc = [];
</script>
@yield('footer')
    <!-- jQuery  -->
    {{--<script src="{{asset('template/adminto/assets/js/jquery.min.js')}}"></script>--}}
    <script src="https://cdn.rtlcss.com/bootstrap/v4.0.0/js/bootstrap.min.js"></script>
    <script src="{{asset('template/adminto/assets/js/detect.js')}}"></script>
    <script src="{{asset('template/adminto/assets/js/detect.js')}}"></script>
    <script src="{{asset('template/adminto/assets/js/fastclick.js')}}"></script>
    <script src="{{asset('template/adminto/assets/js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('template/adminto/assets/js/waves.js')}}"></script>
    <script src="{{asset('template/adminto/assets/js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('template/adminto/assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('template/adminto/assets/js/jquery.scrollTo.min.js')}}"></script>
    <!-- KNOB JS -->
    <script src="{{asset('template/adminto/assets/plugins/jquery-knob/jquery.knob.js')}}"></script>
    <!--Morris Chart-->
<!-- form Uploads -->
<link href="{{ asset('template/adminto/assets/plugins/fileuploads/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{asset('template/adminto/assets/js/jquery.core.js')}}"></script>
    <script src="{{asset('template/adminto/assets/js/jquery.app.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{asset('js/all.js')}}"></script>
    <!-- file uploads js -->
    <!-- plugin script -->
    <script type="text/javascript"
            src="{{ asset('template/adminto/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('template/adminto/assets/plugins/select2/dist/js/select2.min.js') }}"
            type="text/javascript"></script>


@include('flash')
</body>
</html>