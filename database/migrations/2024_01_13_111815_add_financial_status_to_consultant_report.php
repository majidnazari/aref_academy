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
        Schema::table('consultant_reports', function (Blueprint $table) {
            $table->integer("sum_all_approved_financial_status")->after("sum_all_students")->nullable(); 
            $table->integer("sum_all_semi_approved_financial_status")->after("sum_all_approved_financial_status")->nullable(); 
            $table->integer("sum_all_pending_financial_status")->after("sum_all_semi_approved_financial_status")->nullable(); 
            $table->integer("sum_all_refused_student_status")->after("sum_all_pending_financial_status")->nullable(); 
            $table->integer("sum_all_fired_student_status")->after("sum_all_refused_student_status")->nullable(); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultant_reports', function (Blueprint $table) {
            $table->dropColumn('sum_all_approved_financial_status');
            $table->dropColumn('sum_all_semi_approved_financial_status');
            $table->dropColumn('sum_all_pending_financial_status');
            $table->dropColumn('sum_all_refused_student_status');
            $table->dropColumn('sum_all_fired_student_status');
        });
    }
};
