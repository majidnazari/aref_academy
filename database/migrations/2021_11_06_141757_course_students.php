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
            $table->foreignId('course_id');            
            $table->foreignId('student_id');            
            $table->enum('status_manager',['approved','pending'])->default('pending');            
            $table->enum('status_financial',['approved','pending'])->default('pending');            
            $table->foreignId('user_id_manager');
            $table->foreignId('user_id_financial');
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
