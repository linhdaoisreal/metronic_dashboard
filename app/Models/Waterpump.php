<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waterpump extends Model
{
    use HasFactory;

    public function waterPumpData(){
        return $this->hasMany(WaterpumpData::class, 'water_pump_id');
    }
}
