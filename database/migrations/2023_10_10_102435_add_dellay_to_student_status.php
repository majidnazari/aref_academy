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
        Schema::table('consultant_definition_details', function (Blueprint $table) {
            DB::statement("ALTER TABLE `consultant_definition_details`  CHANGE `student_status` `student_status` ENUM('absent', 'present', 'no_action','dellay') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_action'");
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultant_definition_details', function (Blueprint $table) {
            DB::statement("ALTER TABLE `consultant_definition_details`  CHANGE `student_status` `student_status` ENUM('absent', 'present','no_action') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_action'");
       
        });
    }
};
