<?php

namespace App\GraphQL\Mutations\Branch;

use App\Models\Branch;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class CreateBranch
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
        $BranchResult=[
            'user_id_creator' => $user_id,
            "name" => $args['name']            
        ];
        $is_exist= Branch::where('name',$args['name'])              
        ->first();
        if($is_exist)
         {
                 return Error::createLocatedError("BRANCH-CREATE-RECORD_IS_EXIST");
         }
        $BranchResult_result=Branch::create($BranchResult);
        return $BranchResult_result;
    }
}
