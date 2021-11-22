<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('type',["admin","manager","financial","acceptor"])->default("acceptor");
            $table->string('mobile')->unique();
            $table->string('email')->unique();
           // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('first_name')->string(20);
            $table->string('last_name')->string(30);
            //$table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
