<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AzmoonResult extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "student_id",
        "result_score"              
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,"student_id");
    }
}
