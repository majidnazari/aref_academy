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
        if(Schema::hasColumn('student_warning_histories','user_id_updator'))
        {
            Schema::table('student_warning_histories', function (Blueprint $table) {
                $table->renameColumn('user_id_updator','user_id_updater');
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_warning_histories', function (Blueprint $table) {
            //
        });
    }
};
