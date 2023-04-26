<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Log;

final class DeleteConsultantDefinitionDetail
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
        $user_id=auth()->guard('api')->user()->id;
        //$args["user_id_creator"]=$user_id;

        
        $ConsultantDefinitionDetailResultIds=ConsultantDefinitionDetail::whereIn('id',$args['id'])->get();
        
        //Log::info("all deleted are: " . json_encode($ConsultantDefinitionDetailResultIds));
       
        $ConsultantDefinitionDetail_deleted= ConsultantDefinitionDetail::whereIn('id',$args['id'])->delete();  
        if(!$ConsultantDefinitionDetail_deleted)
        {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-CANNOT-DELETE_RECORDS");
        }
        
        return $ConsultantDefinitionDetailResultIds;

        
    }
}
