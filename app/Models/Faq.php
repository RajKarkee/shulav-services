<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    public function other(){
        return Faq::where('id','!=',$this->id)->get(['id','q']);
    }
    public function hasOther(){
        return Faq::where('id','!=',$this->id)->count()>0;
    }
}
