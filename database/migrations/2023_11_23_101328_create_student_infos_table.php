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
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("student_id")->uniqid();
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("nationality_code")->nullable();
            $table->string("phone")->nullable();
            $table->enum("major",["mathematics","experimental","humanities","art","other"])->nullable();
            $table->enum("egucation_level",['6','7','8','9','10','11','12','13','14'])->nullable();
            $table->string("concours_year")->nullable();
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
        Schema::dropIfExists('student_infos');
    }
};
