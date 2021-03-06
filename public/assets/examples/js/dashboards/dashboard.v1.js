$(function () {
    !function () {
        if ("function" == typeof $.fn.sparkline) {
            var a = function (a, e, i) {
                (i = i || {}).type = "bar", i.barColor = "#ffffff", i.barSpacing = 2, i.barWidth = 5, $(a).sparkline(e, i)
            };
            a("#dash1-sparkline-1", [4, 3, 5, 2, 1]), a("#dash1-sparkline-2", [1, 2, 3, 5, 4]), a("#dash1-sparkline-3", [2, 4, 3, 4, 3]), a("#dash1-sparkline-4", [5, 4, 3, 5, 2])
        }
    }(), $.plot($("#dash1-flotchart-1"), [{
        data: [[1, 3.6], [2, 3.5], [3, 6], [4, 4], [5, 4.3], [6, 3.5], [7, 3.6]],
        color: $.colors.primary,
        lines: {show: !0, lineWidth: 6},
        curvedLines: {apply: !0}
    }, {
        data: [[1, 3.6], [2, 3.5], [3, 6], [4, 4], [5, 4.3], [6, 3.5], [7, 3.6]],
        color: $.colors.primary,
        points: {show: !0}
    }], {
        series: {curvedLines: {active: !0}},
        xaxis: {
            show: !0,
            font: {
                size: 12,
                lineHeight: 10,
                style: "normal",
                weight: "100",
                family: "lato",
                variant: "small-caps",
                color: "#a2a0a0"
            }
        },
        yaxis: {
            show: !0,
            font: {
                size: 12,
                lineHeight: 10,
                style: "normal",
                weight: "100",
                family: "lato",
                variant: "small-caps",
                color: "#a2a0a0"
            }
        },
        grid: {color: "#a2a0a0", hoverable: !0, margin: 8, labelMargin: 8, borderWidth: 0, backgroundColor: "#fff"},
        tooltip: !0,
        tooltipOpts: {content: "X: %x.0, Y: %y.2", defaultTheme: !1, shifts: {x: 0, y: -40}},
        legend: {show: !1}
    }), $.plot("#dash1-flot-barchart", [{
        label: "Users",
        data: [[1, 200], [2, 400], [3, 500], [4, 700], [5, 600], [6, 400], [7, 500], [8, 400], [9, 320], [10, 380], [11, 500], [12, 700]],
        bars: {show: !0, fill: 1, fillColor: $.colors.primary, align: "center", barWidth: .4}
    }], {
        series: {bars: {show: !0}},
        xaxis: {
            font: {
                size: 12,
                lineHeight: 10,
                style: "normal",
                weight: "100",
                family: "lato",
                variant: "small-caps",
                color: "#a2a0a0"
            }
        },
        yaxis: {
            max: 800,
            font: {
                size: 12,
                lineHeight: 10,
                style: "normal",
                weight: "100",
                family: "lato",
                variant: "small-caps",
                color: "#a2a0a0"
            }
        },
        legend: {show: !1},
        grid: {color: "#fff", labelMargin: 16, hoverable: !0},
        colors: ["#3f51b5"],
        tooltip: {show: !0, content: "<div><span>X: %x, Y: %y</span></div>", defaultTheme: !1}
    }), echarts.init(document.getElementById("dash1-echart-1")).setOption({
        tooltip: {trigger: "axis"},
        legend: {data: ["Max", "Min"]},
        calculable: !0,
        xAxis: [{type: "category", boundaryGap: !1, data: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]}],
        yAxis: [{type: "value", axisLabel: {formatter: "{value} ??C"}}],
        series: [{
            name: "Max",
            type: "line",
            color: ["#5C6BC0"],
            data: [9, 9, 13, 11, 10, 11, 8],
            markPoint: {data: [{type: "max", name: "Max"}, {type: "min", name: "Min"}]},
            markLine: {data: [{type: "average", name: "Average"}]}
        }, {
            name: "Min",
            type: "line",
            color: ["#009688"],
            data: [1, -3, 2, 5, 3, 4, 0],
            markPoint: {data: [{name: "Min of Week", value: -3, xAxis: 1, yAxis: -1.5}]},
            markLine: {data: [{type: "average", name: "Average"}]}
        }]
    })
});