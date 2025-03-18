<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Otp extends Model
{
    use HasFactory;

    protected $filled = ['phone', 'otp', 'sent', 'validtill'];
    protected $casts = [
        'sent' => 'boolean',
        'validtill' => 'datetime'
    ];
    public function send()
    {
        $this->sent = true;
        $this->save();
        $url = env('sms_url', '');
        $token = env('sms_token', '');
        if ($url == '' || $token == '') {
            $this->save();
            return false;
        }
        $response = Http::post($url, [
            'auth_token' => $token,
            'to'    => $this->phone,
            'text'  => $this->otp
        ]);
        // echo $response->body();
        // return $response->body();
        $checkBody =  json_decode($response->body());
        if($checkBody->error){
            return false;
        }else{
            $this->sent = true;
            $this->save();
            return true;
        }
        // if ($response->ok()) {
        //     $this->sent = true;
        //     $this->save();
        // }else{
        //     $this->save();
        //     return false;
        // }

    }
}
