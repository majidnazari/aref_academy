<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');            
            $table->integer('students_id'); 
            $table->integer('absence_presences_id'); 
            $table->enum('who_answered',['father','mother','other']);            
            $table->text('description');
            $table->boolean('is_called_successfull')->default(false);
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
        schema::dropIfExists('student_contacts');
    }
}
