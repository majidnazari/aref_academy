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
        DB::statement("ALTER TABLE `absence_presences`  CHANGE `status` `status` ENUM('absent', 'present', 'dellay15','dellay30','dellay45','dellay60') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'absent'");
        // Schema::table('absence_presences', function (Blueprint $table) {
        //     //
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `absence_presences`  CHANGE `status` `status` ENUM('dellay', 'absent', 'present') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'absent'");
        // Schema::table('absence_presences', function (Blueprint $table) {
        //     //
        // });
    }
};
