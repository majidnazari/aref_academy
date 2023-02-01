<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $now=Carbon::now();
        DB::table('groups')->insert([            
           [
            "user_id_creator" => 0,
            "name" =>"consultant",  
            "persian_name" =>"مشاور",          
            "type" =>"consultant",            
            "created_at" => $now,
            "updated_at" => $now
           ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('groups')->where('type','consultant')->delete();
    }
};
