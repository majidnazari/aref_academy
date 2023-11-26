<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class StudentInfo extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "student_id",
        "first_name",
        "last_name",
        "nationality_code",
        "phone",
        "major",
        "egucation_level",
        "concours_year"
    ];
}
