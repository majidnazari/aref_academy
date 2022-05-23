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
        Schema::create('branch_class_rooms',function(Blueprint $table){ // نام مدرسه - آموزشگاه - یا مرکز مشاوره
            $table->Increments('id');
            $table->foreignId("branch_id");
            $table->string("name");
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['branch_id','name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::dropIfExists('branch_class_rooms');
    }
};
