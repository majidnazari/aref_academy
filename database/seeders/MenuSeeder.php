<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now=Carbon::now();
        //
       DB::table('menus')->insert([

        // "email" => "majidnazarister@gmail.com",
        //"type" =>"admin",
       [
        "slug" => "link",
        "name" => "داشبورد ادمین",
        "icon" => "fas fa-tachometer-alt",
        "href" => "/admin",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],
       [ 
           "slug" => "link",
            "name" => "داشبورد مدیر آموزشگاه",
            "icon" => "fas fa-tachometer-alt",
            "href" => "/manager",
            "parent_id" => 0,        
            "created_at" => $now,
            "updated_at" =>$now
       ],
       [ 
           "slug" => "link",
            "name" => "داشبورد مالی",
            "icon" => "fas fa-tachometer-alt",
            "href" => "/financial",
            "parent_id" => 0,        
            "created_at" => $now,
            "updated_at" =>$now
       ],
       [ 
            "slug" => "link",
            "name" => "داشبورد دبیر",
            "icon" => "fas fa-tachometer-alt",
            "href" => "/teacher",
            "parent_id" => 0,        
            "created_at" => $now,
            "updated_at" =>$now
       ],
       [ 
           "slug" => "link",
           "name" => "داشبورد پذیرنده",
           "icon" => "fas fa-tachometer-alt",
           "href" => "/acceptor",
           "parent_id" => 0,        
           "created_at" => $now,
           "updated_at" =>$now
       ]


       ]);
    }
}
