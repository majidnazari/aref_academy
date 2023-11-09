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
        $division_time = $args['division_time'];
        // Log::info("def id is:"  . (($consultantDefinition['student_id'])));
        if (!$consultantDefinition) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_NOT_FOUND");
        }
        $start_hour = $consultantDefinition['start_hour'];
        $end_hour = $consultantDefinition['end_hour'];

        $end_hour_dived = Carbon::parse($start_hour)->addMinutes($division_time)->format("H:i");
        $twoTimes = Carbon::parse($end_hour_dived)->format("H:i") > Carbon::parse($end_hour)->format("H:i");

        if ($twoTimes) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-DIVISION_IS_NOT_POSSIBLE");
        }
        $consultantDefinition["start_hour"]=$end_hour_dived;
        $consultantDefinition->save();

        Log::info("new hour is:" . $end_hour_dived);
        Log::info("compair is:" . $twoTimes);

        $dividedDefinition=[
            "start_hour" => $start_hour,
            "end_hour" =>  $end_hour_dived,
            "step" => $division_time,
            "consultant_id" => $consultantDefinition["start_hour"],
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
    // public function resolverRemoveStudent($rootValue, array $args)
    // {       
    //     $user_id=auth()->guard('api')->user()->id;
    //     $args["user_id"]=$user_id;
    //     $consultantDefinition=ConsultantDefinitionDetail::find($args['id']);

    //     if(!$consultantDefinition)
    //     {
    //         return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE-RECORD_NOT_FOUND");
    //     }

    //     $consultantDefinition_filled= $consultantDefinition->fill($args);
    //     $consultantDefinition_filled['student_id']=null;
    //     Log::info($consultantDefinition_filled);
    //     $consultantDefinition->save();       

    //     return $consultantDefinition;
    // }
}
