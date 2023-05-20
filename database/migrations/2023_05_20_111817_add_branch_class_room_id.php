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
        Schema::table('consultant_definition_details', function (Blueprint $table) {
            $table->foreignId('branch_class_room_id')->after('student_id')->nullable();
            $table->dropColumn('branch_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultant_definition_details', function (Blueprint $table) {
            $table->dropColumn('branch_class_room_id');
            $table->foreignId('branch_id');

        });
    }
};
