<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use App\Models\ConsultantFinancial;
use GraphQL\Error\Error;
use Log;

final class DeleteConsultantDefinitionDetailStudentId
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }    
    public function resolverRemoveStudent($rootValue, array $args)
    {       
        $user_id=auth()->guard('api')->user()->id;
        $args["user_id"]=$user_id;
        $consultantDefinition=ConsultantDefinitionDetail::find($args['id']);
        
        if(!$consultantDefinition)
        {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE-RECORD_NOT_FOUND");
        }
        if($consultantDefinition['student_status']!="no_action")
        {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE-STUDENT_STATUS_FILLED");
        }
        // if($consultantDefinition['student_status']!="no_action")
        // {
        //     return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE-STUDENT_STATUS_FILLED");
        // }
        //     $consultant_id=$consultantDefinition['consultant_id'];
        //     $student_id=$consultantDefinition['student_id'];
            
        // $consultant_financial=ConsultantFinancial::where('consultant_definition_detail_id',$args['id'])
        // ->whereIn('financial_status',["approved","semi_approved"])->first(); 

        // if($consultant_financial){
        //     return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE-STUDENT_HAS_ACTIVE_RECORD");
        // }
        
        //$consultantDefinition_filled= $consultantDefinition->fill($args);
        $consultantDefinition['student_id']=null;
        //Log::info($consultantDefinition_filled);
        $consultantDefinition->save();       
       
        return $consultantDefinition;
    }
}  
   