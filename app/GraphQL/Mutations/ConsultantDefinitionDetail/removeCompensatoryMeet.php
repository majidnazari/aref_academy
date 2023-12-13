<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use App\Models\ConsultantFinancial;
use Carbon\Carbon;
use GraphQL\Error\Error;
use Log;

final class removeCompensatoryMeet
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

        $consultantDefinition = ConsultantDefinitionDetail::find($args['definition_detail_id']);

       

        $now = Carbon::now()->format("Y-m-d");
        //Log::info("now is:"  . $now . " and session_date is:" .$consultantDefinition['session_date'] );        

        if (!$consultantDefinition) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_COPMENSATORY_NOT_FOUND");
        }
        $consultantDefinition['compensatory_meet'] = 0;
        $consultantDefinition['compensatory_of_definition_detail_id'] = null;

        $consultantDefinition->save();
        $definition_detail_id = $args['definition_detail_id'];


        $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where("compensatory_for_definition_detail_id", $definition_detail_id)
        //->get();
        ->update(
            [
                "compensatory_for_definition_detail_id" => null

            ]
        );
        //$result = $ConsultantDefinitionDetail->save();

        return $consultantDefinition;
    }
}
