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
            $table->foreignId('user_id_creator');     
            $table->foreignId('year_id');     
            $table->foreignId('teacher_id');       
            $table->string('name'); 
            $table->enum('lesson',['Mathematics','Physics','Biology'])->default('Mathematics');            
            $table->enum('education_level',['1','2','3','4','5','6','7','8','9','10','11','12','13','14']);            
            $table->enum('type',['public','private'])->default('public');            
            $table->enum('financial_status',['approved','pending'])->default('pending');
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
        schema::dropIfExists('courses');
    }
}
