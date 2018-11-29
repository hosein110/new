@extends('layouts.adminto.layout')

@section('header')
    <link rel="stylesheet" href="{{asset('template/adminto/assets/plugins/morris/morris.css')}}">
    <title>analyzes</title>
    @parent
@endsection
@section('content')

    <div class="card-box">
        <div class="row">
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30"> نمودار درصد سیستم عامل <span> <code id="total_browser"></code> </span> </h4>

                    <div id="morris-donut-os" style="height: 300px;">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30"> نمودار درصد مروررها<span><code id="total_os"></code> </span></h4>

                    <div id="morris-donut-browser" style="height: 300px;">
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30"> تعداد کل ورودی های سایت مورد نظر<span> <code id="total_reciver"></code> </span></h4>

                    <div class="text-center">
                        <ul class="list-inline chart-detail-list">
                            <li>
                                <h5 id="receive_title" style="color: #253cff;"><i class="fa fa-circle m-r-5"></i>     ورودی های سایت localhost </h5>
                            </li>
                        </ul>
                    </div>
                    <div id="receive_user" style="height: 300px;"></div>
                </div>
                <div class="form-group {{ $errors->has('state_id') ? ' has-error' : '' }}">
                    <label for="site" class="col-sm-3 control-label"> سایت </label>
                    <div class="col-sm-6">
                        <select id="site" name="site" class="form-control">
                            <option value="localhost">localhost</option>
                            <option value="google">google</option>
                            <option value="yahoo">yahoo</option>
                        </select>

                    </div>
                </div>
            </div>
        </div>
</div>

        @stop

@section('footer')
    @parent
    <script>
        $("#site").change(function () {
            var site = $(this).val();
            $('h5#receive_title').empty().append('ورودی های سایت '+site);
            $('div#receive_user').empty();
            $.get('analyzes/analyzes_summary/' + site, function (data) {
                !function ($) {
                    "use strict";
                    var Dashboard1 = function () {
                        this.$realData = []
                    };
                        Dashboard1.prototype.createLineChart = function (element, data, xkey, ykeys, labels, opacity, Pfillcolor, Pstockcolor, lineColors) {
                            Morris.Line({
                                element: element,
                                data: data,
                                xkey: xkey,
                                ykeys: ykeys,
                                labels: labels,
                                fillOpacity: opacity,
                                pointFillColors: Pfillcolor,
                                pointStrokeColors: Pstockcolor,
                                behaveLikeLine: true,
                                gridLineColor: '#eef0f2',
                                hideHover: 'auto',
                                resize: true, //defaulted to true
                                pointSize: 0,
                                lineColors: lineColors
                            });
                        },

                        Dashboard1.prototype.init = function () {

                            var $data = data.receive_user;
                            $('#total_reciver').html('تعداد کل  : '+ data.total_receive);
                            this.createLineChart('receive_user', $data, 'y', ['a'], ['ورودی های این روزسایت'], ['0.9'], ['#ffffff'], ['#999999'], ['#253cff']);
                        },
                        //init
                        $.Dashboard1 = new Dashboard1, $.Dashboard1.Constructor = Dashboard1
                }(window.jQuery),
//initializing
                    function ($) {
                        "use strict";
                        $.Dashboard1.init();
                    }(window.jQuery);

            });
        });
    </script>
    <script src="{{asset('template/adminto/assets/plugins/morris/morris.min.js')}}"></script>
    <script src="{{asset('template/adminto/assets/plugins/raphael/raphael-min.js')}}"></script>
    <!-- Dashboard init -->
    <script src="{{asset('template/adminto/assets/pages/jquery.analyzes.js')}}"></script>


@endsection

