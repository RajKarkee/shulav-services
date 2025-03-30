<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const tableName = 'products';
    protected $fillable = [
        'type', 'name', 'short_desc', 'desc', 'price',
        'vendor_id', 'active', 'image', 'service_id',
        'start', 'end', 'count', 'city_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }


}
