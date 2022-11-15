<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `course_students`  CHANGE `financial_refused_status` `financial_refused_status` ENUM('withMoney', 'noMoney', 'transferred') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL ");
        // Schema::table('course_studentds', function (Blueprint $table) {
        //     //
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `course_students`  CHANGE `financial_refused_status` `financial_refused_status` ENUM('withMoney', 'noMoney') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL ");
        
    }
};
