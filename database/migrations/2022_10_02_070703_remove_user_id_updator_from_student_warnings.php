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
        if(Schema::hasColumn('student_warnings','user_id_updator')){
            Schema::table('student_warnings', function (Blueprint $table) {
                $table->dropColumn('user_id_updator');
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
        if(!Schema::hasColumn('student_warnings','user_id_updator')){
            Schema::table('student_warnings', function (Blueprint $table) {
                $table->integer('user_id_updator')->nullable();
            });
        }
    }
};
