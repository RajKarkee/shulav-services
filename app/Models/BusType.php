<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{
    protected $table = 'bus_types';
    protected $fillable =[
        'bus_type_name',
        'short_description',
        'long_description',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'image_5',
        'image_6',
        'image_7',

    ];
}
