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
        Schema::table('absence_presences', function (Blueprint $table) {
            $table->enum('attendance_status',['online_to_present','free_for_one','free_for_two','guest','normal'])->default('normal')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absence_presences', function (Blueprint $table) {
            $table->dropColumn('attendance_status');
        });
    }
};
