<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

use Log;

class ConsultantDefinitionDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;    

    protected $fillable =
    [
        "compensatory_of_definition_detail_id",
        "consultant_id",
        "student_id",
        "branch_class_room_id",
        "branch_id",
        "consultant_test_id",
        "user_id",
        "start_hour",
        "end_hour",
        "session_date",
        "step",
        "student_status",
        "copy_to_next_week",
        "user_id_student_status",
        "student_status_updated_at",
        "consultant_status",
        "compensatory_for_definition_detail_id",

        "session_status",
        "compensatory_meet",
        "single_meet",
        "remote",
        "absent_present_description",
        "test_description"
    ];

    public function consultant()
    {
        return $this->belongsTo(User::class, "consultant_id")->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id")->withTrashed();
    }

    public function branchClassRoom()
    {
        return $this->belongsTo(BranchClassRoom::class, "branch_class_room_id")->withTrashed();
    }
    public function userStudentStatus()
    {
        return $this->belongsTo(User::class, "user_id_student_status")->withTrashed();;
    }
    public function compensatoryOfDefinitionDetail()
    {
        return $this->belongsTo(ConsultantDefinitionDetail::class, "compensatory_of_definition_detail_id");
    }
    public function financial()
    {
        //Log::info("the this is : ". json_encode($this));
        return $this->hasOne(ConsultantFinancial::class,'student_id', 'student_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($consultantDefinitionDetail) {

            $today = Carbon::now()->format("Y-m-d");
            $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
            ->where('consultant_id', $consultantDefinitionDetail->consultant_id)
            ->first();
            $student_info=Student_info::where("student_id",$consultantDefinitionDetail->student_id)->first();
            if($consultant_report_exististance ){

                $consultant_report_exististance["sum_all_consultant_duty_session"] += $consultantDefinitionDetail->id ? 1 :0;

                $consultant_report_exististance->save();

            }
            else{
                $consultant_report_exististance = new ConsultantReport;
                $consultant_report_exististance->consultant_id=$consultantDefinitionDetail->consultant_id;
                $consultant_report_exististance->year_id=$consultantDefinitionDetail->year_id;
                $consultant_report_exististance->sum_all_consultant_duty_session +=1;

                $consultant_report_exististance->save();

            }
            
        });


        static::updated(function ($consultantDefinitionDetail) {

            $today = Carbon::now()->format("Y-m-d");
            $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
            ->where('consultant_id', $consultantDefinitionDetail->consultant_id)
            ->first();
            $student_info=Student_info::where("student_id",$consultantDefinitionDetail->student_id)->first();
            if($consultant_report_exististance ){

                $consultant_report_exististance["sum_all_humanities_students"] += $student_info["major"]==="humanities" ? 1 :0;
                $consultant_report_exististance["sum_all_experimental_students"] += $student_info["major"]==="experimental" ? 1 :0;
                $consultant_report_exististance["sum_all_mathematics_students"] += $student_info["major"]==="mathematics" ? 1 :0;
                $consultant_report_exististance["sum_all_art_students"] += $student_info["major"]==="art" ? 1 :0;
                $consultant_report_exististance["sum_all_other_students"] += $student_info["major"]==="other" ? 1 :0;

                $consultant_report_exististance["sum_all_education_level_6_students"] += $student_info["education_level"]==="6" ? 1 :0;
                $consultant_report_exististance["sum_all_education_level_7_students"] += $student_info["education_level"]==="7" ? 1 :0;
                $consultant_report_exististance["sum_all_education_level_8_students"] += $student_info["education_level"]==="8" ? 1 :0;
                $consultant_report_exististance["sum_all_education_level_9_students"] += $student_info["education_level"]==="9" ? 1 :0;
                $consultant_report_exististance["sum_all_education_level_10_students"] += $student_info["education_level"]==="10" ? 1 :0;
                $consultant_report_exististance["sum_all_education_level_11_students"] += $student_info["education_level"]==="11" ? 1 :0;
                $consultant_report_exististance["sum_all_education_level_12_students"] += $student_info["education_level"]==="12" ? 1 :0;
                $consultant_report_exististance["sum_all_education_level_13_students"] += $student_info["education_level"]==="13" ? 1 :0;
                $consultant_report_exististance["sum_all_education_level_14_students"] += $student_info["education_level"]==="14" ? 1 :0;

                $consultant_report_exististance["sum_all_consultant_absent_session"] += $consultantDefinitionDetail->student_status==="absent" ? 1 :0;
                $consultant_report_exististance["sum_all_consultant_absent_session"] += $consultantDefinitionDetail->student_status==="present" ? 1 :0;

                $consultant_report_exististance["sum_all_single_meet"] += $consultantDefinitionDetail->single_meet ? 1 :0;
                $consultant_report_exististance["sum_all_consultant_non_attendance_session"] += $consultantDefinitionDetail->remote ? 1 :0;
                $consultant_report_exististance["sum_all_consultant_attendance_session"] += $consultantDefinitionDetail->remote==false ? 1 :0;
                $consultant_report_exististance["sum_all_consultant_compensation_session"] += $consultantDefinitionDetail->compensatory_meet==true ? 1 :0;

                $consultant_report_exististance["sum_all_time_earlier_in_minutes"] += $consultantDefinitionDetail->session_status==="earlier_5min_finished" ? 5 :0;
                $consultant_report_exististance["sum_all_time_earlier_in_minutes"] += $consultantDefinitionDetail->session_status==="earlier_10min_finished" ? 10 :0;
                $consultant_report_exististance["sum_all_time_earlier_in_minutes"] += $consultantDefinitionDetail->session_status==="earlier_15min_finished" ? 15 :0;
                $consultant_report_exististance["sum_all_time_earlier_in_minutes"] += $consultantDefinitionDetail->session_status==="earlier_15min_more_finished" ? 20 :0;

                $consultant_report_exististance["sum_all_time_dellay_in_minutes"] += $consultantDefinitionDetail->consultant_status==="dellay5" ? 5 :0;
                $consultant_report_exististance["sum_all_time_dellay_in_minutes"] += $consultantDefinitionDetail->consultant_status==="dellay10" ? 10 :0;
                $consultant_report_exististance["sum_all_time_dellay_in_minutes"] += $consultantDefinitionDetail->consultant_status==="dellay15" ? 15 :0;
                $consultant_report_exististance["sum_all_time_dellay_in_minutes"] += $consultantDefinitionDetail->consultant_status==="dellay15more" ? 20 :0;
                $consultant_report_exististance->save();
            }
            else{
                $consultant_report_exististance = new ConsultantReport;
                $consultant_report_exististance->consultant_id=$consultantDefinitionDetail->consultant_id;
                $consultant_report_exististance->year_id=$consultantDefinitionDetail->year_id;
                $consultant_report_exististance->sum_all_consultant_absent_session += $consultantDefinitionDetail->student_status==="absent" ? 1 :0;
                $consultant_report_exististance->sum_all_consultant_absent_session += $consultantDefinitionDetail->student_status==="present" ? 1 :0;
                $consultant_report_exististance->sum_all_single_meet += $consultantDefinitionDetail->single_meet ? 1 :0;
                $consultant_report_exististance->sum_all_consultant_non_attendance_session += $consultantDefinitionDetail->remote ? 1 :0;
                $consultant_report_exististance->sum_all_consultant_attendance_session += $consultantDefinitionDetail->remote==false ? 1 :0;
                $consultant_report_exististance->sum_all_time_earlier_in_minutes += $consultantDefinitionDetail->session_status==="earlier_5min_finished" ? 5 :0;
                $consultant_report_exististance->sum_all_time_earlier_in_minutes += $consultantDefinitionDetail->session_status==="earlier_10min_finished" ? 10 :0;
                $consultant_report_exististance->sum_all_time_earlier_in_minutes += $consultantDefinitionDetail->session_status==="earlier_15min_finished" ? 15 :0;
                $consultant_report_exististance->sum_all_time_earlier_in_minutes += $consultantDefinitionDetail->session_status==="earlier_15min_more_finished" ? 20 :0;
                $consultant_report_exististance->sum_all_time_dellay_in_minutes += $consultantDefinitionDetail->consultant_status==="dellay5" ? 5 :0;
                $consultant_report_exististance->sum_all_time_dellay_in_minutes += $consultantDefinitionDetail->consultant_status==="dellay10" ? 10 :0;
                $consultant_report_exististance->sum_all_time_dellay_in_minutes += $consultantDefinitionDetail->consultant_status==="dellay15" ? 15 :0;
                $consultant_report_exististance->sum_all_time_dellay_in_minutes += $consultantDefinitionDetail->consultant_status==="dellay15more" ? 20 :0;

            }
            $consultantReport = ConsultantReport::where('consultant_id', $consultantDefinitionDetail->consultant_id);
            Log::info('Model updated: ' . json_encode($consultantDefinitionDetail));
            Log::info("the today is: " . json_encode($today) . " and first is: " . $firstDayOfMonth . " and end is:" . $lastDayOfMonth);
        });

        static::deleted(function ($consultantDefinitionDetail) {

            $today = Carbon::now()->format("Y-m-d");
            $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
            ->where('consultant_id', $consultantDefinitionDetail->consultant_id)
            ->first();
            $student_info=Student_info::where("student_id",$consultantDefinitionDetail->student_id)->first();
            if($consultant_report_exististance ){

                $consultant_report_exististance["sum_all_consultant_duty_session"] -= $consultantDefinitionDetail->id ? 1 :0;

                $consultant_report_exististance->save();

            }
            else{
                $consultant_report_exististance = new ConsultantReport;
                $consultant_report_exististance->consultant_id=$consultantDefinitionDetail->consultant_id;
                $consultant_report_exististance->year_id=$consultantDefinitionDetail->year_id;
                $consultant_report_exististance->sum_all_consultant_duty_session -=1;

                $consultant_report_exististance->save();

            }
           
        });
    }

}
