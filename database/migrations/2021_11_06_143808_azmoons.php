<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Azmoons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azmoons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');            
            $table->foreignId('course_id');            
            $table->foreignId('session_id');            
            $table->boolean('isSMSsend')->default(false);            
            $table->string('score');                      
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
        schema::dropIfExists('azmoons');
    }
}