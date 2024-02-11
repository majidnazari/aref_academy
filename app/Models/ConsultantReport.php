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


        "sum_student_status_absent",
        "sum_student_status_present",

        "user_id_creator",
        "consultant_id",
        "student_id",
        "branch_id",
        "year_id",
        "consultant_definition_detail_id",
        "manager_status",
        "financial_status",
        "student_status",
        "financial_refused_status",
        "user_id_manager",
        "user_id_financial",
        "user_id_student_status",
        "description",
        "financial_status_updated_at"
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
