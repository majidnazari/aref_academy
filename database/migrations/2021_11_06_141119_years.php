<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Years extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_creator');
            $table->string('name')->unique();            
            $table->boolean('active')->default(false);            
            //$table->char('year',4)->nullable();            
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
        schema::dropIfExists('years');
    }
    

}
