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

        DB::statement("ALTER TABLE `consultant_financials`  CHANGE `student_status` `student_status` ENUM('ok', 'refused', 'fired','financial_pending','fire_pending','refuse_pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL DEFAULT 'ok'");
        // Schema::table('consultant_financials', function (Blueprint $table) {
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
        DB::statement("ALTER TABLE `consultant_financials`  CHANGE `student_status` `student_status` ENUM('ok', 'refused', 'fired','financial_pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  NULL DEFAULT 'ok'");

        // Schema::table('consultant_financials', function (Blueprint $table) {
        //     //
        // });
    }
};
