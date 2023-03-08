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
        Schema::table('student_contacts', function (Blueprint $table) {
            $table->dropColumn('student_id');
            $table->string('reason_absence')->after("user_id_creator")->nullable();
            $table->string('description')->nullable()->change();
            $table->boolean('is_called_successfull')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_contacts', function (Blueprint $table) {
            $table->integer('student_id')->after('user_id_creator');
            $table->dropColumn('reason_absence');
            $table->string('description')->nullable(false)->change();
            $table->boolean('is_called_successfull')->nullable(false)->change();
        });
    }
};
