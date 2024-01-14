<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ConsultantReport;
use Carbon\Carbon;
use Log;

class ConsultantFinancial extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
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
    protected $table = "consultant_financials";

    public function user()
    {
        return $this->belongsTo(User::class, "user_id_creator")->withTrashed();
    }
    public function consultant()
    {
        return $this->belongsTo(User::class, "consultant_id")->withTrashed();
    }
    public function manager()
    {
        return $this->belongsTo(User::class, "user_id_manager")->withTrashed();
    }
    public function financial()
    {
        return $this->belongsTo(User::class, "user_id_financial")->withTrashed();
    }
    public function userStudentStatus()
    {
        return $this->belongsTo(User::class, "user_id_student_status")->withTrashed();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, "branch_id")->withTrashed();
    }
    public function year()
    {
        return $this->belongsTo(Year::class, "year_id")->withTrashed();
    }
    public function consultantDefinitionDetails()
    {
        return $this->belongsTo(ConsultantDefinitionDetail::class, "consultant_definition_detail_id");
    }

    public function definitionDetail()
    {
        return $this->belongsTo(ConsultantDefinitionDetail::class, 'student_id', 'student_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($consultantFinancial) {
            $today = Carbon::now()->format("Y-m-d");
            $firstDayOfMonth = Carbon::parse($today)->startOfMonth(); // First day of the Shamsi month
            $lastDayOfMonth = Carbon::parse($today)->endOfMonth(); // Last day of the Shamsi month

            $consultant_exististance = ConsultantReport::where('statical_date', $today)
                ->where('consultant_id', $consultantFinancial->consultant_id)
                ->first();
            if ($consultant_exististance) {
                //Log::info("the ConsultantReport today shoudlb be updated is: " . json_encode($consultant_exististance));
                $consultant_exististance["sum_all_students"] += 1;
                $consultant_exististance["sum_all_approved_financial_status"] += $consultantFinancial->financial_status === "approved" ? 1 : 0;
                $consultant_exististance["sum_all_semi_approved_financial_status"] += $consultantFinancial->financial_status === "semi_approved" ? 1 : 0;
                $consultant_exististance["sum_all_pending_financial_status"] += $consultantFinancial->financial_status === "pending" ? 1 : 0;

                $consultant_exististance->save();

                //$consultant_exististance["sum_all_pending_financial_status"] += $consultantFinancial->financial_status === "pending" ? 1 : 0;
            } else {  
                //create at the first time in new day
                // Create consultantReport here
                $consultantReport = new ConsultantReport;
                $consultantReport->consultant_id = $consultantFinancial->consultant_id;
                $consultantReport->year_id = $consultantFinancial->year_id;
                $consultantReport->sum_all_students = 1;
                $consultantReport->sum_all_approved_financial_status =  $consultantFinancial->financial_status === "approved" ? 1 : 0;
                $consultantReport->sum_all_semi_approved_financial_status =  $consultantFinancial->financial_status === "semi_approved" ? 1 : 0;
                $consultantReport->sum_all_pending_financial_status =  $consultantFinancial->financial_status === "pending" ? 1 : 0;
                $consultantReport->statical_date =  $today;
                // Set other fields as needed
                //Log::info("the ConsultantReport is: " . json_encode($consultantReport));
                //Log::info("the today is: " . json_encode($today) . " and first is: " . $firstDayOfMonth . " and end is:" . $lastDayOfMonth);
                $consultantReport->save();
            }
        });

        static::updated(function ($consultantFinancial) {
            $today = Carbon::now()->format("Y-m-d");           

            $consultant_exististance = ConsultantReport::where('statical_date', $today)
                ->where('consultant_id', $consultantFinancial->consultant_id)
                ->first();
            if ($consultant_exististance) {
               
                $consultant_exististance["sum_all_approved_financial_status"] += $consultant_exististance->financial_status === "approved" ? 1 : 0;;
                $consultant_exististance["sum_all_semi_approved_financial_status"] += $consultantFinancial->financial_status === "semi_approved" ? 1 : 0;
                $consultant_exististance["sum_all_pending_financial_status"] += $consultantFinancial->financial_status === "pending" ? 1 : 0;

                $consultant_exististance["sum_all_refused_student_status"] += $consultantFinancial->student_status === "refused" ? 1 : 0;
                $consultant_exististance["sum_all_fired_student_status"] += $consultantFinancial->student_status === "fired" ? 1 : 0;

                
                $consultant_exististance->save();

                //$consultant_exististance["sum_all_pending_financial_status"] += $consultantFinancial->financial_status === "pending" ? 1 : 0;
            } else {  
                //create at the first time in new day
                // Create consultantReport here
                $consultantReport = new ConsultantReport;
                $consultantReport->consultant_id = $consultantFinancial->consultant_id;
                $consultantReport->year_id = $consultantFinancial->year_id;
               
                $consultantReport->sum_all_approved_financial_status =  $consultantFinancial->financial_status === "approved" ? 1 : 0;
                $consultantReport->sum_all_semi_approved_financial_status =  $consultantFinancial->financial_status === "semi_approved" ? 1 : 0;
                $consultantReport->sum_all_pending_financial_status =  $consultantFinancial->financial_status === "pending" ? 1 : 0;

                $consultantReport->sum_all_refused_student_status =  $consultantFinancial->student_status === "refused" ? 1 : 0;
                $consultantReport->sum_all_fired_student_status =  $consultantFinancial->student_status === "fired" ? 1 : 0;

                $consultantReport->statical_date =  $today;
                // Set other fields as needed
               // Log::info("the ConsultantReport is: " . json_encode($consultantReport));
                //Log::info("the today is: " . json_encode($today) . " and first is: " . $firstDayOfMonth . " and end is:" . $lastDayOfMonth);
                $consultantReport->save();
            }
            
        });

        static::deleted(function ($consultantFinancial) {
            // Perform actions after the model is deleted
            // You can add your own code here
            // For example:
            //Log::info('Model deleted: ' . json_encode($consultantFinancial));
        });
    }
}
