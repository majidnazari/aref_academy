<?php

namespace App\GraphQL\Mutations\Fault;

use App\Models\Fault;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class UpdateFault
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
        $args["user_id_creator"]=$user_id;
        $Fault=Fault::find($args['id']);
        if(!$Fault)
        {
            return Error::createLocatedError("FAULT-UPDATE-RECORD_NOT_FOUND");
        }
        $fault_date=[
            //'user_id_creator' => $user_id,
            "description" => $args['description'] 
        ];
        $is_exist= Fault::where($fault_date)       
        ->first();
        
        if($is_exist)
        {
            return Error::createLocatedError("FAULT-UPDATE-RECORD_IS_EXIST");
        }
       
        $Fault_filled= $Fault->fill($args);
        $Fault->save(); 
        return $Fault;
        
    }
}
