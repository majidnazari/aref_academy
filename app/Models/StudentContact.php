<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AbsencePresence;

class StudentContact extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='student_contacts';
    protected $fillable=[
        "user_id",
        "student_id",
        "absence_presence_id",
        "who_answered",
        "description",
        "is_called_successfull",
        
    ];
    public function User()
    {
        return $this->blongsTo('user');
    }
    public function student()
    {
        return $this->hasmany('student');
    }
    public function absencepresence()
    {
        return $this->hasmany(AbsencePresence::class);
    }  
}
