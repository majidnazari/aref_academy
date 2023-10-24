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
        $branch_class_room_ids= BranchClassRoom::where('branch_id',$branch_id)->pluck('id');
       // Log::info($branch_class_room_ids);

        $start_hour = $args['start_hour'];
        $end_hour = $args['end_hour'];
        $data = [];
        $error = [];

        $all_of_consultant_data_collection = ConsultantDefinitionDetail::where('consultant_id', $args['consultant_id'])
        ->whereIn('branch_class_room_id', $branch_class_room_ids);
        $all_of_consultant_data = $all_of_consultant_data_collection->get();
        // ->where('user_id', $user_id)
        // ->with('branchClassRoom')
        //->get();
        // $records =  $all_of_consultant_data;
        // $all_of_consultant_data = $all_of_consultant_data->get();
        // if (!$this->validateSession($args['start_hour'], $args['end_hour'], $records)) {
        //     throw new Exception("AAA");
        // }

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
                $is_exist = $this->validateSession($all_of_consultant_data_collection, $consultant_definition_detail_date);
                // return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-CREATE_RECORD_ALREADY_EXIST");                   

                if ($is_exist) {
                    $error[] = [
                        "date" => $consultant_definition_detail_date['session_date'],
                        "start_hour" => $consultant_definition_detail_date['start_hour'],
                        "end_hour" => $consultant_definition_detail_date['end_hour'],
                    ];
                    continue;
                    //return Error::createLocatedError("CONSULTANTDEFINITIONDETAIL-CREATE_RECORD_ALREADY_EXIST");                   
                }

                $data[] = $consultant_definition_detail_date;
            } while (Carbon::parse($start_hour)->addMinutes($args['step']) <= Carbon::parse($end_hour));
        }

        if ($error) {
            return Error::createLocatedError("duplicate is:" .  json_encode($error));
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

    private function validateSession($all_of_consultant_data_collection,  $consultant_definition_detail_date)
    {
        $is_exist="";
        $is_exist =  $all_of_consultant_data_collection  
            //->where('branch_class_room_id', $consultant_definition_detail_date['branch_class_room_id'])         
            ->where('consultant_id', $consultant_definition_detail_date['consultant_id'])
            ->where('session_date', $consultant_definition_detail_date['session_date'])
            ->where('start_hour', $consultant_definition_detail_date['start_hour'])
            ->where('end_hour', $consultant_definition_detail_date['end_hour'])
            ->orWhere(function ($query) use ($consultant_definition_detail_date) {

                $query->where('start_hour', '<=', $consultant_definition_detail_date['start_hour'])
                    ->where('end_hour', '>=', $consultant_definition_detail_date['end_hour'])
                    ->where('consultant_id', $consultant_definition_detail_date['consultant_id']);
            })
            ->orWhere(function ($query) use ($consultant_definition_detail_date) {

                $query->where('start_hour', '>=', $consultant_definition_detail_date['start_hour'])
                    ->where('end_hour', '<=', $consultant_definition_detail_date['end_hour'])
                    ->where('consultant_id', $consultant_definition_detail_date['consultant_id']);
            })
            ->orWhere(function ($query) use ($consultant_definition_detail_date) {

                $query->where('end_hour', '>', $consultant_definition_detail_date['start_hour'])
                    ->where('start_hour', '<', $consultant_definition_detail_date['end_hour'])
                    ->where('consultant_id', $consultant_definition_detail_date['consultant_id']);
            })
            ->first();
        
        //Log::info($is_exist);
        return  $is_exist;
    }
}
