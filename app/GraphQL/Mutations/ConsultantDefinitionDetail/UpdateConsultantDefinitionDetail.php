<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Error\Error;

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
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE-RECORD_NOT_FOUND");
        }
        $consultantDefinition_filled= $consultantDefinition->fill($args);
        $consultantDefinition->save();       
       
        return $consultantDefinition;
    }
}  
   
