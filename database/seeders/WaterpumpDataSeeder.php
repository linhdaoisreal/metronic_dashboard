<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WaterpumpDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách trạm bơm  
        $waterPumps = DB::table('waterpumps')->pluck('id');  

        $data = [];  
        foreach ($waterPumps as $pumpId) {  
            $currentDateTime = Carbon::now();  
            for ($i = 0; $i < 25; $i++) {  
                $data[] = [  
                    'water_pump_id' => $pumpId,  
                    'flow_rate' => rand(100, 500) / 10, // Lưu lượng ngẫu nhiên từ 10 đến 50 m³/h  
                    'pressure' => rand(1, 10), // Áp lực ngẫu nhiên từ 1 đến 10 bar  
                    'output' => rand(500, 1000) / 10, // Sản lượng ngẫu nhiên từ 50 đến 100 m³  
                    'recorded_at' => $currentDateTime->copy()->subMinutes($i * 15), // Cách nhau 15 phút  
                    'created_at' => $currentDateTime->copy()->subMinutes($i * 15),  
                    'updated_at' => $currentDateTime->copy()->subMinutes($i * 15),  
                ];  
            }  
        }  

        DB::table('waterpump_data')->insert($data);   
    }
}
