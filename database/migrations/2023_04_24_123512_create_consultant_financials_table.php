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
            $table->foreignId('counsultant_id');            
            $table->foreignId('student_id');
            $table->enum('manager_status',["approved","pending"])->default("pending");
            $table->enum('financial_status',["approved","pending","semi_approved"])->default("approved");
            $table->enum('student_status',["ok","refused","fired","financial_pending"])->default("ok");
            $table->enum('financial_refused_status',["not_returned","returned","noMoney"])->default("noMoney");
            $table->foreignId('user_id_manager');
            $table->foreignId('user_id_financial');
            $table->foreignId('user_id_student_status');
            $table->string('description');
            $table->timestamp('financial_status_updated_at'); 
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
