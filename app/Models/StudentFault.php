<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AbsencePresence;

class StudentFault extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='student_faults';
    protected $fillable=[
        "user_id",
        "student_id",
        "fault_id"       
        
    ];
    public function user()
    {
        return $this->belongsTo('user');
    }
    public function student()
    {
        return $this->hasmany('student');
    }
    public function fault()
    {
        return $this->hasmany('fault');
    }
}
