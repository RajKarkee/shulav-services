<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Otp extends Model
{
    protected $fillable = ['phone', 'otp', 'validtill'];
    public $timestamps = false;

}
