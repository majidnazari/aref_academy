<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        // Schema::table('consultant_definition_details', function (Blueprint $table) {
        //     //$table->enum('type', ['contract', 'permanent', 'partial'])->change();
        //     $table->enum('consultant_status',['no_action','absent','present','dellay5','dellay10','dellay15','dellay15more'])->default('present')->after('student_status')->nullable()->change();
        // });

        DB::statement("ALTER TABLE `consultant_definition_details`  CHANGE `consultant_status` `consultant_status` ENUM('no_action','absent','present','dellay5','dellay10','dellay15','dellay15more') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'present'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('consultant_definition_details', function (Blueprint $table) {
        //     $table->enum('consultant_status',['no_action','absent','present','dellay5','dellay10','dellay15','dellay15more'])->default('no_action')->after('student_status')->nullable()->change();
        // });
        DB::statement("ALTER TABLE `consultant_definition_details`  CHANGE `consultant_status` `consultant_status` ENUM('no_action','absent','present','dellay5','dellay10','dellay15','dellay15more') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_action'");
    }
};
