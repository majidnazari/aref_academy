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
use Log;

final class UpdateConsultantFinancial
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
        $ConsultantFinancial=ConsultantFinancial::find($args['id']);
        
        if(!$ConsultantFinancial)
        {
            return Error::createLocatedError("CONSULTANTFINANCIAL-UPDATE-RECORD_NOT_FOUND");
        }
        $data=[
            "consultant_id"=>$args['consultant_id'],
            "student_id"=>$args['student_id'],
            "consultant_definition_detail_id"=>$args['consultant_definition_detail_id'],
           

        ];
        $exist_before=ConsultantFinancial::where($data)->exists();
        //Log::info("update is:". json_encode($exist_before));
        if($exist_before)
        {
            return Error::createLocatedError("CONSULTANTFINANCIAL-UPDATE-RECORD_EXIST_BEFORE");
        }
        $ConsultantFinancial_filled= $ConsultantFinancial->fill($args);
        $ConsultantFinancial->save();       
       
        return $ConsultantFinancial;

        
    }
}
