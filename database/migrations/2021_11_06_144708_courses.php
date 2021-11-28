<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Courses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');     
            $table->integer('years_id');     
            $table->integer('teachers_id');       
            $table->string('name'); 
            $table->enum('lesson',['Mathematics','Physics','Biology']);            
            $table->enum('type',['public','private']);            
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
        schema::dropIfExists('courses');
    }
}
