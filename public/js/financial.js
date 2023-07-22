financial = function (container, type, title, source = 'Financial Water Services', ytitle, legend = false, rotation = - 45, tooltip, name, categories, data) {
    Highcharts.setOptions({
        colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
    });

    if (type === 'pie') {
        series = data;
    } else {
        series = {name: title, data: data};
    }

    Highcharts.chart(container, {
        chart: {
            type: type
        },
        title: {
            text: ytitle
        },
        subtitle: {
            text: source
        },
        xAxis: {
            type: 'category',
            categories: categories,
            crosshair: true,
            labels: {
                rotation: rotation,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: title
            }
        },
        legend: {
            enabled: true
        },
        tooltip: {
            pointFormat: '{point.key} <b>{point.y:,.0f}</b>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.0,
                borderWidth: 0,
                colorByPoint: true,
                dataLabels: {
                    enabled: true,
                    crop: false,
                    overflow: 'none',
                    formatter: function () {
                        return Highcharts.numberFormat(this.y, 0);
                    }
                }
            },
            bar: {
                pointPadding: 0.2,
                borderWidth: 0,
                colorByPoint: true,
                dataLabels: {
                    enabled: true,
                    crop: false,
                    overflow: 'none',
                    formatter: function () {
                        return Highcharts.numberFormat(this.y, 0);
                    }
                }
            },
            line: {

                colorByPoint: true,
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return Highcharts.numberFormat(this.y, 0);
                    }
                }
            },
            area: {

                colorByPoint: true,
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return Highcharts.numberFormat(this.y, 0);
                    }
                }
            },
            areaspline: {
                pointPadding: 0.2,
                borderWidth: 0,
                colorByPoint: true,
                dataLabels: {
                    enabled: true,
                    crop: false,
                    overflow: 'none',
                    formatter: function () {
                        return Highcharts.numberFormat(this.y, 0);
                    }
                }
            },
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                //showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                        width: '100px'
                    }
                }

            }
        },
        series: [{
                name: name,
                data: data,
                dataLabels: {
                    enabled: false,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.0f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
    }, );


};

