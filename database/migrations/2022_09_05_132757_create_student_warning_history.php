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
        Schema::create('student_warning_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id_creator');
            $table->integer('user_id_updator')->nullable();
            $table->integer('student_id');
            $table->integer('course_id')->nullable();
            $table->string('comment');  
            $table->enum('response',["noAction","done"])->default("noAction");  
            //$table->integer('student_warning_id')->nullable(); 
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
        Schema::dropIfExists('student_warning_histories');
    }
};
