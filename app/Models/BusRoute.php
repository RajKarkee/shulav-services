<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Bus;

class BusRoute extends Model
{

    use HasFactory;

    protected $fillable = [
        'from_location_id',
        'to_location_id',
        'bus_type_id',
        'distance',
        'estimated_time',
        'fare',
        'description'
    ];

    public function fromLocation()
    {
        return $this->belongsTo(BusRouteLocation::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(BusRouteLocation::class, 'to_location_id');
    }

    public function busType()
    {
        return $this->belongsTo(Bus_Type::class);
    }
}

