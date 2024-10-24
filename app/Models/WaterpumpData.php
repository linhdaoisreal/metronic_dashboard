<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterpumpData extends Model
{
    use HasFactory;

    public function waterPump(){
        return $this->belongsTo(Waterpump::class);
    }
}
