@extends('layouts.app')

@section('content')
<div class="content d-flex flex-column flex-column-fluid pt-0" id="kt_content">
    <div class="container mt-7">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header justify-content-center">
                        <div class="card-title">
                            <h2>Car In Progress</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="car_ongoing"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header justify-content-center">
                        <div class="card-title">
                            <h2>Car Complete</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="car_complete"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header justify-content-center">
                        <div class="card-title">
                            <h2>Motorbike In Progress</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="motor_ongoing"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-header justify-content-center">
                        <div class="card-title">
                            <h2>Motorbike Complete</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="motor_complete"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Total Completed Repairs in Last Week</h3>
                    </div>
                    <div class="card-body">
                        <div id="bar_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Repair Status</h3>
                    </div>
                    <div class="card-body">
                        <div id="pie_chart" class="mh-200px"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Total Revenue in Last Month</h3>
                    </div>
                    <div class="card-body">
                        <div id="revenue_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Revenue by Division in Last Month</h3>
                        <div class="card-toolbar">
                            <select name="division" id="division" class="form-control">
                                <option value="car">Car</option>
                                <option value="motorbike" selected>Motorbike</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="area_chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Mechanic Efficiency</h3>
                    </div>
                    <div class="card-body">
                        <Label class="form-label fs-6 fw-bold mb-3">Mechanic Name</Label>
                        <select name="mechanic" id="mechanic" class="form-select form-select-solid" data-control="select2" data-placeholder="Select an option">
                            @foreach ($mechanics as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <div id="mechanic_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Average Repair Time (hour)</h3>
                    </div>
                    <div class="card-body">
                        <div id="average_chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Spare Parts Stock</h3>
                </div>
                <div class="card-body">
                    <table id="table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>Name</th>
                                <th>Type</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold fs-7 text-gray-600">
                            @foreach ($parts as $item)
                            <tr class="text-start">
                                <td>{{$item->name}}</td>
                                <td>{{$item->type}}</td>
                                <td>{{$item->stock}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Script for gauge chart status repairs and pie chart status repairs --}}
