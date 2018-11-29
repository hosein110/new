$.ajax({

    type: "GET",
    url: "home/summary",
    // data: '{"id":"12"}',
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function (data) {

        //  alert(data.count_happy_memories);


        !function ($) {
            "use strict";


            var Dashboard1 = function () {
                this.$realData = []
            };

            //creates Bar chart
            Dashboard1.prototype.createBarChart = function (element, data, xkey, ykeys, labels, lineColors) {
                Morris.Bar({
                    element: element,
                    data: data,
                    xkey: xkey,
                    ykeys: ykeys,
                    labels: labels,
                    hideHover: 'auto',
                    resize: true, //defaulted to true
                    gridLineColor: '#eeeeee',
                    barSizeRatio: 0.2,
                    barColors: lineColors
                });
            },


                //creates line chart
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


                //creates Donut chart
                Dashboard1.prototype.createDonutChart = function (element, data, colors) {
                    Morris.Donut({
                        element: element,
                        data: data,
                        resize: true, //defaulted to true
                        colors: colors
                    });
                },


                Dashboard1.prototype.init = function () {

                    // //creating bar chart
                    // var $barDataYear =data.count_user_year;
                    // this.createBarChart('morris_bar_user_year', $barDataYear, 'date', ['count_user'], ['آمار'], ['#188ae2']);
                    //
                    //
                    // var $barDataMonth = data.count_user_month;
                    // this.createBarChart('morris_bar_user_month', $barDataMonth, 'date', ['count_user'], ['آمار'], ['#188ae2']);
                    //
                    //
                    // var $barDataDay = data.count_user_day;
                    //
                    // this.createBarChart('morris_bar_user_day', $barDataDay, 'date', ['count_user'], ['آمار'], ['#188ae2']);
                    //
                    //
                    //
                    //
                    //
                    //
                    // var $barDataYear =data.count_memory_year;
                    // this.createBarChart('morris_bar_memory_year', $barDataYear, 'date', ['count_memory'], ['آمار'], ['#e24abc']);
                    //
                    //
                    // var $barDataMonth = data.count_memory_month;
                    // this.createBarChart('morris_bar_memory_month', $barDataMonth, 'date', ['count_memory'], ['آمار'], ['#e24abc']);
                    //
                    //
                    // var $barDataDay = data.count_memory_day;
                    //
                    // this.createBarChart('morris_bar_memory_day', $barDataDay, 'date', ['count_memory'], ['آمار'], ['#e24abc']);
                    //
                    //


                    //create line chart
                    var $data = [
                        {y: '1389', a: 111, b: 0, c: 54},
                        {y: '1390', a: 75, b: 50, c: 34},
                        {y: '1391', a: 30, b: 80, c: 42},
                        {y: '1392', a: 50, b: 50, c: 14},
                        {y: '1393', a: 75, b: 10, c: 40},
                        {y: '1394', a: 50, b: 40, c: 4},
                        {y: '1395', a: 75, b: 50, c: 4},
                        {y: '1396', a: 100, b: 70, c: 46}
                    ];
                    this.createLineChart('users_register_status', $data, 'y', ['a', 'b', 'c'], ['نصب کرده و ثبت نام نکرده', 'ثبت نام کرده', 'حذف کرده'], ['0.9'], ['#ffffff'], ['#999999'], ['#ff8acc', '#2ebc6a', '#ff0000']);


                    var $data1 = data.posts_per_user;

                    this.createBarChart('post_create', $data1, 'date', ['avrage_post'], ['پستهای ایجاد شده به ازای هر کاربر '], ['0.9'], ['#ffffff'], ['#999999'], ['#ff8acc']);


                    var $data = [
                        {y: '1389', a: 111},
                        {y: '1390', a: 75},
                        {y: '1391', a: 30},
                        {y: '1392', a: 50},
                        {y: '1393', a: 75},
                        {y: '1394', a: 50},
                        {y: '1395', a: 75},
                        {y: '1396', a: 100}
                    ];
                    this.createLineChart('location_create', $data, 'y', ['a'], ['مکانهای ایجاد شده'], ['0.9'], ['#ffffff'], ['#999999'], ['#188ae2']);


                    var $data = [
                        {y: '1389', a: 111},
                        {y: '1390', a: 75},
                        {y: '1391', a: 30},
                        {y: '1392', a: 50},
                        {y: '1393', a: 75},
                        {y: '1394', a: 50},
                        {y: '1395', a: 75},
                        {y: '1396', a: 100}
                    ];
                    this.createLineChart('users_uses_app', $data, 'y', ['a'], [' کاربران استفاده کننده از اپلیکیشن'], ['0.9'], ['#ffffff'], ['#999999'], ['#253cff']);


                    var $data = [
                        {y: '1389', a: 111},
                        {y: '1390', a: 75},
                        {y: '1391', a: 30},
                        {y: '1392', a: 50},
                        {y: '1393', a: 75},
                        {y: '1394', a: 50},
                        {y: '1395', a: 75},
                        {y: '1396', a: 100}
                    ];
                    this.createLineChart('users_uses_Advice', $data, 'y', ['a'], [' کاربران استفاده کننده از مشاوره'], ['0.9'], ['#ffffff'], ['#999999'], ['#ff4925']);



                },
                //init
                $.Dashboard1 = new Dashboard1, $.Dashboard1.Constructor = Dashboard1
        }(window.jQuery),

//initializing
            function ($) {
                "use strict";
                $.Dashboard1.init();
            }(window.jQuery);
    },
    error: function (data) {
        //  alert("fail");

    }
});

