<?php

namespace Database\Seeders;

use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now=Carbon::now();
       
        DB::table('groups')->insert([
            [
            "user_id_creator" => 0,
            "name" =>"admin",            
            "persian_name" =>"مدیر ارشد",            
            "type" =>"admin",            
            "created_at" => $now,
            "updated_at" => $now
    
           ],
           [
            "user_id_creator" => 0,
            "name" =>"manager", 
            "persian_name" =>"مدیر",             
            "type" =>"manager",            
            "created_at" => $now,
            "updated_at" => $now
           ],
           [
            "user_id_creator" => 0,
            "name" =>"financial", 
            "persian_name" =>"مالی",             
            "type" =>"financial",            
            "created_at" => $now,
            "updated_at" => $now
           ],
           [
            "user_id_creator" => 0,
            "name" =>"acceptor",
            "persian_name" =>"پذیرشگر",              
            "type" =>"acceptor",            
            "created_at" => $now,
            "updated_at" => $now
           ],
           [
            "user_id_creator" => 0,
            "name" =>"teacher",  
            "persian_name" =>"دبیر",          
            "type" =>"teacher",            
            "created_at" => $now,
            "updated_at" => $now
           ]           
        ]);  
    }
}
