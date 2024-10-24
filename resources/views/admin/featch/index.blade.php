@extends('admin.master')

@section('title')
    Station
@endsection

@section('content')
    <h1>All Station</h1>

    <div>
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th class="fw-bold fs-5">ID</th>
                    <th class="fw-bold fs-5">Logger SN</th>
                    <th class="fw-bold fs-5">Connect Status</th>
                    <th class="fw-bold fs-5">Meter IDX</th>
                    <th class="fw-bold fs-5">Pressure</th>
                    <th class="fw-bold fs-5">Flow</th>
                    <th class="fw-bold fs-5">Active Date</th>
                    <th class="fw-bold fs-5">Last Record</th>
                    <th class="fw-bold fs-5">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginatedData as $log)
                    <tr>
                        <td>
                            <p class="fw-bold mb-1">{{ $log['logger']['id'] }}</p>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="ms-3">
                                    <p class="fw-bold mb-1">{{ $log['logger']['logger_sn'] }}</p>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if ($log['detailData']['connect_stt'])
                                <span class="badge badge-success rounded-pill d-inline">Active</span>
                            @else
                                <span class="badge badge-danger rounded-pill d-inline">Disconnect</span>
                            @endif
                        </td>

                        <td>
                            <p class="fw-normal mb-1">{{$log['detailData']['meter_idx']}}</p>
                        </td>
                        
                        <td>
                            <p class="fw-normal mb-1">{{$log['detailData']['pressure']}}</p>
                        </td>

                        <td>
                            <p class="fw-normal mb-1">{{$log['detailData']['flow']}}</p>
                        </td>
                        
                        <td>
                            <p class="fw-normal mb-1">
                                {{ \Carbon\Carbon::parse($log['detailData']['active_date'])->timezone('Asia/Bangkok')->format('d/m/Y H:i:s') }}
                            </p>
                        </td>

                        <td>
                            <p class="fw-normal mb-1">
                                {{ \Carbon\Carbon::parse($log['detailData']['last_update_time'])->timezone('Asia/Bangkok')->format('d/m/Y H:i:s') }}
                            </p>
                        </td>

                        <td>
                            <a href="{{ route('featch-one', $log['logger']['logger_sn']) }}"
                                class="btn btn-info btn-sm btn-rounded">VIEW</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $paginatedData->links() }}
    </div>
@endsection
