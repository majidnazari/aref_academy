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
        Schema::dropIfExists('consultant_reports');
        Schema::create('consultant_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId("consultant_id");
            $table->foreignId("year_id");

            #region student info
                $table->smallInteger("sum_students_registered")->nullable();

                $table->smallInteger("sum_students_major_humanities")->nullable();
                $table->smallInteger("sum_students_major_experimental")->nullable();
                $table->smallInteger("sum_students_major_mathematics")->nullable();
                $table->smallInteger("sum_students_major_art")->nullable();
                $table->smallInteger("sum_students_major_other")->nullable();

                $table->smallInteger("sum_students_education_level_6")->nullable();
                $table->smallInteger("sum_students_education_level_7")->nullable();
                $table->smallInteger("sum_students_education_level_8")->nullable();
                $table->smallInteger("sum_students_education_level_9")->nullable();
                $table->smallInteger("sum_students_education_level_10")->nullable();
                $table->smallInteger("sum_students_education_level_11")->nullable();
                $table->smallInteger("sum_students_education_level_12")->nullable();
                $table->smallInteger("sum_students_education_level_13")->nullable();
                $table->smallInteger("sum_students_education_level_14")->nullable();
            #end region
            #region consultant definition detail

                $table->smallInteger("sum_consultant_duty_session")->nullable();

                $table->smallInteger("sum_student_status_absent")->nullable();
                $table->smallInteger("sum_student_status_present")->nullable();
                $table->smallInteger("sum_student_status_no_action")->nullable();
                $table->smallInteger("sum_student_status_dellay5")->nullable();
                $table->smallInteger("sum_student_status_dellay10")->nullable();
                $table->smallInteger("sum_student_status_dellay15")->nullable();
                $table->smallInteger("sum_student_status_dellay15more")->nullable();

                $table->smallInteger("sum_session_status_no_action")->nullable();
                $table->smallInteger("sum_session_status_earlier_5min_finished")->nullable();
                $table->smallInteger("sum_session_status_earlier_10min_finished")->nullable();
                $table->smallInteger("sum_session_status_earlier_15min_finished")->nullable();
                $table->smallInteger("sum_session_status_earlier_15min_more_finished")->nullable();
                $table->smallInteger("sum_session_status_later_5min_started")->nullable();
                $table->smallInteger("sum_session_status_later_10min_started")->nullable();
                $table->smallInteger("sum_session_status_later_15min_started")->nullable();
                $table->smallInteger("sum_session_status_later_15min_more_started")->nullable();

                $table->smallInteger("sum_consultant_status_no_action")->nullable();
                $table->smallInteger("sum_consultant_status_absent")->nullable();
                $table->smallInteger("sum_consultant_status_present")->nullable();
                $table->smallInteger("sum_consultant_status_dellay5")->nullable();
                $table->smallInteger("sum_consultant_status_dellay10")->nullable();
                $table->smallInteger("sum_consultant_status_dellay15")->nullable();
                $table->smallInteger("sum_consultant_status_dellay15more")->nullable();

                $table->smallInteger("sum_compensatory_meet_1")->nullable();
                $table->smallInteger("sum_compensatory_meet_0")->nullable();
                $table->smallInteger("sum_single_meet_1")->nullable();
                $table->smallInteger("sum_single_meet_0")->nullable();
                $table->smallInteger("sum_remote_1")->nullable();
                $table->smallInteger("sum_remote_0")->nullable(); 
                
            #end region
            # region consultant finanacial
                $table->smallInteger("sum_financial_manager_status_approved")->nullable();
                $table->smallInteger("sum_financial_manager_status_pending")->nullable();

                $table->smallInteger("sum_financial_financial_status_approved")->nullable();
                $table->smallInteger("sum_financial_financial_status_pending")->nullable();
                $table->smallInteger("sum_financial_financial_status_semi_approved")->nullable();

                $table->smallInteger("sum_financial_student_status_ok")->nullable();
                $table->smallInteger("sum_financial_student_status_refused")->nullable();
                $table->smallInteger("sum_financial_student_status_fired")->nullable();
                $table->smallInteger("sum_financial_student_status_financial_pending")->nullable();
                $table->smallInteger("sum_financial_student_status_fire_pending")->nullable();
                $table->smallInteger("sum_financial_student_status_refuse_pending")->nullable();

                $table->smallInteger("sum_financial_financial_refused_status_not_returned")->nullable();
                $table->smallInteger("sum_financial_financial_refused_status_returned")->nullable();
                $table->smallInteger("sum_financial_financial_refused_status_noMoney")->nullable();

            #end region            
            
            $table->date("statical_date");

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
        Schema::dropIfExists('consultant_reports');
    }
};
