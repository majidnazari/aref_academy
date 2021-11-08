<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');            
            $table->integer('courses_id');            
            $table->date('start_date');            
            $table->time('start_time'); 
            $table->time('end_time');            
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
        schema::dropIfExists('course_sessions');
    }
}
