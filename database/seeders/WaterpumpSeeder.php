<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WaterpumpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $waterPumps = [  
            ['name' => 'Trạm Bơm 1', 'code' => 'TP1', 'location' => 'Vị trí 1'],  
            ['name' => 'Trạm Bơm 2', 'code' => 'TP2', 'location' => 'Vị trí 2'],  
            ['name' => 'Trạm Bơm 3', 'code' => 'TP3', 'location' => 'Vị trí 3'],  
            ['name' => 'Trạm Bơm 4', 'code' => 'TP4', 'location' => 'Vị trí 4'],  
            ['name' => 'Trạm Bơm 5', 'code' => 'TP5', 'location' => 'Vị trí 5'],  
        ];  

        DB::table('waterpumps')->insert($waterPumps);
    }
}
