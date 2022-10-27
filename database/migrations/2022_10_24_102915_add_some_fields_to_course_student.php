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
        Schema::table('course_students', function (Blueprint $table) {
            $table->integer('total_absent')->after('user_id_student_status')->nullable();
            $table->integer('total_present')->after('user_id_student_status')->nullable();
            $table->integer('total_dellay15')->after('user_id_student_status')->nullable();
            $table->integer('total_dellay30')->after('user_id_student_status')->nullable();
            $table->integer('total_dellay45')->after('user_id_student_status')->nullable();
            $table->integer('total_dellay60')->after('user_id_student_status')->nullable();
            $table->integer('total_noAction')->after('user_id_student_status')->nullable();
            $table->integer('total_not_registered')->after('user_id_student_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_students', function (Blueprint $table) {
            $table->dropColumn('total_absent');
            $table->dropColumn('total_present');
            $table->dropColumn('total_dellay15');
            $table->dropColumn('total_dellay30');
            $table->dropColumn('total_dellay45');
            $table->dropColumn('total_dellay60');
            $table->dropColumn('total_noAction');
            $table->dropColumn('total_not_registered');
        });
    }
};
