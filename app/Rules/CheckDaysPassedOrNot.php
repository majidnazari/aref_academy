<?php

namespace App\Rules;

use App\Models\CourseSession;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\Enum;


class CheckDaysPassedOrNot implements Rule
{
    protected $course_session_id;
    protected $days;
    protected $start_hour;
    
    private $err;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($days,$start_hour)
    {
        //$this->course_session_id=$course_session_i_param;
        $this->days=$days;
        $this->start_hour=$start_hour;

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
        return $this->CheckDaysInWeek($value);
    }   
   
    public function CheckDaysInWeek($week_given)
    { 
        $days_given=$this->days;
        $start_hour=$this->start_hour;
        $hoursMinutes=explode(":",$start_hour);             
        $current_time =Carbon::now()->format("Y-m-d H:i"); 
        $fa = CarbonImmutable::now()->locale('fa');

        foreach($days_given as $day){
            
            $day_number= $this->getEnum($day);          
            if($week_given==="Current")
            {  
                $startOfThisWeek=$fa->startOfWeek()->format('Y-m-d H:i');
                $endOfThisWeek=$fa->endOfWeek()->format('Y-m-d H:i'); 
                $givenDay=$fa->startOfWeek()->addDays($day_number)->addHours( $hoursMinutes[0])->addMinutes( $hoursMinutes[1])->format('Y-m-d H:i'); 
                // Log::info("start of current week is:".$startOfThisWeek . " and end is:". $endOfThisWeek. " and given day is:".$givenDay);          
                           
                    if($current_time > $givenDay){
                        $this->err="THE_GIVEN_DAY_OR_TIME_IS_PASSED";
                            return false;
                    }
            }  
            if($week_given==="Next")
            {   
                $startOfNextWeek=$fa->startOfWeek()->addDays(7)->addDays($day_number)->format('Y-m-d H:i');
                $endOfNextWeek=$fa->endOfWeek()->addDays(7)->format('Y-m-d H:i');  
                $givenDay=$fa->startOfWeek()->addDays(7)->addDays($day_number)->addHours( $hoursMinutes[0])->addMinutes( $hoursMinutes[1])->format('Y-m-d H:i'); 
                //  Log::info("start of next week is:".$startOfNextWeek . " and end is:". $endOfNextWeek. " and given day is:".$givenDay);          
                if(($startOfNextWeek > $givenDay) && ($endOfNextWeek< $givenDay)){
                    $this->err="THE_GIVEN_DAY_OR_TIME_IS_INVALID";
                        return false;
                }
            }  
                  

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
    
    public function getEnum(string $day){
        
       
        switch($day)
        {
            case "Saturday":
                return 0;
                //return Carbon::SATURDAY;
            case "Sunday":
                return 1;
               // return Carbon::SUNDAY;
            case "Monday":
                return 2;
                //return Carbon::MONDAY;
            case "Tuesday":
                return 3;
                //return Carbon::TUESDAY;
            case "Wednesday":
                return 4;
                //return Carbon::WEDNESDAY;
            case "Thursday":
                return 5;
               // return Carbon::THURSDAY;
            case "Friday":
                return 6;
                //return Carbon::FRIDAY;
                
        }
    }
}