<script>
    var options_status = {
        chart: {
            height: 200,
            type: "radialBar",
        },
        series: [],
        colors: ["#20E647"],
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                track: {
                    background: '#333',
                    startAngle: -135,
                    endAngle: 135,
                },
                dataLabels: {
                    name: {
                        show: false,
                    },
                    value: {
                        fontSize: "30px",
                        show: true,
                        formatter: function (val) {
                            return val
                        }
                    }
                }
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: "dark",
                type: "horizontal",
                gradientToColors: ["#87D4F9"],
                stops: [0, 100]
            }
        },
        stroke: {
            lineCap: "butt"
        },
        noData: {
            text: 'Loading...'
        }
    };

    var options_pie = {
        series: [0,0],
        chart: {
            height: 232,
            type: 'pie',
        },
        noData: {
            text: 'Loading...'
        },
        labels: ['Car In Progress', 'Car Complete', 'Motorbike In Progress', 'Motorbike Complete'],
        responsive: [{
            breakpoint: 880,
            options: {
                chart: {
                    height: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart_pie = new ApexCharts(document.querySelector("#pie_chart"), options_pie);
    chart_pie.render();

    var charts_status = [];
    var id_status_chart = ["#car_ongoing", "#car_complete", "#motor_ongoing", "#motor_complete"];
    for (let index = 0; index < 4; index++) {
        var chart_status = new ApexCharts(document.querySelector(id_status_chart[index]), options_status);
        charts_status.push(chart_status);
    }

    for (let index = 0; index < 4; index++) {
        charts_status[index].render();
    }

    const getData = () => {
        var route = "{{route('status.vehicle')}}";
        $.getJSON(route, function(response) {
            // console.log(response);
            chart_pie.updateSeries(response);
            for (let index = 0; index < 4; index++) {
                charts_status[index].updateSeries([response[index]]);
            }
        });
    }

    $(document).ready(function () { 
        getData();
        setInterval(getData, 60000);
    });
</script>

{{-- Script for bar chart total completed repairs in last week --}}
<script>
    var element = document.getElementById('bar_chart');
    var height = parseInt(KTUtil.css(element, 'height'));
    var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
    var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
    var baseColor = KTUtil.getCssVariableValue('--kt-primary');
    var lightColor = KTUtil.getCssVariableValue('--kt-primary-light');
    var green = KTUtil.getCssVariableValue('--kt-success');
    var infoColor = KTUtil.getCssVariableValue('--kt-info');

    const getColorMode = (mode) =>{
        var color = 'black';
        if(mode == 'dark'){
            color = 'white';
        } else {
            color = 'black';
        }
        return color;
    }

    const getBarOptions = (color, data_car, data_motor, categories) => {
        var options = {
            series: [{
                name: 'Car',
                data: data_car
            }, {
                name: 'Motorbike',
                data: data_motor
            }],
            chart: {
                height: 220,
                type: 'bar',
                zoom: {
                    type: 'x',
                    enabled: true,
                    autoScaleYaxis: true
                },
                toolbar: {
                    autoSelected: 'zoom'
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['40%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'left',
                labels: {
                    colors: color,
                },
                itemMargin: {
                    horizontal: 5,
                    vertical: 10
                },
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [baseColor, green, infoColor]
            },
            xaxis: {
                categories: categories,
                labels: {
                    style: {
                        colors: color,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-xaxis-label',
                    },
                },
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return (val).toFixed(0);
                    },
                    style: {
                        colors: color,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-yaxis-label',
                    },
                },
            },
            tooltip: {
                shared: false,
                y: {
                    formatter: function (val) {
                    return (val).toFixed(0)
                    }
                }
            },
            colors: [lightColor, green, infoColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: baseColor,
                strokeWidth: 3
            },
            noData: {
                text: 'Loading...'
            }
        };
        return options;
    }

    var chart = new ApexCharts(element, getBarOptions(getColorMode(KTThemeMode.getMode()), [], [], []));
    chart.render();

    const getDataBar = (color) =>{
        var url = '{{route("complete.repairs")}}';

        $.getJSON(url, function(response) {
            chart.updateOptions(getBarOptions(color, response.car, response.motor, response.date));
            $('.apexcharts-menu-item').css({color: "black"});
        });
    }

    $(document).ready(function () { 
        var mode = KTThemeMode.getMode();
        getDataBar(getColorMode(mode));
        const getBarData = () =>{
            getDataBar(getColorMode(mode))
        }
        setInterval(getBarData, 61000);
    });

    // change mode 
    $('a[data-kt-element="mode"]').on('click', function(){
        getDataBar(getColorMode($(this).attr('data-kt-value')));
    });

    $('#kt_apexcharts_3').on('click', function(){
        $('.apexcharts-menu-item').css({color: "black"});
    });
</script>

{{-- Script for area chart total revenue and area chart revenue by division --}}
<script>
    var element_revenue = document.getElementById('revenue_chart');
    var element_area = document.getElementById('area_chart');
    var height = parseInt(KTUtil.css(element, 'height'));
    var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
    var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');
    var baseColor = KTUtil.getCssVariableValue('--kt-primary');
    var lightColor = KTUtil.getCssVariableValue('--kt-primary-light');
    var green = KTUtil.getCssVariableValue('--kt-success');
    var infoColor = KTUtil.getCssVariableValue('--kt-info');

    const getRevenueOptions = (data, color) => {
        var options = {
            series: [
                {
                    name: 'Total Revenue',
                    data: data
                }
            ],
            chart: {
                type: 'area',
                stacked: false,
                zoom: {
                    type: 'x',
                    enabled: true,
                    autoScaleYaxis: true
                },
                toolbar: {
                    autoSelected: 'zoom'
                }
            },
            legend: {
                show: true,
                position: 'top',
                labels: {
                    colors: color,
                },
                itemMargin: {
                    horizontal: 5,
                    vertical: 10
                },
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [baseColor, green, infoColor]
            },
            xaxis: {
                // tickAmount: 20,
                type: 'datetime',
                labels: {
                    style: {
                        colors: color,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-xaxis-label',
                    },
                },
                title: {
                    text: 'Date',
                    style: {
                        color: color,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 600,
                        cssClass: 'apexcharts-yaxis-title',
                    },
                },
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(val)
                    },
                    style: {
                        colors: color,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-yaxis-label',
                    },
                },
                title: {
                    text: 'Total Revenue',
                    style: {
                        color: color,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 600,
                        cssClass: 'apexcharts-yaxis-title',
                    },
                },
            },
            tooltip: {
                shared: false,
                y: {
                    formatter: function (val) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(val)
                    }
                }
            },
            colors: [lightColor, green, infoColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: baseColor,
                strokeWidth: 3
            },
            noData: {
                text: 'Loading...'
            }
        };
        return options;
    }

    var chart_total_revenue = new ApexCharts(element_revenue, getRevenueOptions([], getColorMode(KTThemeMode.getMode())));
    chart_total_revenue.render();

    var chart_revenue_division = new ApexCharts(element_area, getRevenueOptions([], getColorMode(KTThemeMode.getMode())));
    chart_revenue_division.render();
    
    const getDataRevenue = (color) => {
        var division = $('#division').val();
        var route = "/getRevenueData?type="+division;
        $.getJSON(route, function(response) {
            chart_total_revenue.updateOptions(getRevenueOptions(response.total_payment_data, color));
            chart_revenue_division.updateOptions(getRevenueOptions(response.total_revenue_data, color));
            $('.apexcharts-menu-item').css({color: "black"});
        });
    }

    $(document).ready(function () { 
        var mode = KTThemeMode.getMode();
        getDataRevenue(getColorMode(mode));
    });

    // change mode 
    $('a[data-kt-element="mode"]').on('click', function(){
        getDataRevenue(getColorMode($(this).attr('data-kt-value')));
    });

    $('#kt_apexcharts_3').on('click', function(){
        $('.apexcharts-menu-item').css({color: "black"});
    });

    // on change division
    $('#division').on('change', function(){
        var mode = KTThemeMode.getMode();
        getDataRevenue(getColorMode(mode));
    });

    // Script for gauge chart mechanic efficiency
    var options_mechanic = {
    chart: {
        height: 215,
        type: "radialBar",
    },

    series: [],
    colors: ["#20E647"],
    plotOptions: {
        radialBar: {
        hollow: {
            margin: 0,
            size: "70%",
            background: "#293450"
        },
        track: {
            dropShadow: {
            enabled: true,
            top: 2,
            left: 0,
            blur: 4,
            opacity: 0.15
            }
        },
        dataLabels: {
            name: {
            offsetY: -10,
            color: "#fff",
            fontSize: "13px"
            },
            value: {
            color: "#fff",
            fontSize: "30px",
            show: true
            }
        }
        }
    },
    fill: {
        type: "gradient",
        gradient: {
        shade: "dark",
        type: "vertical",
        gradientToColors: ["#87D4F9"],
        stops: [0, 100]
        }
    },
    stroke: {
        lineCap: "round"
    },
    noData: {
        text: 'Loading...'
    },
    labels: ["Efficiency"]
    };

    var chart_mechanic = new ApexCharts(document.querySelector("#mechanic_chart"), options_mechanic);
    chart_mechanic.render();

    const getDataMechanic = () => {
        var mechanic = $('#mechanic').val();
        var route = "/getMechanicEfficient?mechanic_id="+mechanic;
        $.getJSON(route, function(response) {
            chart_mechanic.updateSeries(response);
        });
    }

    $(document).ready(function(){
        getDataMechanic();
    });

    $('#mechanic').on('change', function(){
        getDataMechanic();
    });

    // Script for bar chart average time
    const getOptionsTime = (color, data) => {
        var options = {
            series: [{
                name: 'Average Repair Time',
                data: data
            }],
            chart: {
                height: 250,
                type: 'bar',
                zoom: {
                    type: 'x',
                    enabled: true,
                    autoScaleYaxis: true
                },
                toolbar: {
                    autoSelected: 'zoom'
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: ['30%'],
                    endingShape: 'rounded'
                },
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'left',
                labels: {
                    colors: color,
                },
                itemMargin: {
                    horizontal: 5,
                    vertical: 10
                },
            },
            dataLabels: {
                enabled: false
            },
            markers: {
                size: 0,
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [baseColor, green, infoColor]
            },
            xaxis: {
                categories: ["Car", "Motorbike"],
                labels: {
                    style: {
                        colors: color,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-xaxis-label',
                    },
                },
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return (val).toFixed(2);
                    },
                    style: {
                        colors: color,
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 400,
                        cssClass: 'apexcharts-yaxis-label',
                    },
                },
            },
            tooltip: {
                shared: false,
                y: {
                    formatter: function (val) {
                    return (val).toFixed(2)
                    }
                }
            },
            colors: [lightColor, green, infoColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: baseColor,
                strokeWidth: 3
            },
            noData: {
                text: 'Loading...'
            }
        };
        return options;
    }

    var element_average = document.getElementById('average_chart');
    var chart_average = new ApexCharts(element_average, getOptionsTime(getColorMode(KTThemeMode.getMode()), []));
    chart_average.render();

    const getDataAverage = (color) =>{
        var url = '{{route("average.time")}}';

        $.getJSON(url, function(response) {
            chart_average.updateOptions(getOptionsTime(getColorMode(KTThemeMode.getMode()), response));
            $('.apexcharts-menu-item').css({color: "black"});
        });
    }

    $(document).ready(function () { 
        var mode = KTThemeMode.getMode();
        getDataAverage(getColorMode(mode));
        const getAverageData = () =>{
            getDataAverage(getColorMode(mode))
        }
        setInterval(getAverageData, 62000);
    });

    // Script for table stock parts
    $("#table").DataTable({
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
</script>
@endpush