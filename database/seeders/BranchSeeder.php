<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now=Carbon::now();
        DB::table('branches')->insert([
           [
            "user_id_creator" =>1,
            "name"=> "مدرسه ابتدایی هاشمیه",
            "created_at" => $now,
           ]
        ]);
    }
}
