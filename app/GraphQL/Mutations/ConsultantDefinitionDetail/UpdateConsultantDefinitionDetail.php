<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\Branch;
use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
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

   
    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {  
        $now=Carbon::now();
        $user_id=auth()->guard('api')->user()->id;
        $args["user_id"]=$user_id;
        $consultant_definition_detail_date_result=ConsultantDefinitionDetail::find($args['id']);
        
        
        if(!$consultant_definition_detail_date_result)
        {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-UPDATE_RECORD_NOT_FOUND");
        }
        $consultant_definition_detail_date_result_filled= $consultant_definition_detail_date_result->fill($args);
        $consultant_definition_detail_date_result_filled['session_date']=$now ;
        $consultant_definition_detail_date_result->save();       
       
        return $consultant_definition_detail_date_result_filled;

        
    }
}
