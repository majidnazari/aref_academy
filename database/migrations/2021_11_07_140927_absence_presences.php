<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AbsencePresences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence_presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');            
            $table->integer('course_sessions_id');            
            $table->integer('teachers_id'); 
            $table->enum('status',['dellay','absent','present'])->default('absent');    
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
        schema::dropIfExists('absence_presences');
    }
}
