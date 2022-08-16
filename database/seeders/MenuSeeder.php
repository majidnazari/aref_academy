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
        "icon" => "DashboardIcon",
        "href" => "/admin",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],
       [ 
           "slug" => "link",
            "name" => "داشبورد مدیر آموزشگاه",
            "icon" => "DashboardIcon",
            "href" => "/manager",
            "parent_id" => 0,        
            "created_at" => $now,
            "updated_at" =>$now
       ],
       [ 
           "slug" => "link",
            "name" => "داشبورد مالی",
            "icon" => "DashboardIcon",
            "href" => "/financial",
            "parent_id" => 0,        
            "created_at" => $now,
            "updated_at" =>$now
       ],
       [ 
            "slug" => "link",
            "name" => "داشبورد دبیر",
            "icon" => "DashboardIcon",
            "href" => "/teacher",
            "parent_id" => 0,        
            "created_at" => $now,
            "updated_at" =>$now
       ],
       [ 
           "slug" => "link",
           "name" => "داشبورد پذیرنده",
           "icon" => "DashboardIcon",
           "href" => "/acceptor",
           "parent_id" => 0,        
           "created_at" => $now,
           "updated_at" =>$now
       ],
       [ 
        "slug" => "link",
        "name" => "مدیریت کاربران",
        "icon" => "ShoppingCartIcon",
        "href" => "/users",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],

       [ 
        "slug" => "link",
        "name" => "مدیریت کلاس‌ها",
        "icon" => "ClassIcon",
        "href" => "/courses",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],
       [ 
        "slug" => "link",
        "name" => "سال تحصیلی فعال",
        "icon" => "ReceiptLongIcon",
        "href" => "/years",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],

       [ 
        "slug" => "link",
        "name" => "تعریف تخلفات",
        "icon" => "NewReleasesIcon",
        "href" => "/faults",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],

       [ 
        "slug" => "link",
        "name" => "فهرست دانش آموزان",
        "icon" => "PeopleIcon",
        "href" => "/students",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],

       [ 
        "slug" => "link",
        "name" => "مدیریت شعبه‌ها",
        "icon" => "AddBusinessIcon",
        "href" => "/branches",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],

       [ 
        "slug" => "link",
        "name" => "مدیریت دروس",
        "icon" => "MenuBookIcon",
        "href" => "/lessons",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],

       [ 
        "slug" => "link",
        "name" => "گزارش کلاسها",
        "icon" => "BarChartIcon",
        "href" => "/reports/courses",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],

       [ 
        "slug" => "link",
        "name" => "حضوروغیاب",
        "icon" => "CoPresentIcon",
        "href" => "/absence-presences",
        "parent_id" => 0,        
        "created_at" => $now,
        "updated_at" =>$now
       ],



       ]);
    }
}
