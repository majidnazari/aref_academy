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
            $table->integer('Courses_id');            
            $table->integer('students_id');            
            $table->enum('status',['approved','pending']);            
            $table->integer('users_id_created');
            $table->integer('users_id_approved');
            $table->timestamps();            
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
