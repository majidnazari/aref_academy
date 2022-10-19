<?php

use App\Models\AbsencePresence;
use App\Models\Course;
use App\Models\CourseSession;
use App\Models\CourseStudent;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $course_session_date=strtotime($get_course_session->start_date .' '. $get_course_session->end_time);
        // $now=strtotime(date("Y-m-d H:i:s"));
        $current_date=Carbon::now()->format('Y-m-d');
        $current_time=Carbon::now()->format('H:i:s');
        //Log::info("current date is: " . $current_date . " current time is" . $current_time);
        $all_course=Course::pluck('id');

        $all_course_session_ids_of_this_course = CourseSession::whereIn('course_id', $all_course)
        ->where('start_date','<',$current_date )
        ->orWhere(function($query) use($current_date,$current_time){
            $query->where('start_date','=',$current_date)
            ->where('end_time','<',$current_time);
        })->get();
        // ->pluck('id');
        $cout_session=0;        
        foreach ($all_course_session_ids_of_this_course as $course_session_id) {
            $AbsencePresences=[];
            $students = AbsencePresence::where('course_session_id', $course_session_id->id)
                ->pluck('student_id');
            $get_all_new_course_student = CourseStudent::where('course_id', $course_session_id->course_id)->
                whereNotIn('student_id', $students)
                ->get();
                foreach ($get_all_new_course_student as $student) {
                    $AbsencePresence = [
                        'user_id_creator' => 1,
                        "course_session_id" => $course_session_id->id,
                        "teacher_id" => 0,
                        "student_id" => $student->student_id,
                        'status' => "not_registered"
        
                    ];
                    
                    $AbsencePresences[]= $AbsencePresence;
                }
               // Log::info("adding new abbs:" . json_encode($AbsencePresences));
               // Log::info("\n\r the result is:" . $AbsencePresences);
               // $AbsencePresence = AbsencePresence::createMany([$AbsencePresences]);
               DB::table('absence_presences')->insert($AbsencePresences);

               
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
