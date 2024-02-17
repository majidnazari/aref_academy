<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\BranchClassRoom;
use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Carbon\Carbon;
use Exception;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

use Log;

final class CopyOneDayTimeTable
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
    }

    public function validateSessionConsultant($all_times_of_next_week_collection,  $target_session_time_want_to_check_next_week)
    {

        $all_times_of_next_week_collection_copy = clone $all_times_of_next_week_collection;
        $target_session_date = $target_session_time_want_to_check_next_week;
        $is_exist = "";
        $is_exist =  $all_times_of_next_week_collection_copy
            ->where('consultant_id', $target_session_date['consultant_id'])
            ->where('session_date', $target_session_date['session_date'])
            ->where('start_hour', $target_session_date['start_hour'])
            ->where('end_hour', $target_session_date['end_hour'])
            ->orWhere(function ($query) use ($target_session_date) {

                $query->where('start_hour', '<=', $target_session_date['start_hour'])
                    ->where('end_hour', '>=', $target_session_date['end_hour'])
                    ->where('consultant_id', $target_session_date['consultant_id'])
                    ->where('session_date', $target_session_date['session_date']);
            })
            ->orWhere(function ($query) use ($target_session_date) {

                $query->where('start_hour', '>=', $target_session_date['start_hour'])
                    ->where('end_hour', '<=', $target_session_date['end_hour'])
                    ->where('consultant_id', $target_session_date['consultant_id'])
                    ->where('session_date', $target_session_date['session_date']);
            })
            ->orWhere(function ($query) use ($target_session_date) {

                $query->where('end_hour', '>', $target_session_date['start_hour'])
                    ->where('start_hour', '<', $target_session_date['end_hour'])
                    ->where('consultant_id', $target_session_date['consultant_id'])
                    ->where('session_date', $target_session_date['session_date']);
            })
            ->first();

        //Log::info("validateSession is:" . json_encode($is_exist));
        return  $is_exist;
    }

    public function validateSessionClassRoom($all_times_of_next_week_collection,  $target_session_time_want_to_check_next_week)
    {

        $all_times_of_next_week_collection_copy = clone $all_times_of_next_week_collection;
        //Log::info("inner all are:" . json_encode($all_times_of_next_week_collection));
        // Log::info("inner target is:" . json_encode($target_session_time_want_to_check_next_week));
        $target_session_date = $target_session_time_want_to_check_next_week;
        $is_exist = "";
        $is_exist =  $all_times_of_next_week_collection_copy
            //->where('branch_class_room_id', $consultant_definition_detail_date['branch_class_room_id'])         
            ->where('branch_class_room_id', $target_session_date['branch_class_room_id'])
            ->where('session_date', $target_session_date['session_date'])
            ->where('start_hour', $target_session_date['start_hour'])
            ->where('end_hour', $target_session_date['end_hour'])
            ->orWhere(function ($query) use ($target_session_date) {

                $query->where('start_hour', '<=', $target_session_date['start_hour'])
                    ->where('end_hour', '>=', $target_session_date['end_hour'])
                    ->where('branch_class_room_id', $target_session_date['branch_class_room_id'])
                    ->where('session_date', $target_session_date['session_date']);
            })
            ->orWhere(function ($query) use ($target_session_date) {

                $query->where('start_hour', '>=', $target_session_date['start_hour'])
                    ->where('end_hour', '<=', $target_session_date['end_hour'])
                    ->where('branch_class_room_id', $target_session_date['branch_class_room_id'])
                    ->where('session_date', $target_session_date['session_date']);
            })
            ->orWhere(function ($query) use ($target_session_date) {

                $query->where('end_hour', '>', $target_session_date['start_hour'])
                    ->where('start_hour', '<', $target_session_date['end_hour'])
                    ->where('branch_class_room_id', $target_session_date['branch_class_room_id'])
                    ->where('session_date', $target_session_date['session_date']);
            })
            ->first();

        //Log::info("validateSessionConsultant is:" . json_encode($is_exist));
        return  $is_exist;
    }


    public function CopyOneConsulatntDayTimeTable($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $user_id = auth()->guard('api')->user()->id;
        $consultant_id = $args['input']['consultant_id'];
        $target_date = $args['input']['session_date'];

        $now=Carbon::now()->format("Y-m-d");
         //Log::info("now is:"  . $now . " and session_date is:" .$consultantDefinition['session_date'] );        

        if($target_date < $now) {
            return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-UPDATE_DAY_HAS_PASSED");

        }

        $dateToCheck = Carbon::parse( $target_date); 

        $weekStartDate =  Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        $weekEndDate = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(6)->format("Y-m-d");

        // Check if the date falls within the current week
        $isInCurrentWeek = $dateToCheck->between($weekStartDate, $weekEndDate);

        if(!$isInCurrentWeek){
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-COPY_DATE_IS_NOT_IN_THIS_WEEK");
            //return Error::createLocatedError("کپی برنامه روزانه: روز مورد در نظر در هفته جاری نیست.");

        }

        // Log::info($isInCurrentWeek);
        // return null;

        // if ($isInCurrentWeek) {
        //     echo "The date is in the current week.";
        // } else {
        //     echo "The date is not in the current week.";
        // }

        $error = [];
        $data = [];

        $timeTablesOfThisDay = ConsultantDefinitionDetail::where('session_date',  $target_date)
            ->where('consultant_id', $consultant_id);
        $timeTablesOfThisDay_tmp = $timeTablesOfThisDay;
        $timeTablesOfThisDay = $timeTablesOfThisDay->get();

        $next_session = Carbon::parse($target_date)->addDays(7)->format("Y-m-d");
        $timeTablesOfThisDayNextWeek = ConsultantDefinitionDetail::where('session_date',  $next_session)
            ->where('consultant_id', $consultant_id);
        // ->get();

        if (empty($timeTablesOfThisDay)) {
            return Error::createLocatedError("COUNSULTANT-DEFINITION-DETAIL-COPY_THIS_DAY_NOT_FOUND");
            //return Error::createLocatedError("کپی برنامه روزانه : روز مورد نظر یافت نشد.");
        }



        $current_day_start_times = $timeTablesOfThisDay_tmp->where('session_date', $target_date)
            ->pluck('start_hour')
            ->toArray();

        //Log::info("current times are:" . json_encode($current_day_start_times));

        $current_day_end_times = $timeTablesOfThisDay_tmp->where('session_date', $target_date)
            ->pluck('end_hour')
            ->toArray();

            $current_day_class_id = $timeTablesOfThisDay_tmp->where('session_date', $target_date)
            ->pluck('branch_class_room_id')
            ->toArray();

        $steps = $timeTablesOfThisDay_tmp->where('session_date', $target_date)
            ->pluck('step')
            ->toArray();


        $combined_start_end_times = array_map(null, $current_day_start_times,  $current_day_end_times, $current_day_class_id, $steps);

        foreach ($combined_start_end_times as [$start, $end, $class_id, $steps]) {

            $session_to_check_in_next_week = [
                "consultant_id" => $consultant_id,
                "start_hour" => $start,
                "end_hour" => $end,
                "session_date" =>  $next_session ,
                "branch_class_room_id" => $class_id,
                "user_id" => $user_id,
                "step" =>  $steps

            ];

            // Log::info($start . " -- " . $end);
            $is_exist_consultant = $this->validateSessionConsultant($timeTablesOfThisDayNextWeek,  $session_to_check_in_next_week);
            if ($is_exist_consultant) {
                $error[] = $session_to_check_in_next_week;
            }
            $is_exist_class_room = $this->validateSessionClassRoom($timeTablesOfThisDayNextWeek,  $session_to_check_in_next_week);
            if ($is_exist_class_room) {
                $error[] = $session_to_check_in_next_week;
            }
            $data[] = $session_to_check_in_next_week;
        }

        if ($error) {
            //return response()->json(['error' => 'Records found in the model.'], Response::HTTP_UNPROCESSABLE_ENTITY);
           // return Error::createLocatedError("duplicate is:" .  json_encode($error));
            return Error::createLocatedError("کپی برنامه روزانه: جلسات مورد نظر تکراری است:" .  json_encode($error));
        }
        $copy_definition_details_time_tables = ConsultantDefinitionDetail::insert($data); 

        foreach ($data as $recordData) {// just fire the created event for create report record
            $model = new ConsultantDefinitionDetail;
            $model->fill($recordData);
            Event::dispatch('eloquent.created: ' . get_class($model), $model);
        }

        return null;
    }
}
