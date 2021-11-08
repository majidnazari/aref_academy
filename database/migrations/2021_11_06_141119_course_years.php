<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseYears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_years', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');            
            $table->integer('courses_id');            
            $table->char('year',4);            
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
        schema::dropIfExists('course_years');
    }
    

}
