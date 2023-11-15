<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use App\Models\ConsultantFinancial;
use Carbon\Carbon;
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
        $user_id=auth()->guard('api')->user()->id;
        $args["user_id"]=$user_id;
        $consultantDefinition=ConsultantDefinitionDetail::find($args['id']);
        $now=Carbon::now()->format("Y-m-d");
         //Log::info("now is:"  . $now . " and session_date is:" .$consultantDefinition['session_date'] );        

        if($consultantDefinition['session_date'] < $now) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_DAY_HAS_PASSED");

        }
        // Log::info("def id is:"  . (($consultantDefinition['student_id'])));
        // Log::info("def id is:"  . (isset($consultantDefinition['student_id'])));
        if(!$consultantDefinition)
        {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_NOT_FOUND");
            //return Error::createLocatedError("بروز رسانی زمانبندی جلسات: رکورد مورد نظر یافت نشد.");
        }
        $consultantDefinition_filled= $consultantDefinition->fill($args);           
       
        $consultantDefinition->save();
        return $consultantDefinition;
    }
    
}  
   
