<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;


class ConsultantReport extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "id",
        "consultant_id",
        "year_id",
        "sum_students_registered",
        "sum_students_major_humanities",

        "sum_students_major_experimental",
        "sum_students_major_mathematics",
        "sum_students_major_art",
        "sum_students_major_other",
        "sum_students_education_level_6",
        "sum_students_education_level_7",
        "sum_students_education_level_8",
        "sum_students_education_level_9",
        "sum_students_education_level_10",
        "sum_students_education_level_11",
        "sum_students_education_level_12",
        "sum_students_education_level_13",
        "sum_students_education_level_14",

        "sum_is_filled_consultant_session",
        "sum_is_defined_consultant_session",

        "sum_student_status_absent",
        "sum_student_status_present",
        "sum_student_status_no_action",
        "sum_student_status_dellay5",
        "sum_student_status_dellay10",
        "sum_student_status_dellay15",
        "sum_student_status_dellay15more",
        "sum_session_status_no_action",

        "sum_session_status_earlier_5min_finished",
        "sum_session_status_earlier_10min_finished",
        "sum_session_status_earlier_15min_finished",
        "sum_session_status_earlier_15min_more_finished",
        "sum_session_status_later_5min_started",
        "sum_session_status_later_10min_started",
        "sum_session_status_later_15min_started",
        "sum_session_status_later_15min_more_started",
        "sum_consultant_status_no_action",
        "sum_consultant_status_absent",

        "sum_consultant_status_present",
        "sum_consultant_status_dellay5",
        "sum_consultant_status_dellay10",
        "sum_consultant_status_dellay15",
        "sum_consultant_status_dellay15more",

        "sum_compensatory_meet_1",
        "sum_compensatory_meet_0",
        "sum_single_meet_1",
        "sum_single_meet_0",
        "sum_remote_1",
        "sum_remote_0",

        "sum_financial_manager_status_approved",
        "sum_financial_manager_status_pending",
        "sum_financial_financial_status_approved",
        "sum_financial_financial_status_pending",
        "sum_financial_financial_status_semi_approved",
        "sum_financial_student_status_ok",
        "sum_financial_student_status_refused",
        "sum_financial_student_status_fired",
        "sum_financial_student_status_financial_pending",
        "sum_financial_student_status_fire_pending",
        "sum_financial_student_status_refuse_pending",
        "sum_financial_financial_refused_status_not_returned",
        "sum_financial_financial_refused_status_returned",
        "sum_financial_financial_refused_status_noMoney",

        "statical_date",

    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($consultantReport) {
    //         // Perform operations before the model is created
    //         // You can add your own code here
    //         // For example:
    //         // if ($modelB->field1 === 'someValue') { ... }
    //         // $modelB->field2 = 'newValue';
    //         Log::info("during creating in ConsultantReport:" . json_encode($consultantReport));
    //     });
    //     static::updating(function ($consultantReport) {
    //         // Perform operations before the model is created
    //         // You can add your own code here
    //         // For example:
    //         // if ($modelB->field1 === 'someValue') { ... }
    //         // $modelB->field2 = 'newValue';
    //         Log::info("during updating in ConsultantReport:" . json_encode($consultantReport));
    //     });
    // }
}
