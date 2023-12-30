<?php

namespace App\GraphQL\Mutations\StudentInfo;

use App\Models\ConsultantFinancial;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class DeleteStudentInfo
{

    public function resolver($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $user_id = auth()->guard('api')->user()->id;
        //$args["user_id_creator"]=$user_id;
        $ConsultantFinancial = ConsultantFinancial::find($args['id']);

        if (!$ConsultantFinancial) {
            return Error::createLocatedError("CONSULTANTFINANCIAL-DELETE-RECORD_NOT_FOUND");
            //return Error::createLocatedError("حذف مالی مشاوران:رکورد مورد نظر یافت نشد.");
        }
        $ConsultantFinancial_filled = $ConsultantFinancial->delete();
        $ConsultantFinancial->save();

        return $ConsultantFinancial;
    }
}
