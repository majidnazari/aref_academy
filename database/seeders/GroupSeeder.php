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
            "user_id" => 0,
            "name" =>"admin",            
            "created_at" => $now,
            "updated_at" => $now
    
           ],
           [
            "user_id" => 0,
            "name" =>"manager",            
            "created_at" => $now,
            "updated_at" => $now
           ],
           [
            "user_id" => 0,
            "name" =>"financial",            
            "created_at" => $now,
            "updated_at" => $now
           ],
           [
            "user_id" => 0,
            "name" =>"acceptor",            
            "created_at" => $now,
            "updated_at" => $now
           ]
        ]);  
    }
}
