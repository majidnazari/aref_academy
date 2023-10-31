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
        Schema::table('consultant_definition_details', function (Blueprint $table) {
            $table->enum('consultant_status',['no_action','absent','present','dellay5','dellay10','dellay15','dellay15more'])->default('no_action')->after('student_status')->nullable();
            $table->enum('session_status',['no_action','earlier_5min_finished','earlier_10min_finished','earlier_15min_finished','earlier_15min_more_finished','later_5min_started','later_10min_started','later_15min_started','later_15min_more_started'])->default('no_action')->after('student_status')->nullable();
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
           $table->dropColumn('session_status');
           $table->dropColumn('consultant_status');
        });
    }
};
