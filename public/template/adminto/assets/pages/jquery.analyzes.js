$.ajax({

    type: "GET",
    url: "analyzes/analyzes_summary/localhost",
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
            Dashboard1.prototype.createDonutChart = function (element, data, colors) {
                Morris.Donut({
                    element: element,
                    data: data,
                    resize: true, //defaulted to true
                    colors: colors
                });
            },
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
                    $('#total_reciver').html('تعداد کل : '+ data.total_receive);
                    this.createLineChart('receive_user', $data, 'y', ['a'], ['ورودی های این روز'], ['0.9'], ['#ffffff'], ['#999999'], ['#253cff']);

                    var $morris_donut_os = data.os;

                    var $morris_donut_browser = data.browser;
                    //
                    $('#total_os').html('تعداد کل : '+ data.total);
                    $('#total_browser').html('تعداد کل : '+ data.total);
                    this.createDonutChart('morris-donut-os', $morris_donut_os, ['#14bc08', '#ff212e', "#bcaf27"]);
                    this.createDonutChart('morris-donut-browser', $morris_donut_browser, ['#14bc08', '#ff212e', "#bcaf27"]);
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

