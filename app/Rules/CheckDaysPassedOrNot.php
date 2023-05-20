<?php

namespace App\Rules;

use App\Models\CourseSession;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Log;

class CheckDaysPassedOrNot implements Rule
{
    protected $course_session_id;
    protected $days;
    private $err;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($days)
    {
        //$this->course_session_id=$course_session_i_param;
        $this->days=$days;

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->CheckDaysInWeek($this->days,$value);
    }
    public function CheckDaysInWeek($days_given,$week_given)
    {

        //$current_time =Carbon::now()->format("Y-m-d H:i:s");        
        $current_time =Carbon::now()->format("Y-m-d H:i:s");        
        foreach($days_given as $day){
            if($week_given==="Current")
            {   
                $given_day=Carbon::parse("this " . $day )->format("Y-m-d H:i:s");
                    if($current_time > $given_day){
                        $this->err="THE_DAY_IS_PASSED";
                            return false;
                    }
                        // Log::info("the current  week and days are:" . json_encode($given_day));
            }  
                  

        }
    
        //Log::info("the week and days are:" . json_encode($days_given) . " ----" . $week_given);
        // $get_course_session=CourseSession::where('id',$course_session_id)
        // ->where('course_id',$course_id)->first();
        // if(!$get_course_session){
        //      $this->err="THIS_COURSE_SESSION_AND_COURSE_IS_MISMATCH";
        //      return false;

        // }
        // Log::info(strtotime($get_course_session->start_date .' '. $get_course_session->end_time));
        // Log::info(strtotime(date("Y-m-d H:i:s")));
        // $course_session_date=strtotime($get_course_session->start_date . ' ' . "23:59:59");//.' '. $get_course_session->end_time);
        // $now=strtotime(date("Y-m-d H:i:s"));
       //Log::info("course_session_date is:" . $get_course_session->start_date . ' ' . "23:59:59");
       //Log::info("now is:".  date("Y-m-d H:i:s"));
        // if($now>$course_session_date){
        //     $this->err="COURSE_SESSION_DATE_TIME_IS_PASSED";
        //     return false;
        // }
        return true;


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->err;
    }
}
