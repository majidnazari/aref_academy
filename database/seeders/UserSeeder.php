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
        "first_name" => "مدیر",
        "last_name" => "۱",
        "email" => "09372120891",
        "created_at" =>$now,
        "updated_at" =>$now
       ],
       [ 
        "group_id"=> 3,
        "password" => Hash::make("123456"),
        "first_name" => " مدیر مالی",
        "last_name" => "۱",
        "email" => "09372120892",
        "created_at" =>$now,
        "updated_at" =>$now
       ],
       [ 
        "group_id"=> 4,
        "password" => Hash::make("123456"),
        "first_name" => "پذیرشگر",
        "last_name" => "۱",
        "email" => "09372120893",
        "created_at" =>$now,
        "updated_at" =>$now
       ],
       [
        "group_id"=> 5,
        "password" => Hash::make("123456"),
        "first_name" => "دبیر",
        "last_name" => "۱",
        "email" => "09372120894",
        "created_at" =>$now,
        "updated_at" =>$now
       ],
       [
        "group_id"=> 6,
        "password" => Hash::make("123456"),
        "first_name" => "مشاور",
        "last_name" => " ۱ ",
        "email" => "09372120895",
        "created_at" =>$now,
        "updated_at" =>$now
       ],
       [
        "group_id"=> 7,
        "password" => Hash::make("123456"),
        "first_name" => "مدیر مشاور",
        "last_name" => " ۱ ",
        "email" => "09372120896",
        "created_at" =>$now,
        "updated_at" =>$now
       ],


       ]);
    }
}
