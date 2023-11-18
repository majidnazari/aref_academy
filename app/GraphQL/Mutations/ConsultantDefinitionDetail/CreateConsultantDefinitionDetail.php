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
use Log;

final class CreateConsultantDefinitionDetail
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
        $now = Carbon::now();
        $user_id = auth()->guard('api')->user()->id;
        $branch_id = auth()->guard('api')->user()->branch_id;
        $branch_class_room_ids = BranchClassRoom::where('branch_id', $branch_id)->pluck('id');
        // Log::info($branch_class_room_ids);

        $start_hour = $args['start_hour'];
        $end_hour = $args['end_hour'];
        $data = [];
        $error = [];

        $all_of_consultant_data_collection = ConsultantDefinitionDetail::where('consultant_id', $args['consultant_id'])
            ->whereIn('branch_class_room_id', $branch_class_room_ids);
        $all_of_consultant_data = $all_of_consultant_data_collection->get();       

        $startOfWeek = ($args['week'] === "Next") ? Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(7)->format("Y-m-d") : Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        // $endOfWeek = ($args['week'] === "Next") ? Carbon::now()->endOfWeek(Carbon::FRIDAY)->addDays(7)->format("Y-m-d") : Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

        foreach ($args['days'] as $day) {
            // $dayOfWeek = Carbon::parse('next ' . $day)->toDateString();
            $dayOfWeek = Carbon::parse($startOfWeek)->addDays($this->getEnum($day))->toDateString();
            $start_hour = $args['start_hour'];
            $end_hour = $args['end_hour'];
            do {
                $next_time = Carbon::parse($start_hour)->addMinutes($args['step'])->format("H:i");
                if ($next_time > $end_hour) {
                    return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-CREATE_STEP_IS_INVALID");
                    //return Error::createLocatedError("ایجاد زمانبندی روزانه: گام برنامه اشتباه تعریف شده است.");
                }

                $consultant_definition_detail_date = [
                    'consultant_id' => $args['consultant_id'],
                    'branch_class_room_id' => $args['branch_class_room_id'],
                    // 'branch_id' =>$all_of_consultant_data->branchClassRoom->branch_id,
                    'user_id' => $user_id,
                    'start_hour' => $start_hour,
                    'end_hour' => $next_time,
                    'step' => $args['step'],
                    'session_date' => $dayOfWeek,
                    'created_at' => $now,

                ];
                $start_hour = $next_time;

                // $is_exist =  $all_of_consultant_data_collection
                //     //->where('consultant_id', $consultant_definition_detail_date['consultant_id'])                    
                //     ->where('start_hour', $consultant_definition_detail_date['start_hour'])
                //     ->where('end_hour', $consultant_definition_detail_date['end_hour'])                  
                //     ->where('session_date', $consultant_definition_detail_date['session_date'])
                //     ->first();
                //     Log::info(json_encode($all_of_consultant_data_collection));
                //     Log::info("existance is:"  . $is_exist);
                $is_exist_consultant = $this->validateSessionConsultant($all_of_consultant_data_collection, $consultant_definition_detail_date);
                // return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-CREATE_RECORD_ALREADY_EXIST");                   

                if ($is_exist_consultant) {
                    $error[] = [
                        "date" => $consultant_definition_detail_date['session_date'],
                        "start_hour" => $consultant_definition_detail_date['start_hour'],
                        "end_hour" => $consultant_definition_detail_date['end_hour'],
                        "branch_class_room_id" => $consultant_definition_detail_date['branch_class_room_id'],
                        "consultant_id" => $consultant_definition_detail_date['consultant_id'],
                    ];
                    continue;
                    //return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-CREATE_RECORD_ALREADY_EXIST");                   
                }
                $is_exist_class_room = $this->validateSessionClassRoom($all_of_consultant_data_collection, $consultant_definition_detail_date);
               
                if ($is_exist_class_room) {
                    $error[] = [
                        "date" => $consultant_definition_detail_date['session_date'],
                        "start_hour" => $consultant_definition_detail_date['start_hour'],
                        "end_hour" => $consultant_definition_detail_date['end_hour'],
                        "branch_class_room_id" => $consultant_definition_detail_date['branch_class_room_id'],
                        "consultant_id" => $consultant_definition_detail_date['consultant_id'],
                    ];
                    continue;
                }

                $data[] = $consultant_definition_detail_date;
            } while (Carbon::parse($start_hour)->addMinutes($args['step']) <= Carbon::parse($end_hour));
        }

        if ($error) {
            //return Error::createLocatedError("duplicate is:" .  json_encode($error));
            return Error::createLocatedError("ایجاد زمانبندی روزانه : تایم های تکراری شامل:" .  json_encode($error));
        }

        // foreach ($args['days'] as $day) {
        //     // $dayOfWeek = Carbon::parse('next ' . $day)->toDateString();
        //     $dayOfWeek = Carbon::parse($startOfWeek)->addDays($this->getEnum($day))->toDateString();
        //     $start_hour = $args['start_hour'];
        //     $end_hour = $args['end_hour'];
        //     do {
        //         $next_time = Carbon::parse($start_hour)->addMinutes($args['step'])->format("H:i");

        //         $consultant_definition_detail_date = [
        //             'consultant_id' => $args['consultant_id'],
        //             'branch_class_room_id' => isset($args['branch_class_room_id']) ? $args['branch_class_room_id'] : null,
        //             // 'branch_id' =>$all_of_consultant_data->branchClassRoom->branch_id,
        //             'user_id' => $user_id,
        //             'start_hour' => $start_hour,
        //             'end_hour' => $next_time,
        //             'step' => $args['step'],
        //             'session_date' => $dayOfWeek,
        //             'created_at' => $now,

        //         ];
        //         $is_exist = $all_of_consultant_data->where('consultant_id', $args['consultant_id'])
        //             // ->where('branch_class_room_id',$args['branch_class_room_id'])
        //             // ->where('user_id',$user_id)
        //             ->where('start_hour', $start_hour)
        //             ->where('end_hour', $next_time)
        //             //->where('step',$args['step'])
        //             ->where('session_date', $dayOfWeek)
        //             ->first();

        //         $start_hour = $next_time;

        //         if ($is_exist) {
        //             continue;
        //             //return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-CREATE_RECORD_ALREADY_EXIST");                   
        //         }
        //         $data[] = $consultant_definition_detail_date;
        //     } while (Carbon::parse($start_hour)->addMinutes($args['step']) <= Carbon::parse($end_hour));
        // }

        ConsultantDefinitionDetail::insert($data);
        $result = ConsultantDefinitionDetail::whereNotIn('id', $all_of_consultant_data->pluck('id'))->get();
        return $result;
    }

    public function getEnum(string $day)
    {
        switch ($day) {
            case "Saturday":
                return 0;
                //return Carbon::SATURDAY;
            case "Sunday":
                return 1;
                // return Carbon::SUNDAY;
            case "Monday":
                return 2;
                //return Carbon::MONDAY;
            case "Tuesday":
                return 3;
                //return Carbon::TUESDAY;
            case "Wednesday":
                return 4;
                //return Carbon::WEDNESDAY;
            case "Thursday":
                return 5;
                // return Carbon::THURSDAY;
            case "Friday":
                return 6;
                //return Carbon::FRIDAY;

        }
    }

    public function validateSessionConsultant($all_times_of_next_week_collection,  $target_session_time_want_to_check_next_week)
    {

        $all_times_of_next_week_collection_copy = clone $all_times_of_next_week_collection;
        //Log::info("inner all are:" . json_encode($all_times_of_next_week_collection));
        // Log::info("inner target is:" . json_encode($target_session_time_want_to_check_next_week));
        $target_session_date = $target_session_time_want_to_check_next_week;
        $is_exist = "";
        $is_exist =  $all_times_of_next_week_collection_copy
            //->where('branch_class_room_id', $consultant_definition_detail_date['branch_class_room_id'])         
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

        //Log::info("validateSessionConsultant is:" . json_encode($is_exist));
        return  $is_exist;
    }


    public function copyWeekTimeTable($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $user_id = auth()->guard('api')->user()->id;
        $consultant_id = $args['consultant_id'];
        $error = [];
        $start_hours = [];
        $end_hours = [];
        $session_date = [];
        $data = [];

        $startOfWeek =  Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        $endOfWeek =  Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(6)->format("Y-m-d");

        $getAllOfConsultantTimeTableCurrentWeeks = ConsultantDefinitionDetail::where('consultant_id', $consultant_id)
            ->where('session_date', '>=',  $startOfWeek)
            ->where('session_date', '<=', $endOfWeek)
            ->orderBy('session_date', 'desc')
            ->get();

        $getAllDaysOfCurrentWeekHasPlaned = ConsultantDefinitionDetail::where('consultant_id', $consultant_id)
            ->where('session_date', '>=',  $startOfWeek)
            ->where('session_date', '<=', $endOfWeek)
            ->orderBy('session_date', 'asc')
            ->distinct()
            ->pluck('session_date');
        // ->get();

        //Log::info("getAllDaysOfCurrentWeekHasPlaned is:" .  $getAllDaysOfCurrentWeekHasPlaned);

        $getAllOfConsultantTimeTableNextWeeksQueryBuilder = ConsultantDefinitionDetail::where('consultant_id', $consultant_id)
            ->where('session_date', '>=', Carbon::parse($startOfWeek)->addDays(7)->format("Y-m-d"))
            ->where('session_date', '<=', Carbon::parse($endOfWeek)->addDays(7)->format("Y-m-d"));
        // ->get();

        // Log::info("getAllOfConsultantTimeTableNextWeeksQueryBuilder is:" .  json_encode($getAllOfConsultantTimeTableNextWeeksQueryBuilder->get()));

        //$getAllOfConsultantTimeTableNextWeeks = $getAllOfConsultantTimeTableNextWeeksQueryBuilder->get();

        foreach ($getAllDaysOfCurrentWeekHasPlaned as $one_day) {

            $next_week_of_this_current_day = Carbon::parse($one_day)->addDays(7)->format("Y-m-d");

            $current_day_start_times = $getAllOfConsultantTimeTableCurrentWeeks->where('session_date', $one_day)
                ->pluck('start_hour')
                ->toArray();

            //Log::info("current times are:" . json_encode($current_day_start_times));

            $current_day_end_times = $getAllOfConsultantTimeTableCurrentWeeks->where('session_date', $one_day)
                ->pluck('end_hour')
                ->toArray();


            $current_day_class_id = $getAllOfConsultantTimeTableCurrentWeeks->where('session_date', $one_day)
                ->pluck('branch_class_room_id')
                ->toArray();
            $steps = $getAllOfConsultantTimeTableCurrentWeeks->where('session_date', $one_day)
                ->pluck('step')
                ->toArray();

            $combined_start_end_times = array_map(null, $current_day_start_times,  $current_day_end_times, $current_day_class_id, $steps);


            //$combined_start_end_times = array_combine($current_day_start_times,  $current_day_end_times);

            foreach ($combined_start_end_times as [$start, $end, $class_id, $steps]) {

                $session_to_check_in_next_week = [
                    "consultant_id" => $consultant_id,
                    "start_hour" => $start,
                    "end_hour" => $end,
                    "session_date" => $next_week_of_this_current_day,
                    "branch_class_room_id" => $class_id,
                    "user_id" => $user_id,
                    "step" =>  $steps

                ];

                //Log::info("target  is:" . json_encode($session_to_check_in_next_week));

                //Log::info("all  are :" . json_encode($getAllOfConsultantTimeTableNextWeeksQueryBuilder->get()));

                $is_exist = $this->validateSessionConsultant($getAllOfConsultantTimeTableNextWeeksQueryBuilder,  $session_to_check_in_next_week);

                //Log::info("is_exist  is:" . json_encode($is_exist));

                if ($is_exist) {
                    $error[] = $session_to_check_in_next_week;
                }

                $data[] = $session_to_check_in_next_week;
            }
        }
        if ($error) {
            //return response()->json(['error' => 'Records found in the model.'], Response::HTTP_UNPROCESSABLE_ENTITY);
            return Error::createLocatedError("ایجاد زمانبندی روزانه : برنامه هفتگی تکراری است:" .  json_encode($error));
            //return Error::createLocatedError("duplicates are: " .  json_encode($error));
            
        }
        $copy_definition_details_time_tables = ConsultantDefinitionDetail::insert($data);
        return null;

        // return (new ConsultantDefinitionDetail($copy_definition_details_time_tables))
        //     ->response()
        //     ->setStatusCode(201);
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
}
