<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AbsencePresence;
use OwenIt\Auditing\Contracts\Auditable;

class StudentContact extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;
    protected $table = 'student_contacts';
    protected $fillable = [
        "user_id_creator",
        "reason_absence",
        "absence_presence_id",
        "who_answered",
        "description",
        "is_called_successfull",

    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id_creator');
    }
    public function absencepresence()
    {
        return $this->belongsTo(AbsencePresence::class, "absence_presence_id");
    }
}
