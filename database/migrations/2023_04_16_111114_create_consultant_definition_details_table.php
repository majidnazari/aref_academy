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
        Schema::create('consultant_definition_details', function (Blueprint $table) {
            $table->id();
            $table->integer('consultant_id');
            $table->integer('student_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('consultant_test_id')->nullable();
            $table->integer('user_id');
            $table->string('start_hour');
            $table->string('end_hour');
            $table->integer('step');
            $table->date('session_date');
            $table->enum('student_status',['absent','present','no_action'])->default('no_action');
            $table->string('absent_present_description')->nullable();
            $table->string('test_description')->nullable();
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
        Schema::dropIfExists('consultant_definition_details');
    }
};
