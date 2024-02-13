<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Carbon\Carbon;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\Event;
use Log;



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
        $consultantDefinitionDetail = ConsultantDefinitionDetail::where('id', $args['id'])->first();
        $now=Carbon::now()->format("Y-m-d");
         Log::info("now is:".json_encode($consultantDefinitionDetail) );  
         
        if (!$consultantDefinitionDetail) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-DELETE_NOT_FOUND");
            //return Error::createLocatedError("حذف برنامه زمانبندی: رکورد مورد نظر یافت نشد.");
        }

        if($consultantDefinitionDetail['session_date'] < $now) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_DAY_HAS_PASSED");

        }        

        if ((!empty($consultantDefinitionDetail['student_id']))  || ($consultantDefinitionDetail['student_status'] !== "no_action")) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-THIS_TIME_HAS_STUDENT");
            //return Error::createLocatedError("حذف برنامه زمانبندی: این تایم دانش آموز ست شده است.");
        }

        // $ConsultantDefinitionDetail_deleted= ConsultantDefinitionDetail::where('id',$args['id'])->delete();
        $consultantDefinitionDetail_refetch = ConsultantDefinitionDetail::where('id', $args['id'])->first();

        // foreach ($students as $student) {
        //     Event::dispatch('eloquent.deleted: ' . get_class($student), $student);
        // }
           if( $consultantDefinitionDetail_refetch){
            $consultantDefinitionDetail_refetch->delete();
           }    

        return $consultantDefinitionDetail;
    }
}
