<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use App\Models\ConsultantFinancial;
use Carbon\Carbon;
use GraphQL\Error\Error;
use Log;

final class DivideConsultantDefinitionDetailTime
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolver($rootValue, array $args)
    {
        $user_id = auth()->guard('api')->user()->id;
        $args["user_id"] = $user_id;

        $consultantDefinition = ConsultantDefinitionDetail::find($args['definition_id']);

        $now=Carbon::now()->format("Y-m-d");
         //Log::info("now is:"  . $now . " and session_date is:" .$consultantDefinition['session_date'] );        

        if($consultantDefinition['session_date'] < $now) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_DAY_HAS_PASSED");

        }

        $division_time = $args['division_time'];
        
        if (!$consultantDefinition) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_NOT_FOUND");
            //return Error::createLocatedError("تقسیم زمانبندی مشاور: رکورد مورد نظر یافت نشد.");
        }
        $start_hour = $consultantDefinition['start_hour'];
        $end_hour = $consultantDefinition['end_hour'];

        $end_hour_dived = Carbon::parse($start_hour)->addMinutes($division_time)->format("H:i");
        //Log::info("step is:" . $division_time);
        if($division_time < 0 ){
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-DIVISION_CANNOT_BE_UNDER_ZERO");
            //return Error::createLocatedError("تقسیم زمانبندی مشاور: گام مربوطه نمیتواند منفی باشد!!.");
        }
        $twoTimes = Carbon::parse($end_hour_dived)->format("H:i") >=  Carbon::parse($end_hour)->format("H:i");
        $newStartWithOldEndCompair = Carbon::parse( $end_hour_dived)->format("H:i") >=  Carbon::parse($end_hour)->format("H:i");

        if ($twoTimes && ($newStartWithOldEndCompair) ) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-DIVISION_IS_NOT_POSSIBLE");
            //return Error::createLocatedError("تقسیم زمانبندی مشاور: به علت تداخل زمانبندی امکان تقسیم جلسه وجود ندارد.");
        }
        $consultantDefinition["start_hour"]=$end_hour_dived;
        $consultantDefinition["step"]=$consultantDefinition["step"] - (int)$division_time;
        $consultantDefinition->save();

        $dividedDefinition=[
            "start_hour" => $start_hour,
            "end_hour" =>  $end_hour_dived,
            "step" => $division_time,
            "consultant_id" => $consultantDefinition["consultant_id"],
            "student_id" => NULL,
            "user_id" => $user_id,
            "branch_class_room_id" => $consultantDefinition["branch_class_room_id"],
            "session_date" => $consultantDefinition["session_date"],

            // "consultant_test_id" => $consultantDefinition["consultant_test_id"],           
            // "student_status" => $consultantDefinition["session_date"],
            // "session_status" => $consultantDefinition["session_date"],
            // "consultant_status" => $consultantDefinition["session_date"],
            // "absent_present_description" => $consultantDefinition["session_date"],
            // "test_description" => $consultantDefinition["session_date"],
        ];
        //$consultantDefinition_filled = $consultantDefinition->fill($args);

        $newConsultantDefinition=ConsultantDefinitionDetail::create($dividedDefinition);
        return $newConsultantDefinition;
    }
   
}
