<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Gates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_creator');
            $table->string('name')->unique();          
            $table->text('description');
            $table->timestamps();  
            $table->softDeletes();   
            $table->unique(array('user_id_creator','name'));       
        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::dropIfExists('gates');
    }
}
