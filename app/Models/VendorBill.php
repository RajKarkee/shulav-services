<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBill extends Model
{
    use HasFactory;
    protected $casts = [
        'paid' =>'boolean',
        'date'=>'datetime'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id','id');
    }

    public function service()
    {
        return $this->hasOne(VendorServices::class,'bill_id','id');
        // return VendorServices::where('bill_id',$this->id)->first();
//
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'service_id','id');
        // return VendorServices::where('bill_id',$this->id)->first();
//
    }
}
