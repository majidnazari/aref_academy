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
        Schema::create('consultant_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId("consultant_id");
            $table->foreignId("year_id");

            $table->bigInteger("sum_all_students")->nullable(); 
            $table->bigInteger("sum_all_humanities_students")->nullable(); 
            $table->bigInteger("sum_all_experimental_students")->nullable();  
            $table->bigInteger("sum_all_mathematics_students")->nullable();  
            $table->bigInteger("sum_all_art_students")->nullable();  
            $table->bigInteger("sum_all_other_students")->nullable();  

            $table->bigInteger("sum_all_education_level_6_students")->nullable(); 
            $table->bigInteger("sum_all_education_level_7_students")->nullable();  
            $table->bigInteger("sum_all_education_level_8_students")->nullable();  
            $table->bigInteger("sum_all_education_level_9_students")->nullable();  
            $table->bigInteger("sum_all_education_level_10_students")->nullable(); 
            $table->bigInteger("sum_all_education_level_11_students")->nullable(); 
            $table->bigInteger("sum_all_education_level_12_students")->nullable(); 
            $table->bigInteger("sum_all_education_level_13_students")->nullable(); 
            $table->bigInteger("sum_all_education_level_14_students")->nullable(); 

            $table->bigInteger("sum_all_consultant_duty_session")->nullable();
            $table->bigInteger("sum_all_consultant_absent_session")->nullable();
            $table->bigInteger("sum_all_consultant_present_session")->nullable();
            $table->bigInteger("sum_all_consultant_attendance_session")->nullable();
            $table->bigInteger("sum_all_consultant_non_attendance_session")->nullable();
            $table->bigInteger("sum_all_consultant_compensation_session")->nullable();
            $table->bigInteger("sum_all_time_dellay_in_minutes")->nullable();
            $table->bigInteger("sum_all_time_earlier_in_minutes")->nullable();
            $table->date("statical_date");             

            $table->timestamps();
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultant_reports');
    }
};
