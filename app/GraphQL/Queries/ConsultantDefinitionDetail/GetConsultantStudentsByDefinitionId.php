<?php

namespace App\GraphQL\Queries\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Branch;
use App\Models\ConsultantFinancial;
use Carbon\Carbon;
use GraphQL\Error\Error;

use Log;

final class GetConsultantStudentsByDefinitionId
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }
    function resolveConsultantStudentsByDefinitionId($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $nextweek = false;

        $thisweekStartDate =  Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        $thisweekEndDate = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(6)->format("Y-m-d");


        $nextWeekStartDate =  Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(7)->format("Y-m-d");
        $nextWeekEndDate = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(13)->format("Y-m-d");



        // Log::info("start week is:" . $thisweekStartDate . " and end of wek is:" . $thisweekEndDate);

        // $branch_id = auth()->guard('api')->user()->branch_id;
        // $one_branch[] = $branch_id;
        // $all_branches = Branch::pluck('id');
        // $all_branches[] = null;
        // $branches_id = ($branch_id === null) ? $all_branches :  $one_branch;

        $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where('id', $args['id'])
            // ->whereHas('branchClassRoom.branch', function ($query) use ($branches_id) {
            //     return $query->whereIn('id', $branches_id);
            // })
            // ->with('branchClassRoom.branch')
            ->first();

        if (!$ConsultantDefinitionDetail) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-GET_INVALID_ID");
            //return Error::createLocatedError("نمایش جلسات مشاور:شماره رکورد مورد نظر اشتباه است.");
        }
        if (($ConsultantDefinitionDetail['session_date'] >= $thisweekStartDate)  && ($ConsultantDefinitionDetail['session_date'] <=  $thisweekEndDate)) {
            $StudentsExistInThisWeek = ConsultantDefinitionDetail::where('session_date', ">=", $thisweekStartDate)
                ->where('session_date', "<=", $thisweekEndDate)
                ->where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
                ->where('student_status', "!=", "absent")
                ->whereNotNull('student_id')
                ->pluck('student_id');
        }
        else if ((($ConsultantDefinitionDetail['session_date'] >= $nextWeekStartDate)  && ($ConsultantDefinitionDetail['session_date'] <=  $nextWeekEndDate))) {
            $nextweek = true;

            $StudentsExistInNextWeek = ConsultantDefinitionDetail::where('session_date', ">=", $nextWeekStartDate)
                ->where('session_date', "<=", $nextWeekEndDate)
                ->where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
                ->where('student_status', "!=", "absent")
                ->whereNotNull('student_id')
                ->pluck('student_id');
        }

        //Log::info("studentds defined are:" . json_encode($StudentsExistInThisWeek ));

        if ($nextweek) {
            $studentdsId = ConsultantFinancial::where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
                ->where('student_status', 'ok')
                ->whereNotIn('student_id', $StudentsExistInNextWeek)
                ->pluck('student_id');
        } else {
            $studentdsId = ConsultantFinancial::where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
                ->where('student_status', 'ok')
                ->whereNotIn('student_id', $StudentsExistInThisWeek)
                ->pluck('student_id');
        }



        //Log::info($studentdsId);
        return  $studentdsId;
    }
}
