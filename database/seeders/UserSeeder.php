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
        

    //     $sql = base_path('database/seeders/sql_function.sql');
    //     DB::unprepared(file_get_contents($sql));
    //    // DB::unprepared($sql); 

        $now=Carbon::now();
        //
       DB::table('users')->insert([

        // "email" => "majidnazarister@gmail.com",
        //"type" =>"admin",        
        [ 
        "group_id"=> 1,
        "password" => Hash::make("1234asdfA"),
        "first_name" => "admin",
        "last_name" => "admin",
        "email" => "09153254678",
        "created_at" => $now,
        "updated_at" =>$now
       ],
       [
        "group_id"=> 2, 
        "password" => Hash::make("123456"),
        "first_name" => "hashem",
        "last_name" => "beigi",
        "email" => "09372120891",
        "created_at" =>$now,
        "updated_at" =>$now
       ],
       [ 
        "group_id"=> 3,
        "password" => Hash::make("123456"),
        "first_name" => "rasol",
        "last_name" => "mokhtar",
        "email" => "09372120892",
        "created_at" =>$now,
        "updated_at" =>$now
       ],
       [ 
        "group_id"=> 4,
        "password" => Hash::make("123456"),
        "first_name" => "mahla",
        "last_name" => "soroush",
        "email" => "09372120893",
        "created_at" =>$now,
        "updated_at" =>$now
       ],
       [
        "group_id"=> 5,
        "password" => Hash::make("123456"),
        "first_name" => "bagher",
        "last_name" => "mirsamie",
        "email" => "09372120894",
        "created_at" =>$now,
        "updated_at" =>$now
       ],


       ]);
    }
}
