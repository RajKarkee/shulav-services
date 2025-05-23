<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    
    const tableName='cities';

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
