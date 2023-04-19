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

    protected $fillable=
    [
        "consultant_id",
        "student_id",
        "branch_id",
        "consultant_test_id",
        "user_id",
        "start_hour",
        "end_hour",
        "session_date",
        "step",
        "student_status",
        "absent_present_description",
        "test_description"
    ];

    public function consultant()
    {
        return $this->belongsTo(User::class,"consultant_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,"branch_id");
    }
    // public function consultantTest()
    // {
    //     return $this->belongsTo(User::class,"user_id");
    // }

}
