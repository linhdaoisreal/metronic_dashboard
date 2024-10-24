@extends('admin.master')

@section('title')
@endsection

@section('content')
    <div>
        <div class="card my-2">
            <div class="card-body d-flex align-items-center">
                <img src="http://pat-server.ddns.net:8000/assets/media/waconnect/usr-m100.png" alt="Device Image" style="width:15%" class="me-3">
                <div class="mx-2">
                    <h2>
                        Logger: {{ $logger_sn }} 
                    </h2>
                    <p>
                        @if ($detailData['connect_stt'])
                            <span class="text-success">👍 Connected</span>
                        @else
                            <span class="text-danger">❌ Disconnected</span>
                        @endif
                        <span class="fw-bold">Last updated:</span> {{ \Carbon\Carbon::parse($detailData['last_update_time'])->timezone('Asia/Bangkok')->format('d/m/Y H:i:s') }}
                    </p>
                    <div class="d-flex flex-wrap">

                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">

                            <div class="d-flex align-items-center">
                                <div id="last-flow" class="fs-2 fw-bold" data-kt-countup="false" data-kt-countup-value="100"
                                    data-kt-countup-suffix=" m3/h">{{$detailData['flow']}}</div>
                            </div>

                            <div class="fw-semibold fs-6 text-gray-400">Flow (m3/h)</div>

                        </div>


                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">

                            <div class="d-flex align-items-center">
                                <div id="last-pressure" class="fs-2 fw-bold" data-kt-countup="false"
                                    data-kt-countup-value="1.4 " data-kt-countup-suffix=" bar">{{$detailData['pressure']}}</div>
                            </div>

                            <div class="fw-semibold fs-6 text-gray-400">Pressure(bar)</div>

                        </div>


                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">

                            <div class="d-flex align-items-center">
                                <div id="total-meter-idx" class="fs-2 fw-bold" data-kt-countup="false"
                                    data-kt-countup-value="60" data-kt-countup-prefix="%">{{$detailData['meter_idx']}}</div>
                            </div>

                            <div class="fw-semibold fs-6 text-gray-400">Meter IDX (m3)</div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="card my-2">
            <ul class="nav nav-fill nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold active" id="fill-tab-0" data-bs-toggle="tab" href="#fill-tabpanel-0" role="tab"
                        aria-controls="fill-tabpanel-0" aria-selected="true"> 🏠 Dashboard </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold" id="fill-tab-1" data-bs-toggle="tab" href="#fill-tabpanel-1" role="tab"
                        aria-controls="fill-tabpanel-1" aria-selected="false"> 📈 Trend </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold" id="fill-tab-2" data-bs-toggle="tab" href="#fill-tabpanel-2" role="tab"
                        aria-controls="fill-tabpanel-2" aria-selected="false"> 🔔 Events </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-bold" id="fill-tab-3" data-bs-toggle="tab" href="#fill-tabpanel-3" role="tab"
                        aria-controls="fill-tabpanel-3" aria-selected="false"> ⚙️ Settings </a>
                </li>
            </ul>
            <div class="tab-content pt-5" id="tab-content">

                <div class="tab-pane active" id="fill-tabpanel-0" role="tabpanel" aria-labelledby="fill-tab-0">
                    <div id="container" style="height: 400px; min-width: 310px"></div>
                </div>

                <div class="tab-pane" id="fill-tabpanel-1" role="tabpanel" aria-labelledby="fill-tab-1">
                    Tab Tab 2 selected
                </div>

                <div class="tab-pane" id="fill-tabpanel-2" role="tabpanel" aria-labelledby="fill-tab-2">
                    Tab Tab 3 selected
                </div>

                <div class="tab-pane" id="fill-tabpanel-3" role="tabpanel" aria-labelledby="fill-tab-3">
                    Tab Tab 4 selected
                </div>

            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);

            Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Logger Dashboard'
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
                        text: 'Flow'
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
                        text: 'Meter IDX',
                        style: {
                            color: Highcharts.getOptions().colors[2]
                        }
                    },
                    opposite: true
                }],
                series: [{
                    name: 'Flow',
                    data: chartData.map(record => [record.x, record.flow],
                        // color: record.flow > record.pressure ? 'red' : undefined
                    ),
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
                    name: 'Meter IDX',
                    yAxis: 2, // Thể hiện trên trục y thứ ba  
                    data: chartData.map(record => [record.x, record.meter_idx]),
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

    <a href="{{ route('featch-index') }}" class="btn btn-link  btn-rounded">Head back</a>
@endsection
