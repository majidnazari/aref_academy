<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `course_students`  CHANGE `financial_refused_status` `financial_refused_status` ENUM('withMoney', 'noMoney') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL ");
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `course_students`  CHANGE `financial_refused_status` `financial_refused_status` ENUM('withMoney', 'noMoney', 'transferred') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL ");
        
    }
};
