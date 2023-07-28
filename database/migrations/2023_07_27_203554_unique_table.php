<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('consultant_financials', function (Blueprint $table) {
            DB::statement("ALTER TABLE `consultant_financials` CHANGE `financial_status` `financial_status` ENUM('approved','pending','semi_approved') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending'");
            $table->unique(["branch_id","consultant_id","student_id","year_id","consultant_definition_detail_id"],"distinc_unique");
            $table->foreignId("consultant_definition_detail_id")->nullable()->change();
           
            // $table->unique("consultant_id");
            // $table->unique("student_id");
            // $table->unique("year_id");
            // $table->unique("consultant_definition_detail_id");
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultant_financials', function (Blueprint $table) {
            $table->foreignId("consultant_definition_detail_id")->nullable(false)->change();
            $table->dropUnique("distinc_unique");
            DB::statement("ALTER TABLE `consultant_financials` CHANGE `financial_status` `financial_status` ENUM('approved','pending','semi_approved') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved'");

          });
    }
};
