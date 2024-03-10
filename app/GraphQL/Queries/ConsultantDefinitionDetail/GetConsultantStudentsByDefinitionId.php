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

       
        $ConsultantDefinitionDetail = ConsultantDefinitionDetail::where('id', $args['id'])
            // ->whereHas('branchClassRoom.branch', function ($query) use ($branches_id) {
            //     return $query->whereIn('id', $branches_id);
            // })
            // ->with('branchClassRoom.branch')
            ->first();

        $currentWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->week;
        $targetWeek = Carbon::parse($ConsultantDefinitionDetail['session_date'])
            ->startOfWeek(Carbon::SATURDAY)->weekOfYear;

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

        $week = $whichWeek;
        // $startOfCurrentWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        // $endOfCurrentWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(6)->format("Y-m-d");

        // [$startOfWeek, $endOfWeek] = $this->selectWeek($startOfCurrentWeek, $endOfCurrentWeek, $week);

        $today=Carbon::now()->format("Y-m-d");

        if (!$ConsultantDefinitionDetail) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-GET_INVALID_ID");
            //return Error::createLocatedError("نمایش جلسات مشاور:شماره رکورد مورد نظر اشتباه است.");
        }

        // $StudentsExistInThisWeek = ConsultantDefinitionDetail::where('session_date', ">=", $startOfWeek)
        //     ->where('session_date', "<=", $endOfWeek)
        //     ->where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
        //     ->where('student_status', "!=", "absent")
        //     ->whereNotNull('student_id')
        //     ->pluck('student_id');

        $targetDay = $ConsultantDefinitionDetail['session_date'];

        $StudentsExistInThisDay = ConsultantDefinitionDetail::where('session_date', $targetDay)
        // ->where('session_date', "<=", $endOfWeek)
        ->where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
        ->where('student_status', "!=", "absent")
        ->whereNotNull('student_id')
        ->pluck('student_id');

        Log::info("the student todays are:" . json_encode($StudentsExistInThisDay));        

        $allStudentsIdNotSelectedThisDay = ConsultantFinancial::where('consultant_id', $ConsultantDefinitionDetail->consultant_id)
        ->where('student_status', 'ok')
        ->whereNotIn('student_id', $StudentsExistInThisDay)
        ->pluck('student_id');

        Log::info("all students not seletec this day" . json_encode($allStudentsIdNotSelectedThisDay));
        return  $allStudentsIdNotSelectedThisDay;
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
