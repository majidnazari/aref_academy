<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_warnings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id_creator');
            $table->integer('user_id_updator')->nullable();
            $table->integer('student_id');
            $table->integer('course_id')->nullable();
            $table->string('comment');  
            $table->integer('student_warning_history_id')->nullable();  
              
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
       Schema::dropIfExists('student_warnings');
    }
};
