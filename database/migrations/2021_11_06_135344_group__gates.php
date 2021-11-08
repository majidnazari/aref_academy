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
            $table->integer('users_id');
            $table->integer('groups_id');
            $table->integer('gates_id');
            $table->string('name');  
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
        schema::dropIfExists('group_gates');
    }
}
