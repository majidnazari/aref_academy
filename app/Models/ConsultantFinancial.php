<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ConsultantFinancial extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        "id",
        "user_id_creator",
        "counsultant_id",
        "student_id",
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
    protected $table="consultant_financials"; 

    public function user()
    {
        return $this->belongsTo(User::class,"user_id_creator");
    }
    public function counsultant()
    {
        return $this->belongsTo(User::class,"counsultant_id");
    }
    public function manager()
    {
        return $this->belongsTo(User::class,"user_id_manager");
    }
    public function financial()
    {
        return $this->belongsTo(User::class,"user_id_financial");
    }   

}
