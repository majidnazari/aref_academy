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
   User::create([
        'first_name' => 'Jose ',
        'last_name' => ' Fonseca',
        'type' => 'admin',
        'is_teacher' => 1,        
        'email' => '09150000000',
        'password' => bcrypt('123456789qq')
    ]);
})->describe('Create sample user');