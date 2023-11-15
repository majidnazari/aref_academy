<?php

namespace App\GraphQL\Mutations\Year;

use App\Models\Year;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class UpdateYear
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
        $user_id = auth()->guard('api')->user()->id;
        $args["user_id_creator"] = $user_id;
        $year = Year::find($args['id']);

        if (!$year) {
            return Error::createLocatedError("YEAR-UPDATE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("بروز رسانی سال تحصیلی: رکورد مورد نظر یافت نشد.");
        }
        $year_filled = $year->fill($args);
        $year->save();

        return $year;
    }
}
