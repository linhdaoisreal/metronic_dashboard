@extends('admin.master')

@section('title')
@endsection

@section('content')
<div>
    <table class="table align-middle mb-0 bg-white">
        <thead class="bg-light">
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Location</th>
                <th>Status</th>
                <th>Last Record</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $wp)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{$wp->name}}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p class="fw-normal mb-1">{{$wp->code}}</p>
                    </td>
                    <td>
                        <p class="fw-normal mb-1">{{$wp->location}}</p>
                    </td>
                    <td>
                        <span class="badge badge-success rounded-pill d-inline">Active</span>
                    </td>
                    <td>
                        <p class="fw-normal mb-1">
                            {{ \Carbon\Carbon::parse($wp->latest_recorded_at)->timezone('Asia/Bangkok')->format('d/m/Y H:i:s') }}
                        </p>
                    </td>
                    <td>
                        <a href="{{route('waterpumps.show', $wp->id)}}" class="btn btn-link btn-sm btn-rounded">VIEW</a>
                    </td>
                </tr>
            @endforeach 
        </tbody>
    </table>

    {{ $data->links() }}
</div>
@endsection
