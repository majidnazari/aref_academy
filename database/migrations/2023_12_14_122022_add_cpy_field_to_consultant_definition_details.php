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
            $table->boolean('copy_to_next_week')->after('student_status')->default(false);

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
            $table->dropColumn('copy_to_next_week');
        });
    }
};
