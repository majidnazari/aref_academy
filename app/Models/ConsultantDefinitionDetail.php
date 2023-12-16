<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantDefinitionDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable =
    [
        "compensatory_of_definition_detail_id",
        "consultant_id",
        "student_id",
        "branch_class_room_id",
        "branch_id",
        "consultant_test_id",
        "user_id",
        "start_hour",
        "end_hour",
        "session_date",
        "step",
        "student_status",
        "copy_to_next_week",
        "user_id_student_status",
        "student_status_updated_at",
        "consultant_status",
        "compensatory_for_definition_detail_id",

        "session_status",
        "compensatory_meet",
        "single_meet",
        "remote",
        "absent_present_description",
        "test_description"
    ];

    public function consultant()
    {
        return $this->belongsTo(User::class, "consultant_id")->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id")->withTrashed();
    }

    public function branchClassRoom()
    {
        return $this->belongsTo(BranchClassRoom::class, "branch_class_room_id")->withTrashed();
    }
    public function userStudentStatus()
    {
        return $this->belongsTo(User::class, "user_id_student_status")->withTrashed();;
    }
    public function compensatoryOfDefinitionDetail()
    {
        return $this->belongsTo(ConsultantDefinitionDetail::class, "compensatory_of_definition_detail_id");
    }
    
}
