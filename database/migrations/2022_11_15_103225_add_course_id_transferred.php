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
        Schema::table('course_students', function (Blueprint $table) {
            $table->integer("transferred_to_course_id")->after("financial_refused_status")->nullable();
            $table->timestamp("financial_status_updated_at")->after("updated_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_students', function (Blueprint $table) {
            $table->dropColumn("transferred_to_course_id");
            $table->dropColumn("financial_status_updated_at");
        });
    }
};
