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
        Schema::table('student_infos', function (Blueprint $table) {
            $table->renameColumn('egucation_level', 'education_level');
            $table->foreignId("user_id_creator")->after('id');
            $table->foreignId("user_id_editor")->after('user_id_creator')->nullable();
            $table->string("school_name")->after('user_id_editor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_infos', function (Blueprint $table) {
            $table->renameColumn('education_level','egucation_level' );
            $table->dropColumn("user_id_creator");
            $table->dropColumn("user_id_editor");
            $table->dropColumn("school_name");
        });
    }
};
