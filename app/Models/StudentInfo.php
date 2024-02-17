<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ConsultantReport;
use Carbon\Carbon;
use Log;


class StudentInfo extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "user_id_creator",
        "user_id_editor",
        "school_name",
        "student_id",
        "first_name",
        "last_name",
        "nationality_code",
        "phone",
        "major",
        "education_level",
        "concours_year"
    ];

    public function UserCreator()
    {
        return $this->belongsTo(User::class, 'user_id_creator')->withTrashed();
    }

    public function UserEditor()
    {
        return $this->belongsTo(User::class, 'user_id_editor')->withTrashed();
    }
    
}
