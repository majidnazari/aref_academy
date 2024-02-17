<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use GraphQL\Error\Error;
use Log;

class ConsultantDefinitionDetail extends Model //implements Auditable
{
    //use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SoftDeletes;

    protected $fillable =
    [
        "id",
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
        return $this->hasOne(ConsultantFinancial::class, 'student_id', 'student_id');
    }
    public function studentinfo()
    {
        return $this->belongsTo(StudentInfo::class, "student_id", "student_id");
    }

    protected static function boot()
    {
        parent::boot();

        $activeYearId = Year::orderBy('active', 'desc')
            ->orderBy('name', 'desc')
            ->value('id');       

        static::created(function ($consultantDefinitionDetail) use ($activeYearId) {

            Log::info("created run and creayed is:".json_encode($consultantDefinitionDetail));  
            $dirtyAttributes = $consultantDefinitionDetail->getDirty();
            //Log::info("the changes is:" . json_encode($dirtyAttributes));

            //Log::info("updateReport in definition detail is run");

            $activeYearId = Year::orderBy('active', 'desc')
                ->orderBy('name', 'desc')
                ->value('id');
    
            $today = Carbon::now()->format("Y-m-d");
            $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
                ->where('consultant_id', $consultantDefinitionDetail->consultant_id)
                ->first();           

                if ($consultant_report_exististance && (isset($consultantDefinitionDetail['step']))  ) {
                    $consultant_report_exististance['sum_is_defined_consultant_session'] +=1;
                    $consultant_report_exististance['sum_is_defined_consultant_session_in_minutes'] +=$consultantDefinitionDetail['step'];
                  

                }
                else if(isset($consultantDefinitionDetail['step']) ){
                    $consultant_report_exististance = new ConsultantReport;
                    $consultant_report_exististance->consultant_id = $consultantDefinitionDetail->consultant_id;
                    $consultant_report_exististance->year_id = $activeYearId;

                    $consultant_report_exististance->sum_is_defined_consultant_session = 1;
                    $consultant_report_exististance->sum_is_defined_consultant_session_in_minutes = $consultantDefinitionDetail['step'];
                    $consultant_report_exististance->statical_date = $today; 
                    
                } 
            $consultant_report_exististance->save();


        });

        static::updated(function ($consultantDefinitionDetail) use ($activeYearId) {

            Log::info("definition updated run");

            $dirtyAttributes = $consultantDefinitionDetail->getDirty();
            Log::info("the changes is:" . json_encode($dirtyAttributes));
            if (!empty($dirtyAttributes)) {
                // Log the changes to an audit table
                foreach ($dirtyAttributes as $attribute => $newValue) {
                    $oldValue = $consultantDefinitionDetail->getOriginal($attribute); // Get the original value
                    self::updateReport($consultantDefinitionDetail, $attribute, ($newValue ? $newValue : 0), ($oldValue ? $oldValue : 0));
                }
            }

            $today = Carbon::now()->format("Y-m-d");
            $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
                ->where('consultant_id', $consultantDefinitionDetail->consultant_id)
                ->first();
            $student_info = StudentInfo::where("student_id", $consultantDefinitionDetail->student_id)->first();

            if (empty($student_info) && (isset($consultant_report_exististance->student_id) && $consultant_report_exististance->student_id != null)) {
                throw new \Exception("CONSULTANTDEFINITIONDETAIL-UPDATE_STUDENTINFO-NOT-FOUND");
            }
        });

        static::deleted(function ($consultantDefinitionDetail) use ($activeYearId) {

            Log::info("CDD delete is:" . json_encode($consultantDefinitionDetail));

            // $activeYearId = Year::orderBy('active', 'desc')
            // ->orderBy('name', 'desc')
            // ->value('id');

            $today = Carbon::now()->format("Y-m-d");
            $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
                ->where('consultant_id', $consultantDefinitionDetail->consultant_id)
                ->first();           

                if ($consultant_report_exististance && (isset($consultantDefinitionDetail['step']))  ) {
                    $consultant_report_exististance['sum_is_defined_consultant_session'] -=1;
                    $consultant_report_exististance['sum_is_defined_consultant_session_in_minutes'] -=$consultantDefinitionDetail['step'];
                

                }
                else if(isset($consultantDefinitionDetail['step']) ){
                    $consultant_report_exististance = new ConsultantReport;
                    $consultant_report_exististance->consultant_id = $consultantDefinitionDetail->consultant_id;
                    $consultant_report_exististance->year_id = $activeYearId;

                    $consultant_report_exististance->sum_is_defined_consultant_session = -1;
                    $consultant_report_exististance->sum_is_defined_consultant_session_in_minutes -= $consultantDefinitionDetail['step'];
                    $consultant_report_exististance->statical_date = $today; 
                    
                } 
            $consultant_report_exististance->save();
                
            });
    }

