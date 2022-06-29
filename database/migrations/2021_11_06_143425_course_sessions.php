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
            $table->foreignId('user_id_creator');  
            $table->foreignId('course_id');            
            $table->string('name'); 
            $table->decimal('price'); 
            $table->boolean('special')->default(false); 
            $table->date('start_date');            
            $table->time('start_time'); 
            $table->time('end_time');            
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
        schema::dropIfExists('course_sessions');
    }
}
