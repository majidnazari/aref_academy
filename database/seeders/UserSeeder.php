<?php

namespace Database\Seeders;

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
        "password" => bcrypt("12345"),
        "first_name" => "majid",
        "last_name" => "nazari",
        "mobile" => "09372120890",

       ]);
    }
}
