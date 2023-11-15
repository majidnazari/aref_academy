<?php

namespace App\GraphQL\Mutations\User;

use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


final class DeleteUser
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
        $user_id = auth()->guard('api')->user()->id;
        $user = User::find($args['id']);
        if ($user_id == $args['id']) {
            return Error::createLocatedError("USER-DELETE-CANNOT_SUICIDE");
            //return Error::createLocatedError("حذف کاربر: نمیتوانید خود را حذف کنید.");
        }
        if (!$user) {
            return Error::createLocatedError("USER-DELETE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("حذف دانش آموز: رکورد مورد نظر یافت نشد.");
        }
        $user_filled = $user->delete();
        return $user;
    }
}
