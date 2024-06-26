<?php

namespace App\Rules;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Validation\Rule;

class CheckDaysPassedOrNot implements Rule
{
    protected $days;
    protected $start_hour;

    private $err;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($days, $start_hour)
    {
        $this->days = $days;
        $this->start_hour = $start_hour;
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
        $days_given = $this->days;
        $start_hour = $this->start_hour;
        $hoursMinutes = explode(":", $start_hour);
        $current_time = Carbon::now()->format("Y-m-d H:i");
       // $fa = CarbonImmutable::now()->locale('fa');
        $now = Carbon::now();

         $startOfWeek =($week_given==="Next") ? Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(7)->format("Y-m-d"): Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
         $endOfWeek =($week_given==="Next") ? Carbon::now()->endOfWeek(Carbon::FRIDAY)->addDays(7)->format("Y-m-d"): Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");


        foreach ($days_given as $day) {

            $day_number = $this->getEnum($day);
            if ($week_given === "Current") {
                //$givenDay = $now->startOfWeek()->addDays(-2)->addDays($day_number)->addHours($hoursMinutes[0])->addMinutes($hoursMinutes[1])->format('Y-m-d H:i');
        
                $givenDay = Carbon::parse($startOfWeek)->addDays($day_number)->addHours($hoursMinutes[0])->addMinutes($hoursMinutes[1])->format('Y-m-d H:i');

                if ($current_time > $givenDay) {
                    $this->err = "THE_GIVEN_DAY_OR_TIME_IS_PASSED";
                    return false;
                }
            }
            if ($week_given === "Next") {
                $startOfNextWeek = $startOfWeek; //$fa->startOfWeek()->addDays(7)->addDays($day_number)->format('Y-m-d H:i');
                $endOfNextWeek =  $endOfWeek;//$fa->endOfWeek()->addDays(7)->format('Y-m-d H:i');

                $givenDay = Carbon::parse($startOfWeek)->addDays($day_number)->addHours($hoursMinutes[0])->addMinutes($hoursMinutes[1])->format('Y-m-d H:i');

                //$givenDay = $now->startOfWeek()->addDays(-2)->addDays(7)->addDays($day_number)->addHours($hoursMinutes[0])->addMinutes($hoursMinutes[1])->format('Y-m-d H:i');
                if (($startOfNextWeek > $givenDay) && ($endOfNextWeek < $givenDay)) {
                    $this->err = "THE_GIVEN_DAY_OR_TIME_IS_INVALID";
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

    public function getEnum(string $day)
    {


        switch ($day) {
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
