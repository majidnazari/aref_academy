<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupMenusSeeder extends Seeder
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
       DB::table('group_menu')->insert([

        // "email" => "majidnazarister@gmail.com",
        //"type" =>"admin",
       [ "user_id_creator" => 0,
        "group_id" => 1, //admin
        "menu_id" => 1,// test dashbord for admin 
        "user_id" => 1,
        "created_at" => $now,
        "updated_at" =>$now
       ],
       [ "user_id_creator" => 0,
       "group_id" => 2, //manager
       "menu_id" => 2,// test dashbord for manager 
       "user_id" => 2,
       "created_at" => $now,
       "updated_at" =>$now
       ],
       [ "user_id_creator" => 0,
       "group_id" => 3, //financial
       "menu_id" => 3,// test dashbord for financial 
       "user_id" => 3,
       "created_at" => $now,
       "updated_at" =>$now
       ],
       [ "user_id_creator" => 0,
       "group_id" => 4, //acceptor
       "menu_id" => 4,// test dashbord for acceptor 
       "user_id" => 4,
       "created_at" => $now,
       "updated_at" =>$now
       ],
       [ "user_id_creator" => 0,
       "group_id" => 5, //teacher
       "menu_id" => 5,// test dashbord for teacher 
       "user_id" => 5,
       "created_at" => $now,
       "updated_at" =>$now
       ],
       [ 
       "user_id_creator" => 0,
       "group_id" => 1, //teacher
       "menu_id" => 6,// test dashbord for teacher 
       "user_id" => 1,
       "created_at" => $now,
       "updated_at" =>$now
       ],      
        [ 
            "user_id_creator" => 0,
            "group_id" => 1, 
            "menu_id" => 7,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 1, 
            "menu_id" => 8,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
       ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 1, 
            "menu_id" => 9,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 1, 
            "menu_id" => 10,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 1, 
            "menu_id" => 11,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 1, 
            "menu_id" => 12,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 1, 
            "menu_id" => 13,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 1, 
            "menu_id" => 14,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 2, 
            "menu_id" => 10,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 2, 
            "menu_id" => 7,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 2, 
            "menu_id" => 12,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 2, 
            "menu_id" => 9,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 2, 
            "menu_id" => 13,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 2, 
            "menu_id" => 14,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 3, 
            "menu_id" => 7,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 3, 
            "menu_id" => 10,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 3, 
            "menu_id" => 13,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 4, 
            "menu_id" => 13,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 4, 
            "menu_id" => 10,
            "user_id" => 2,
            "created_at" => $now,
            "updated_at" =>$now
        ],
        [ 
            "user_id_creator" => 0,
            "group_id" => 4, 
            "menu_id" => 14,
            "user_id" => 1,
            "created_at" => $now,
            "updated_at" =>$now
        ],



       ]);
    }
}
