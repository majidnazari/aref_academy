<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Log;

class Sql_menu_seeder_FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path('database/seeders/sql/sql_menu_seeder.sql'); 
        
        $sql = file_get_contents($path); 
       
        DB::unprepared($sql); 
    }
}
