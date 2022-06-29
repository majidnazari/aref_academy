<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

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
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user', function () {
   user::create([
    'type' => "admin",    
     'email' => "09372120899",
     'password' => bcrypt('123456789qq'),
     'first_name' => "majid",
     'last_name' => "nazari",
     'is_teacher' => 1 ,
     'created_at' => Carbon\Carbon::now(),      
     'updated_at' => Carbon\Carbon::now(),      
    ]);
})->describe('Create sample user');