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
    protected $table="consultant_financials"; 

    public function user()
    {
        return $this->belongsTo(User::class,"user_id_creator");
    }
    public function consultant()
    {
        return $this->belongsTo(User::class,"consultant_id");
    }
    public function manager()
    {
        return $this->belongsTo(User::class,"user_id_manager");
    }
    public function financial()
    {
        return $this->belongsTo(User::class,"user_id_financial");
    }   
    public function branch()
    {
        return $this->belongsTo(Branch::class,"branch_id");
    }   
    public function year()
    {
        return $this->belongsTo(Year::class,"year_id");
    } 
    public function consultantDefinitionDetails()
    {
        return $this->belongsTo(ConsultantDefinitionDetail::class,"consultant_definition_detail_id");
    }   

}
