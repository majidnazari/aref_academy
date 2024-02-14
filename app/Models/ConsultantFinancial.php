<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ConsultantReport;
use App\Models\Year;
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

        $activeYearId = Year::orderBy('active', 'desc')
            ->orderBy('name', 'desc')
            ->value('id');

        static::created(function ($consultantFinancial) use ($activeYearId) {

            //$dirtyAttributes = $consultantFinancial->getDirty();
            // Log::info("the created and  changes of financial are:" . json_encode($consultantFinancial));

            $student_info = StudentInfo::where("student_id", $consultantFinancial->student_id)->first();

            if (empty($student_info)) {
                throw new \Exception("CONSULTANTFINANCIAL-CREATE_STUDENTINFO-NOT-FOUND");
            }

            Log::info("the create  financial student info is:" . json_encode($student_info));

            $today = Carbon::now()->format("Y-m-d");
            $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
                ->where('consultant_id', $consultantFinancial->consultant_id)
                ->first();

            if ($consultant_report_exististance) {
                $consultant_report_exististance["sum_students_registered"] += 1;
                isset($student_info['major']) ?  $consultant_report_exististance["sum_students_major_" .  $student_info['major']] += 1 : null;
                isset($student_info['education_level']) ?  $consultant_report_exististance["sum_students_education_level_" .  $student_info['education_level']] += 1 : null;
                $consultant_report_exististance["sum_financial_student_status_ok"] += 1;
                $consultant_report_exististance["sum_financial_manager_status_pending"] += 1;
                $consultant_report_exististance["sum_financial_financial_status_pending"] += 1;
            } else {
                $consultant_report_exististance = new ConsultantReport;
                $consultant_report_exististance->consultant_id = $consultantFinancial->consultant_id;
                $consultant_report_exististance->year_id = $activeYearId;

                $consultant_report_exististance->sum_students_registered += 1;

                $sum_student_major = "sum_students_major_" .  $student_info['major'];
                isset($student_info['major']) ?  $consultant_report_exististance->$sum_student_major += 1 : null;
                $sum_student_lavel = "sum_students_education_level_" .  $student_info['education_level'];
                isset($student_info['education_level']) ?  $consultant_report_exististance->$sum_student_lavel += 1 : null;

                $consultant_report_exististance->sum_financial_student_status_ok += 1;
                $consultant_report_exististance->sum_financial_manager_status_pending += 1;
                $consultant_report_exististance->sum_financial_financial_status_pending += 1;

                $consultant_report_exististance->statical_date = $today;
            }
            $consultant_report_exististance->save();
        });

        static::updated(function ($consultantFinancial) use ($activeYearId) {

            $dirtyAttributes = $consultantFinancial->getDirty();
            Log::info("the  updated and changes of financial are:" . json_encode($dirtyAttributes));
            if (!empty($dirtyAttributes)) {
                // Log the changes to an audit table
                foreach ($dirtyAttributes as $attribute => $newValue) {
                   
                    $oldValue = $consultantFinancial->getOriginal($attribute); // Get the original value

                    Log::info("the column is:". $attribute . " and new value is:" .$newValue . " and old value is:" . $oldValue );
                    self::updateReportForUpdate($consultantFinancial, $attribute, ($newValue ? $newValue : 0), ($oldValue ? $oldValue : 0));
                }
            }
        });

        static::deleted(function ($consultantFinancial) {
        });
    }
    // protected static function updateReportForCreate($consultantFinancial, $column, $new_value, $old_value)
    // {

    //     $accept_column = ["student_status", "manager_status", "financial_status", "financial_refused_status"];
    //     Log::info("updateReportForCreate in consultant financial is run");

    //     $activeYearId = Year::orderBy('active', 'desc')
    //         ->orderBy('name', 'desc')
    //         ->value('id');

    //     $today = Carbon::now()->format("Y-m-d");
    //     $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
    //         ->where('consultant_id', $consultantFinancial->consultant_id)
    //         ->first();
    //     $student_info = StudentInfo::where("student_id", $consultantFinancial->student_id)->first();

    //     if (empty($student_info) && ($consultant_report_exististance->student_id != null)) {
    //         throw new \Exception("consultantFinancial-UPDATE_STUDENTINFO-NOT-FOUND");
    //     }

    //     if ($consultant_report_exististance) {

    //         in_array($column, $accept_column) ? $consultant_report_exististance["sum_financial_" . $column . "_" . $new_value] += 1 : null;
    //         in_array($column, $accept_column) ? ($consultant_report_exististance["sum_financial_" . $column . "_" . $old_value] != null ? $consultant_report_exististance["sum_" . $column . "_" . $old_value] -=  1 : null) : null;
    //     } else {
    //         $consultant_report_exististance = new ConsultantReport;
    //         $consultant_report_exististance->consultant_id = $consultantFinancial->consultant_id;
    //         $consultant_report_exististance->year_id = $activeYearId;

    //         $sum_tmp_new = "sum_financial_" . $column . "_" . $new_value;
    //         $sum_tmp_old = "sum_financial_" . $column . "_" . $old_value;

    //         in_array($column, $accept_column)  ? $consultant_report_exististance->$sum_tmp_new += 1 : null;
    //         in_array($column, $accept_column) ? ($consultant_report_exististance->$sum_tmp_old != null ? $consultant_report_exististance->$sum_tmp_old -= 1 : null) : null;

    //         $consultant_report_exististance->statical_date = $today;
    //     }
    //     $consultant_report_exististance->save();
    // }

    protected static function updateReportForUpdate($consultantFinancial, $column, $new_value, $old_value)
    {

        $accept_column = ["student_status", "manager_status", "financial_status", "financial_refused_status"];
        Log::info("updateReportForUpdate in consultant financial is run");

        $activeYearId = Year::orderBy('active', 'desc')
            ->orderBy('name', 'desc')
            ->value('id');

        $today = Carbon::now()->format("Y-m-d");
        $consultant_report_exististance = ConsultantReport::where('statical_date', $today)
            ->where('consultant_id', $consultantFinancial->consultant_id)
            ->first();
        $student_info = StudentInfo::where("student_id", $consultantFinancial->student_id)->first();

        if (empty($student_info) && ($consultant_report_exististance->student_id != null)) {
            throw new \Exception("CONSULTANTFINANCIAL-UPDATE_STUDENTINFO-NOT-FOUND");
        }

        if ($consultant_report_exististance) {
                       

            // if (in_array($column,$accept_column)) {

            //     Log::info("sum_financial_" . $column . "_" . $new_value);
            //     Log::info("sum_financial_" . $column . "_" . $old_value);

            //     $consultant_report_exististance["sum_financial_" . $column . "_" . $new_value] += 1;
            //     $consultant_report_exististance["sum_financial_" . $column . "_" . $old_value] -=  1;
            // }

            in_array($column, $accept_column) ? $consultant_report_exististance["sum_financial_" . $column . "_" . $new_value] += 1 : null;
            in_array($column, $accept_column) ? ($consultant_report_exististance["sum_financial_" . $column . "_" . $old_value] != null ? $consultant_report_exististance["sum_financial_" . $column . "_" . $old_value] -= 1 : null) : null;

            //$consultant_report_exististance->save();

        } else {
            $consultant_report_exististance = new ConsultantReport;
            $consultant_report_exististance->consultant_id = $consultantFinancial->consultant_id;
            $consultant_report_exististance->year_id = $activeYearId;

            $sum_tmp_new = "sum_financial_" . $column . "_" . $new_value;
            $sum_tmp_old = "sum_financial_" . $column . "_" . $old_value;

            in_array($column, $accept_column)  ? $consultant_report_exististance->$sum_tmp_new += 1 : null;
            in_array($column, $accept_column) ? ($consultant_report_exististance->$sum_tmp_old != null ? $consultant_report_exististance->$sum_tmp_old -= 1 : null) : null;

            $consultant_report_exististance->statical_date = $today;

            //$consultant_report_exististance->save();
        }
        $consultant_report_exististance->save();
    }
}
