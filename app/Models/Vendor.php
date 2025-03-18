<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Extra\Opening;

class Vendor extends Model
{
    use HasFactory;
    protected $casts = [
        'opening' =>'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function bills(){
        return $this->hasMany(VendorBill::class);
    }

    public function reviewDetail(){

    }

    public function getOpening(){
        // return Opening::
    }
}
