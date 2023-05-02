<?php

namespace App\GraphQL\Mutations\ConsultantFinancial;

use App\Models\ConsultantFinancial;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class DeleteConsultantFinancial
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
        $ConsultantFinancial=ConsultantFinancial::find($args['id']);
        
        if(!$ConsultantFinancial)
        {
            return Error::createLocatedError("CONSULTANTFINANCIAL-DELETE-RECORD_NOT_FOUND");
        }
        $ConsultantFinancial_filled= $ConsultantFinancial->delete();
        $ConsultantFinancial->save();       
       
        return $ConsultantFinancial;

        
    }
}
