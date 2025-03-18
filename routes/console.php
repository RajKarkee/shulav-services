<?php

use App\Models\City;
use App\Models\Location;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    echo bcrypt('Chhatra123@');
})->purpose('Display an inspiring quote');

Artisan::command('make:inspire', function () {
    echo bcrypt('Chhatra123@');
})->purpose('Display an inspiring quote');


Artisan::command('bc', function () {
    $user=User::where('email','komal2@gmail.com')->first();
    $user->password= bcrypt('admin');
    $user->save();
    $user=User::where('email','cms111000111@gmail.com')->first();
    $user->password= bcrypt('admin');
    $user->save();
})->purpose('Display an inspiring quote');



Artisan::command('back', function () {
    Vendor::where('id','>',0)->update(['step'=>1]);
})->purpose('Display an inspiring quote');

Artisan::command('make:admin', function () {
    User::create([
        'name' => 'admin',
        'role'=>1,
        'username' => 'admin',
        'email' =>'admin@needtechnosoft.com',
        'email_verified_at' => now(),
        'password' => bcrypt('admin'), // password
        'remember_token' =>Str::random(10),
    ]);
})->purpose('Display an inspiring quote');

Artisan::command('ll', function () {
    $faker=\Faker\Factory::create();
    $ids=City::pluck('id');
    for ($i=0; $i < 100; $i++) {
        $loc=new Location();
        $loc->name=$faker->streetName();
        $loc->city_id=$ids[(mt_rand(0,count($ids)-1))];
        $loc->save();
        echo $loc->name."Saved\n";
    }
})->purpose('Display an inspiring quote');
