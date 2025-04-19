<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusRouteLocation extends Model
{
    protected $fillable = [
        'location_name',
        'latitude',
        'longitude',
    ];
    
}
