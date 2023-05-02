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
        Schema::create('consultant_financials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_creator');
            $table->foreignId('branch_id')->nullable();
            $table->foreignId('consultant_id');            
            $table->foreignId('student_id');
            $table->foreignId('year_id')->nullable();
            $table->foreignId('consultant_definition_detail_id');
            $table->enum('manager_status',["approved","pending"])->default("pending");
            $table->enum('financial_status',["approved","pending","semi_approved"])->default("approved");
            $table->enum('student_status',["ok","refused","fired","financial_pending"])->default("ok");
            $table->enum('financial_refused_status',["not_returned","returned","noMoney"])->default("noMoney");
            $table->foreignId('user_id_manager')->nullable(); 
            $table->foreignId('user_id_financial')->nullable(); 
            $table->foreignId('user_id_student_status')->nullable(); 
            $table->string('description')->nullable();
            $table->timestamp('financial_status_updated_at')->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultant_financials');
    }
};
