<?php

namespace App\Rules;

use App\Models\CourseSession;
use Illuminate\Contracts\Validation\Rule;
use Log;

class CreateLimitationDateForAbsencePresence implements Rule
{
    protected $course_session_id;
    protected $course_id;
    private $err;
    private $user_type;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($course_id_param,$user_type=null)
    {
        $this->course_id = $course_id_param;
        $this->user_type = $user_type;
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
         //Log::info("the type is:" . json_encode($this->user_type));
        return $this->CheckCourseSessionDateTime($this->course_id, $value);
    }
    public function CheckCourseSessionDateTime($course_id, $course_session_id)
    {
        $get_course_session = CourseSession::where('id', $course_session_id)
            ->where('course_id', $course_id)->first();
        if (!$get_course_session) {
            $this->err = "THIS_COURSE_SESSION_AND_COURSE_IS_MISMATCH";
            return false;
        }
        $course_session_date = strtotime($get_course_session->start_date . ' ' . "23:59:59"); //.' '. $get_course_session->end_time);
        $now = strtotime(date("Y-m-d H:i:s"));
        if ($now > $course_session_date ) {
            $this->err = "COURSE_SESSION_DATE_TIME_IS_PASSED";
            return false;
        }
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
