<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;


class ConsultantReport extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        "id",
        
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
}