    protected static function updateReport($consultantDefinitionDetail, $column, $new_value, $old_value)
    {

        $accept_column_definition = ["student_id", "student_status", "session_status", "consultant_status", "compensatory_meet", "single_meet", "remote"];
        $accept_column_studentinfo = ["major", "education_level"];
        $accept_column_splited_session = ["step"];
        //$accept_value=["apsent","present"];
        Log::info("updateReport in definition detail is run");

        $activeYearId = Year::orderBy('active', 'desc')
            ->orderBy('name', 'desc')
            ->value('id');

        $today = Carbon::now()->format("Y-m-d");
        $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
            ->where('consultant_id', $consultantDefinitionDetail->consultant_id)
            ->first();


        $student_info = StudentInfo::where("student_id", $consultantDefinitionDetail->student_id)->first();

        if (empty($student_info) && (isset($consultant_report_exististance->student_id) && $consultant_report_exististance->student_id != null)) {
            throw new \Exception("CONSULTANTDEFINITIONDETAIL-UPDATE_STUDENTINFO-NOT-FOUND");
        }

        if ($consultant_report_exististance) {
            // Log::info("after convertOldValue is:" .$data["sum_" . $column . "_" . $old_value]);

            switch ($column) {
                case  "student_id":
                    //Log::info("old value for deleted student" . $old_value);
                    //Log::info("new value for deleted student" . $new_value);
                    $student_info = $old_value ?  StudentInfo::where("student_id", $old_value)->first() : StudentInfo::where("student_id", $new_value)->first();
                    if (isset($new_value) && ($new_value != null)) {
                        $consultant_report_exististance["sum_is_filled_consultant_session"] += 1;
                        $consultant_report_exististance["sum_is_filled_consultant_session_in_minutes"] += $consultantDefinitionDetail['step'];
                        //isset($student_info['major']) ?  $consultant_report_exististance["sum_students_major_" .  $student_info['major']] += 1 : null;
                        //isset($student_info['education_level']) ?  $consultant_report_exististance["sum_students_education_level_" .  $student_info['education_level']] += 1 : null;
                    } else {
                        $consultant_report_exististance["sum_is_filled_consultant_session"] -= 1;
                        $consultant_report_exististance["sum_is_filled_consultant_session_in_minutes"] -= $consultantDefinitionDetail['step'];

                        //isset($student_info['major']) ?  $consultant_report_exististance["sum_students_major_" .  $student_info['major']] -= 1 : null;
                        //isset($student_info['education_level']) ?  $consultant_report_exististance["sum_students_education_level_" .  $student_info['education_level']] -= 1 : null;
                    }

                    break;
                case   in_array($column, $accept_column_splited_session):

                    // Log::info("old value for deleted student" . $old_value);
                    // Log::info("new value for deleted student" . $new_value);
                    // Log::info("and it is filled or not :" . isset($consultantDefinitionDetail->student_id) ? $consultantDefinitionDetail->student_id : null);

                    if($consultantDefinitionDetail->student_id){
                        $consultant_report_exististance["sum_is_defined_consultant_session_in_minutes"] -= ($old_value -$new_value);
                        $consultant_report_exististance["sum_is_filled_consultant_session_in_minutes"] -= ($old_value -$new_value);                      

                    }
                    else{
                        $consultant_report_exististance["sum_is_defined_consultant_session_in_minutes"] -= ($old_value -$new_value);
                    }
                   
                    break;
                case  in_array($column, $accept_column_definition):
                    $consultant_report_exististance["sum_" . $column . "_" . $new_value] += 1;
                    $consultant_report_exististance["sum_" . $column . "_" . $old_value] != null ? $consultant_report_exististance["sum_" . $column . "_" . $old_value] -=  1 : null;
                    break;

                // case  in_array($column, $accept_column_studentinfo):
                //     $consultant_report_exististance["sum_students_" . $column . "_" . $new_value] += 1;
                //     $consultant_report_exististance["sum_students_" . $column . "_" . $old_value] != null ? $consultant_report_exististance["sum_" . $column . "_" . $old_value] -=  1 : null;
                //     break;
            }
            

        } else {
            $consultant_report_exististance = new ConsultantReport;
            $consultant_report_exististance->consultant_id = $consultantDefinitionDetail->consultant_id;
            $consultant_report_exististance->year_id = $activeYearId;

            $student_info = StudentInfo::where("student_id", $consultantDefinitionDetail->student_id)->first();

            if (empty($student_info) && ($consultant_report_exististance->student_id != null)) {
                throw new \Exception("CONSULTANTDEFINITIONDETAIL-UPDATE_STUDENTINFO-NOT-FOUND");
            }

            switch ($column) {
                case  "student_id":
                    //Log::info("old value for deleted student" . $old_value);
                    //Log::info("new value for deleted student" . $new_value);
                    $student_info = $old_value ?  StudentInfo::where("student_id", $old_value)->first() : StudentInfo::where("student_id", $new_value)->first();
                    if (isset($new_value) && ($new_value != null)) {
                        $consultant_report_exististance->sum_is_filled_consultant_session += 1;
                        $consultant_report_exististance->sum_is_filled_consultant_session_in_minutes += $consultantDefinitionDetail->step;

                        //isset($student_info['major']) ?  $consultant_report_exististance["sum_students_major_" .  $student_info['major']] += 1 : null;
                        //isset($student_info['education_level']) ?  $consultant_report_exististance["sum_students_education_level_" .  $student_info['education_level']] += 1 : null;
                    } else {
                        $consultant_report_exististance->sum_is_filled_consultant_session -= 1;
                        $consultant_report_exististance->sum_is_filled_consultant_session_in_minutes -= $consultantDefinitionDetail->step;
                        //isset($student_info['major']) ?  $consultant_report_exististance["sum_students_major_" .  $student_info['major']] -= 1 : null;
                        //isset($student_info['education_level']) ?  $consultant_report_exististance["sum_students_education_level_" .  $student_info['education_level']] -= 1 : null;
                    }

                    break;
                case   in_array($column, $accept_column_splited_session):

                        if($consultantDefinitionDetail->student_id){
                            $consultant_report_exististance->sum_is_defined_consultant_session_in_minutes -= ($old_value -$new_value);
                            $consultant_report_exististance->sum_is_filled_consultant_session_in_minutes -= ($old_value -$new_value);                      
    
                        }
                        else{
                            $consultant_report_exististance->sum_is_defined_consultant_session_in_minutes -= ($old_value -$new_value);
                        }
                       
                        break;   
                case  in_array($column, $accept_column_definition):
                    $sum_tmp_new = "sum_" . $column . "_" . $new_value;
                    $sum_tmp_old = "sum_" . $column . "_" . $old_value;
                    $consultant_report_exististance->$sum_tmp_new += 1;
                    $consultant_report_exististance->$sum_tmp_old != null ? $consultant_report_exististance->$sum_tmp_old -= 1 : null;
                    break;

                // case  in_array($column, $accept_column_studentinfo):
                //     $sum_tmp_new = "sum_students_" . $column . "_" . $new_value;
                //     $sum_tmp_old = "sum_students_" . $column . "_" . $old_value;
                //     $consultant_report_exististance->$sum_tmp_new += 1;
                //     $consultant_report_exististance->$sum_tmp_old != null ? $consultant_report_exististance->$sum_tmp_old -= 1 : null;
                //     break;
            }

            $consultant_report_exististance->statical_date = $today;
            //$consultant_report_exististance->save();
        }
        $consultant_report_exististance->save();
    }
}
