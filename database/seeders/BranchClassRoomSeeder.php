<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now=Carbon::now();
        DB::table('branch_class_rooms')->insert([
            [
                "user_id_creator" =>1,
                "branch_id"=>1,
                "name" => "کلاس 101",

            ],
            [
                "user_id_creator" =>1,
                "branch_id"=>1,
                "name" => "کلاس 102",
                
            ],
            [
                "user_id_creator" =>1,
                "branch_id"=>1,
                "name" => "کلاس 103",
                
            ]
        ]);
    }
}
