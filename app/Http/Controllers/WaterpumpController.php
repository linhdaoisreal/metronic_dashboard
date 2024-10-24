<?php

namespace App\Http\Controllers;

use App\Models\Waterpump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaterpumpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = WaterPump::select('waterpumps.*', DB::raw('MAX(waterpump_data.recorded_at) as latest_recorded_at'))
            ->leftJoin('waterpump_data', 'waterpumps.id', '=', 'waterpump_data.water_pump_id')
            ->groupBy('waterpumps.id')
            ->latest('waterpumps.id')
            ->paginate(5);

        // dd($data->toArray());

        return view('admin.waterpump.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Waterpump $waterpump)
    {
        // Giả định rằng WaterPump có mối quan hệ với WaterPumpData  
        $data = $waterpump->waterPumpData()->orderBy('recorded_at', 'asc')->get();
        // dd($data->toArray());

        $chartData = [];
        foreach ($data as $record) {
            $chartData[] = [
                'x' => strtotime($record->recorded_at) * 1000, // Chuyển đổi sang milliseconds  
                'flow_rate' => (float)$record->flow_rate,
                'pressure' => (float)$record->pressure,
                'output' => (float)$record->output,
            ];
        }

        // dd($chartData);

        return view('admin.waterpump.show', compact('waterpump', 'chartData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Waterpump $waterpump)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Waterpump $waterpump)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Waterpump $waterpump)
    {
        //
    }
}
