<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use App\Models\ConsultantFinancial;
use Carbon\Carbon;
// use Carbon\Carbon;
use GraphQL\Error\Error;
use Log;

final class UpdateConsultantDefinitionDetail
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
        //Log::info("this update is run");
        $user_id = auth()->guard('api')->user()->id;
        $args["user_id"] = $user_id;
        $consultantDefinition = ConsultantDefinitionDetail::find($args['id']);
        $now = Carbon::now()->format("Y-m-d");
        //Log::info("the record is:" . json_encode( $consultantDefinition) );        

        if ($consultantDefinition['session_date'] < $now) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_DAY_HAS_PASSED");
        }
        // Log::info("def id is:"  . (($consultantDefinition['student_id'])));
        // Log::info("def id is:"  . (isset($consultantDefinition['student_id'])));
        if (!$consultantDefinition) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_NOT_FOUND");
            //return Error::createLocatedError("بروز رسانی زمانبندی جلسات: رکورد مورد نظر یافت نشد.");
        }
        // Log::info("and student status is: " . $args['student_status']);
        // Log::info(json_encode($consultantDefinition));
        if (isset($args['student_status']) && ($args['student_status'] != "no_action")) {
           // Log::info("changed student status");
            $consultantDefinition["user_id_student_status"] = $user_id;
            $consultantDefinition["student_status_updated_at"] = Carbon::now()->format("Y-m-d H:i");
        }
        $consultantDefinition_filled = $consultantDefinition->fill($args);
        $result = $consultantDefinition->save();

        if (
            $result
            && $consultantDefinition['compensatory_meet'] === true
            && $consultantDefinition['id'] > 0
            && $consultantDefinition['compensatory_of_definition_detail_id'] > 0
            && $consultantDefinition['compensatory_for_definition_detail_id'] === null
        ) {
            $absentSession = ConsultantDefinitionDetail::find($consultantDefinition['compensatory_of_definition_detail_id']);

            $absentSession['compensatory_for_definition_detail_id'] = $consultantDefinition['id'];
            $absentSession->save();
            
            // Log::info("the id updated " . $consultantDefinition['id']);
            // Log::info("the compensatory_of:" . $consultantDefinition['compensatory_of_definition_detail_id']);
            // Log::info("the compensatory_for:" . $consultantDefinition['compensatory_for_definition_detail_id']);
        }
        //Log::info($result);
        return $consultantDefinition;
    }
}
