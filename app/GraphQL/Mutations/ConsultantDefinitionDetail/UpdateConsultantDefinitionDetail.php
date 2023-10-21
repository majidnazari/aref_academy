<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use App\Models\ConsultantFinancial;
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
        
        if(!$consultantDefinition)
        {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_NOT_FOUND");
        }
        $consultantDefinition_filled= $consultantDefinition->fill($args);
           
        if((isset($args['student_id'])) && (isset($args['consultant_id'])))////// if the financial exist update definition id in this table
        {
            $consultantFinancial=ConsultantFinancial::where('student_id',$args['student_id'])
            ->where('consultant_id',$args['consultant_id'])->first();
            if($consultantFinancial)
            {
                return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_NOT_FOUND_IN_FINANCIAL");
            }
            $consultantFinancial->update(
                [
                'consultant_definition_detail_id' => $args['id']
                ]
            );
                
        }
        $consultantDefinition->save();
        return $consultantDefinition;
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
   
