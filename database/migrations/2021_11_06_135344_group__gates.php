<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GroupGates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_gates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_created')->unsigned();
            $table->foreignId('user_id')->unsigned();
            $table->foreignId('group_id')->unsigned();
            $table->foreignId('gate_id')->unsigned();
           // $table->string('name');  
            $table->timestamps();  
            $table->softDeletes(); 
            $table->unique(['user_id','group_id','gate_id']);         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::dropIfExists('group_gates');
    }
}
