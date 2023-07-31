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
            //$table->dropIndex('distinc_unique');
            $table->dropUnique("distinc_unique");
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
           $table->unique(["branch_id","consultant_id","student_id","year_id","consultant_definition_detail_id"],"distinc_unique");
        });
    }
};
