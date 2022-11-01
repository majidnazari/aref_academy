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
            $table->integer('total_session')->after('user_id_financial')->nullable();
            $table->integer('total_done_session')->after('user_id_financial')->nullable();
            $table->integer('total_remain_session')->after('user_id_financial')->nullable();

            $table->integer('sum_absent_session')->after('user_id_financial')->nullable();
            $table->integer('sum_present_session')->after('user_id_financial')->nullable();
            $table->integer('sum_dellay15_session')->after('user_id_financial')->nullable();
            $table->integer('sum_dellay30_session')->after('user_id_financial')->nullable();
            $table->integer('sum_dellay45_session')->after('user_id_financial')->nullable();
            $table->integer('sum_dellay60_session')->after('user_id_financial')->nullable();
            $table->integer('sum_noAction_session')->after('user_id_financial')->nullable();
            $table->integer('sum_not_registered_session')->after('user_id_financial')->nullable();
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
            $table->dropColumn('total_session');
            $table->dropColumn('total_done_session');
            $table->dropColumn('total_remain_session');
            $table->dropColumn('avg_absent_session');
            $table->dropColumn('avg_present_session');
            $table->dropColumn('avg_dellay15_session');
            $table->dropColumn('avg_dellay30_session');
            $table->dropColumn('avg_dellay45_session');
            $table->dropColumn('avg_dellay60_session');
            $table->dropColumn('avg_noAction_session');
            $table->dropColumn('avg_not_registered_session');
        });
    }
};
