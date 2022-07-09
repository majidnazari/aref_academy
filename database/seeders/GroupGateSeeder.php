<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupGateSeeder extends Seeder
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
       DB::table('group_gate')->insert([

        // "email" => "majidnazarister@gmail.com",
        //"type" =>"admin",
       [ "user_id_creator" => 1,
        "group_id" => 1, //admin
        "key" => "coppon",// test dashbord for admin 
        "user_id" => 1,
        "created_at" => $now,
        "updated_at" =>$now
       ],
       [ "user_id_creator" => 1,
       "group_id" => 2, //manager
       "key" => "course",// test dashbord for manager 
       "user_id" => 2,
       "created_at" => $now,
       "updated_at" =>$now
       ],
       [ "user_id_creator" => 1,
       "group_id" =>3, //financial
       "key" => "reset password",// test dashbord for financial 
       "user_id" => 3,
       "created_at" => $now,
       "updated_at" =>$now
        ],
        [ "user_id_creator" => 1,
            "group_id" =>4, //financial
            "key" => "reset password",// test dashbord for financial 
            "user_id" => 4,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ "user_id_creator" => 1,
        "group_id" =>5, //financial
        "key" => "reset password",// test dashbord for financial 
        "user_id" => 5,
        "created_at" => $now,
        "updated_at" =>$now
        ]

       ]);
    }
}
