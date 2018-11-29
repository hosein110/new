

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="یک قالب مدیریتی حرفه ای با امکانات کامل">
    <meta name="author" content="ای تمز">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App title -->
    <title>ادمین</title>

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{asset('template/adminto/assets/plugins/morris/morris.css')}}">

    <!-- App css -->
    <link href="{{asset('template/adminto/assets/css/bootstrap-rtl.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('template/adminto/assets/css/core.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('template/adminto/assets/css/components.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('template/adminto/assets/css/icons.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('template/adminto/assets/css/pages.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('template/adminto/assets/css/menu.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('template/adminto/assets/css/responsive.css')}}" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shiv and Respond.js')}} IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js')}}/1.3.0/respond.min.js"></script>
    <![endif]-->


    <![endif]-->

    <script src="assets/js/modernizr.min.js"></script>

</head>
<body>

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="text-center">
        <a href="index.html" class="logo"><span>ادمین<span> MarcoPolo </span></span></a>
        <h5 class="text-muted m-t-0 font-600"> </h5>
    </div>
    <div class="m-t-40 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0">ورود</h4>
        </div>

        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="  email">

                        @component('input_error',['name' => 'email'])@endcomponent

                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control" name="password" placeholder="رمز عبور">

                        @component('input_error',['name' => 'password'])@endcomponent

                    </div>
                </div>



                <div class="form-group">

                    <div class="form-group text-center m-t-30">
                        <div class="col-xs-12">
                            <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">ورود</button>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <a href="{{ url('password/reset') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i> رمز خود را فراموش کرده اید؟</a>
                    </div>

                </div>
            </form>
        </div>




    </div>
    <!-- end card-box-->



</div>


<!-- jQuery  -->


</body>
</html>


