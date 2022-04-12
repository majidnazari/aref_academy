<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       DB::table('users')->insert([

        "email" => "majidnazarister@gmail.com",
        "type" =>"admin",
        "password" => bcrypt("12345"),
        "first_name" => "majid",
        "last_name" => "nazari",
        "mobile" => "09372120890",
        "created_at" =>Carbon::now(),
        "updated_at" =>Carbon::now()

       ]);
    }
}
