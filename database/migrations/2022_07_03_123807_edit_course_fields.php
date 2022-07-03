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
        Schema::table('courses', function (Blueprint $table) {
           $table->dropColumn('lesson');
           $table->integer('branch_id')->after('user_id_creator');
           $table->integer('lesson_id')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->enum('lesson',['Mathematics','Physics','Biology'])->default('Mathematics');
            $table->dropColumn('branch_id');
            $table->dropColumn('lesson_id');
        });
    }
};
