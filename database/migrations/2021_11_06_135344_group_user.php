<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GroupUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_creator')->unsigned();
            $table->foreignId('user_id')->unsigned();
            $table->foreignId('group_id')->unsigned();
           // $table->foreignId('gate_id')->unsigned();
            $table->string('key');  
            $table->timestamps();  
            $table->softDeletes(); 
            $table->unique(['user_id','key','group_id']);         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::dropIfExists('group_user');
    }
}
