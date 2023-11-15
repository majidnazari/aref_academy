<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;


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
        $user_id = auth()->guard('api')->user()->id;
        $ConsultantDefinitionDetailResultIds = ConsultantDefinitionDetail::where('id', $args['id'])->first();
        if (!$ConsultantDefinitionDetailResultIds) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-DELETE_NOT_FOUND");
            //return Error::createLocatedError("حذف برنامه زمانبندی: رکورد مورد نظر یافت نشد.");
        }

        if ((!empty($ConsultantDefinitionDetailResultIds['student_id']))  || ($ConsultantDefinitionDetailResultIds['student_status'] !== "no_action")) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-THIS_TIME_HAS_STUDENT");
            //return Error::createLocatedError("حذف برنامه زمانبندی: این تایم دانش آموز ست شده است.");
        }
        $ConsultantDefinitionDetail_deleted= ConsultantDefinitionDetail::where('id',$args['id'])->delete();  

        return $ConsultantDefinitionDetailResultIds;
    }
}
