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
    const Next2week = 14;
    const Next3week = 21;
    const Next4week = 28;
    const Next = 7;
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
        // $startOfWeek =  Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        // $endOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(6)->format("Y-m-d");

        // // Log::info("the start is:" .$startOfWeek , " and the end is:" . $endOfWeek );
        // // Log::info("the start is:" .$startOfWeek , " and the end is:" . $endOfWeek );
        // $nextWeekStartDate =  Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(7)->format("Y-m-d");
        // $nextWeekEndDate = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(13)->format("Y-m-d");
        // Log::info("start week is:" . $startOfWeek . " and end of wek is:" . $endOfWeek);
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

        $currentWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->week;
        $targetWeek = Carbon::parse($ConsultantDefinitionDetail['session_date'])
            ->startOfWeek(Carbon::SATURDAY)->weekOfYear;

        // Log::info("the date is:" .$ConsultantDefinitionDetail['session_date']);
        // Log::info("the date is:" . $ConsultantDefinitionDetail['session_date']);
        // Log::info("the currentWeek  is:" . $currentWeek);
        // Log::info("the targetWeek  is:" . $targetWeek);

        $whichWeek = "Current";

        switch ($targetWeek) {
            case ($currentWeek):
                $whichWeek = "Current";
                break;
            case ($currentWeek + 1):
                $whichWeek = "Next";
                break;
            case ($currentWeek + 2):
                $whichWeek = "Next2week";
                break;
            case ($currentWeek + 3):
                $whichWeek = "Next3week";
                break;
            case ($currentWeek + 4):
                $whichWeek = "Next4week";
                break;
        }

        // if ($targetWeek == $currentWeek) {
        //     $tmp = 'Current Week';
        // } elseif ($targetWeek == $currentWeek + 1) {
        //     $tmp = 'Next';
        // } elseif ($targetWeek == $currentWeek + 2) {
        //     $tmp = 'Next 2 Week';
        // } elseif ($targetWeek == $currentWeek + 3) {
        //     $tmp = 'Next 3 Week';
        // } elseif ($targetWeek == $currentWeek + 4) {
        //     $tmp = 'Next 4 Week';
        // }
       // Log::info("the whichWeek  is:" . $whichWeek);

        $week = $whichWeek;
        $startOfCurrentWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        $endOfCurrentWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(6)->format("Y-m-d");

        [$startOfWeek, $endOfWeek] = $this->selectWeek($startOfCurrentWeek, $endOfCurrentWeek, $week);


        if (!$ConsultantDefinitionDetail) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-GET_INVALID_ID");
            //return Error::createLocatedError("نمایش جلسات مشاور:شماره رکورد مورد نظر اشتباه است.");
        }

        $StudentsExistInThisWeek = ConsultantDefinitionDetail::where('session_date', ">=", $startOfWeek)
            ->where('session_date', "<=", $endOfWeek)
            ->where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
            ->where('student_status', "!=", "absent")
            ->whereNotNull('student_id')
            ->pluck('student_id');
        // if (($ConsultantDefinitionDetail['session_date'] >= $startOfWeek)  && ($ConsultantDefinitionDetail['session_date'] <=  $endOfWeek)) {
        //     $StudentsExistInThisWeek = ConsultantDefinitionDetail::where('session_date', ">=", $startOfWeek)
        //         ->where('session_date', "<=", $endOfWeek)
        //         ->where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
        //         ->where('student_status', "!=", "absent")
        //         ->whereNotNull('student_id')
        //         ->pluck('student_id');
        // }
        // else if ((($ConsultantDefinitionDetail['session_date'] >= $nextWeekStartDate)  && ($ConsultantDefinitionDetail['session_date'] <=  $nextWeekEndDate))) {
        //     $nextweek = true;

        //     $StudentsExistInNextWeek = ConsultantDefinitionDetail::where('session_date', ">=", $nextWeekStartDate)
        //         ->where('session_date', "<=", $nextWeekEndDate)
        //         ->where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
        //         ->where('student_status', "!=", "absent")
        //         ->whereNotNull('student_id')
        //         ->pluck('student_id');
        // }

        //Log::info("studentds defined are:" . json_encode($StudentsExistInThisWeek ));

        // if ($nextweek) {
        //     $studentdsId = ConsultantFinancial::where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
        //         ->where('student_status', 'ok')
        //         ->whereNotIn('student_id', $StudentsExistInNextWeek)
        //         ->pluck('student_id');
        // } else {
        //     $studentdsId = ConsultantFinancial::where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
        //         ->where('student_status', 'ok')
        //         ->whereNotIn('student_id', $StudentsExistInThisWeek)
        //         ->pluck('student_id');
        // }

        $studentdsId = ConsultantFinancial::where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
            ->where('student_status', 'ok')
            ->whereNotIn('student_id', $StudentsExistInThisWeek)
            ->pluck('student_id');

        //Log::info($studentdsId);
        return  $studentdsId;
    }

    public function selectWeek($startOfWeek, $endOfWeek, $nextWeek = "Next")
    {
        switch ($nextWeek) {
            case ('Next'):
                $startWhichNextWeek =  Carbon::parse($startOfWeek)->addDays(self::Next)->format("Y-m-d");
                $endWhichNextWeek =   Carbon::parse($endOfWeek)->addDays(self::Next)->format("Y-m-d");
                break;
            case ('Next2week'):
                $startWhichNextWeek =  Carbon::parse($startOfWeek)->addDays(self::Next2week)->format("Y-m-d");
                $endWhichNextWeek =   Carbon::parse($endOfWeek)->addDays(self::Next2week)->format("Y-m-d");
                break;
            case ('Next3week'):
                $startWhichNextWeek =  Carbon::parse($startOfWeek)->addDays(self::Next3week)->format("Y-m-d");
                $endWhichNextWeek =   Carbon::parse($endOfWeek)->addDays(self::Next3week)->format("Y-m-d");
                break;
            case ('Next4week'):
                $startWhichNextWeek =  Carbon::parse($startOfWeek)->addDays(self::Next4week)->format("Y-m-d");
                $endWhichNextWeek =   Carbon::parse($endOfWeek)->addDays(self::Next4week)->format("Y-m-d");
                break;
            default:
                $startWhichNextWeek =  Carbon::parse($startOfWeek)->format("Y-m-d");
                $endWhichNextWeek =   Carbon::parse($endOfWeek)->format("Y-m-d");
        }

        return ([$startWhichNextWeek, $endWhichNextWeek]);
    }
}
