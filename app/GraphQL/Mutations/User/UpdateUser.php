<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


final class UpdateUser
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $user_type = auth()->guard('api')->user()->group->type;
        $exist_user = User::where('id', $args['id'])->first();
        if (!$exist_user) {
            return Error::createLocatedError("USER-UPDATE-RECORD_IS_NOT_FOUND");
            //return Error::createLocatedError("بروز رسانی کاربر:رکورد مورد نظر یافت نشد.");
        }
        return  $this->updateUser($exist_user, $args);
    }
    function updateUser($exist_user, $user_date)
    {
        
        $user_id = auth()->guard('api')->user()->id;
        $user_date['branch_id']=(isset($user_date['branch_id']) && ($user_date['branch_id'] !=-1 )) ? $user_date['branch_id'] : null;
        $result = $exist_user->fill($user_date);
        $exist_user->save();
        return $result; // User::create($user);

    }
}
