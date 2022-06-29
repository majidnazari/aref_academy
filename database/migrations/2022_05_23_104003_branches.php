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
       Schema::create('branches',function(Blueprint $table){   //    نام کلاسهای هر یک از موارد برنچ ها
                $table->Increments('id');
                $table->foreignId('user_id_creator');
                $table->string('name');
                $table->timestamps();
                $table->softdeletes();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::dropIfExists('branches');
    }
};
