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
        
        // Log::info("def id is:"  . (($consultantDefinition['student_id'])));
        // Log::info("def id is:"  . (isset($consultantDefinition['student_id'])));
        if(!$consultantDefinition)
        {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_NOT_FOUND");
        }
        $consultantDefinition_filled= $consultantDefinition->fill($args);
           
        // if((($args['student_id'] > 0)) && (($args['id'] > 0)))////// if the financial exist update definition id in this table
        // {
        //     $consultantFinancial=ConsultantFinancial::where('student_id',$args['student_id'])
        //     ->where('consultant_id',$consultantDefinition['consultant_id'])            
        //     ->first();

        //     // Log::info("consultant finacial is:" );
        //      Log::info(json_encode($consultantFinancial) );
        //     if(!$consultantFinancial)
        //     {
        //         return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_NOT_FOUND_IN_FINANCIAL");
        //     }
        //     if($consultantFinancial['financial_status']!="pending"){
        //         return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_RECORD_IS_ACTIVE_IN_FINANCIAL");
        //     }
        //     $consultantFinancial->update(
        //         [
        //         'consultant_definition_detail_id' => $args['id']
        //         ]
        //     );
        //     //$consultantFinancial->save();
                
        // }
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
   
