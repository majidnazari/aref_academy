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
        Schema::table('users', function (Blueprint $table) {
            //$table->integer("branch_id")->unsigned()->index()->after("user_id_creator");           
            //$table->index("branch_id")->after("user_id_creator");   
            // $table->unsignedBigInteger('branch_id'); 
            // $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');  
            
            $table->integer('branch_id')->after('group_id')->unsigned()->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->nullOnDelete();
            //
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            // laravel assumes star_id is the foreign key name
           

            // laravel builds the foreign key name itself e.g. packages_star_id_foreign
           // $table->dropForeign(['branch_id']);

            // $table->dropIndex('users_branch_id_index');
             $table->dropForeign('users_branch_id_foreign');
             $table->dropColumn('branch_id'); 
             
            // $table->dropColumn('branch_id');
            //$table->dropColumn("branch_id");
        });
    }
};
