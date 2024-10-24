@extends('admin.master')

@section('title')
@endsection

@section('content')
    <script>
        // app.js hoặc file JavaScript của bạn
        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://pat-server.ddns.net:8000/')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data); // Xử lý dữ liệu ở đây
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        });
    </script>

    <h1>Station Chart: {{ $waterpump->name }}</h1>

    <div id="container" style="height: 400px; min-width: 310px"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);

            Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Water Pump Data'
                },
                subtitle: {
                    text: 'Flow Rate, Pressure and Output over Time'
                },
                xAxis: {
                    type: 'datetime',
                    title: {
                        text: 'Date'
                    }
                },
                yAxis: [{ // Primary yAxis  
                    title: {
                        text: 'Flow Rate'
                    },
                    opposite: false
                }, { // Secondary yAxis  
                    title: {
                        text: 'Pressure',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true
                }, { // Tertiary yAxis  
                    title: {
                        text: 'Output',
                        style: {
                            color: Highcharts.getOptions().colors[2]
                        }
                    },
                    opposite: true
                }],
                series: [{
                    name: 'Flow Rate',
                    data: chartData.map(record => [record.x, record.flow_rate]),
                    tooltip: {
                        valueSuffix: ' m³/h' // Đơn vị lưu lượng  
                    }
                }, {
                    name: 'Pressure',
                    yAxis: 1, // Thể hiện trên trục y thứ hai  
                    data: chartData.map(record => [record.x, record.pressure]),
                    tooltip: {
                        valueSuffix: ' bar' // Đơn vị áp suất  
                    }
                }, {
                    name: 'Output',
                    yAxis: 2, // Thể hiện trên trục y thứ ba  
                    data: chartData.map(record => [record.x, record.output]),
                    tooltip: {
                        valueSuffix: ' L' // Đơn vị output, có thể thay đổi theo cần  
                    }
                }],
                tooltip: {
                    shared: true,
                    crosshairs: true
                }
            });
        });
    </script>

    <a href="{{ route('waterpumps.index') }}" class="btn btn-link  btn-rounded">Head back</a>
@endsection
