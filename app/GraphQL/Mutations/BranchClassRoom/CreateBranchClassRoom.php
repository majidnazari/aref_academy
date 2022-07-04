<?php

namespace App\GraphQL\Mutations\BranchClassRoom;

use App\Models\BranchClassRoom;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class CreateBranchClassRoom
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
            'branch_id' => $args['branch_id'],
            'name' => $args['name'],
            "description" => $args['description']            
        ];

        $is_exist= BranchClassRoom::where('branch_id',$args['branch_id'])
        ->where('name',$args['name'])              
        //->where('description',$args['description'])              
        ->first();
        if($is_exist)
         {
                 return Error::createLocatedError("BRANCHCLASSROOM-CREATE-RECORD_IS_EXIST");
         }
        $BranchResult_result=BranchClassRoom::create($BranchResult);
        return $BranchResult_result;
    }
}
