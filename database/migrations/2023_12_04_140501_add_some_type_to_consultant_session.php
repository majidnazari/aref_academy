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
            $table->boolean('remote')->after('session_status')->default(false);
            $table->boolean('single_meet')->after('session_status')->default(false);
            $table->boolean('compensatory_meet')->after('session_status')->default(false);
            $table->foreignId('user_id_student_status')->after('student_status')->nullable();
            $table->timestamp('student_status_updated_at')->after('user_id_student_status')->nullable();
            $table->bigInteger('compensatory_of_definition_detail_id')->after('id')->nullable();
            $table->bigInteger('compensatory_for_definition_detail_id')->after('student_status')->nullable();
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
            $table->dropColumn('remote');
            $table->dropColumn('single_meet');
            $table->dropColumn('compensatory_meet');
            $table->dropColumn('user_id_student_status');
            $table->dropColumn('student_status_updated_at');
            $table->dropColumn('compensatory_of_definition_detail_id');
            $table->dropColumn('compensatory_for_definition_detail_id');
        });
    }
};
