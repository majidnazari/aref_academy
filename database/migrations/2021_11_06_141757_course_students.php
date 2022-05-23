<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_creator');            
            $table->foreignId('course_id');            
            $table->foreignId('student_id');            
            $table->enum('manager_status',['approved','pending'])->default('pending');            
            $table->enum('financial_status',['approved','pending'])->default('pending');            
            $table->enum('student_status',['ok','refused','fired'])->default('ok');            
            $table->foreignId('user_id_manager');
            $table->foreignId('user_id_financial');
            $table->foreignId('user_id_student_status');
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
        schema::dropIfExists('course_students');
    }
}
