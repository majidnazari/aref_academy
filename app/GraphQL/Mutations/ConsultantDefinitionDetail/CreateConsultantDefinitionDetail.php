<?php

namespace App\GraphQL\Mutations\ConsultantDefinitionDetail;

use App\Models\ConsultantDefinitionDetail;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Carbon\Carbon;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

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
        $start_hour = $args['start_hour'];
        $end_hour = $args['end_hour'];
        $data=[];

        $all_of_consultant_data=ConsultantDefinitionDetail::where('consultant_id',$args['consultant_id'])
        ->where('user_id' , $user_id)
        // ->with('branchClassRoom')
        ->get();        

        $startOfWeek =($args['week']==="Next") ? Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDays(7)->format("Y-m-d"): Carbon::now()->startOfWeek(Carbon::SATURDAY)->format("Y-m-d");
        $endOfWeek =($args['week']==="Next") ? Carbon::now()->endOfWeek(Carbon::FRIDAY)->addDays(7)->format("Y-m-d"): Carbon::now()->endOfWeek(Carbon::FRIDAY)->format("Y-m-d");

        foreach ($args['days'] as $day) {
           // $dayOfWeek = Carbon::parse('next ' . $day)->toDateString();
            $dayOfWeek = Carbon::parse($startOfWeek)->addDays($this->getEnum($day))->toDateString();
            $start_hour = $args['start_hour'];
            $end_hour = $args['end_hour'];
            do {
                $next_time = Carbon::parse($start_hour)->addMinutes($args['step'])->format("H:i");

                $consultant_definition_detail_date = [
                    'consultant_id' => $args['consultant_id'],
                    'branch_class_room_id' => isset($args['branch_class_room_id']) ? $args['branch_class_room_id'] : null,
                    // 'branch_id' =>$all_of_consultant_data->branchClassRoom->branch_id,
                    'user_id' => $user_id,
                    'start_hour' => $start_hour,
                    'end_hour' => $next_time,
                    'step' => $args['step'],
                    'session_date' => $dayOfWeek,
                    'created_at' => $now,

                ];
                 $is_exist = $all_of_consultant_data->where('consultant_id',$args['consultant_id'])
                 ->where('branch_class_room_id',$args['branch_class_room_id'])
                 ->where('user_id',$user_id)
                 ->where('start_hour',$start_hour)
                 ->where('end_hour',$next_time)
                 ->where('step',$args['step'])
                 ->where('session_date',$dayOfWeek)
                 ->first();

                $start_hour = $next_time;

                if ($is_exist) {                  
                    continue;                   
                }               
                $data[]=$consultant_definition_detail_date ;
               
            } while (Carbon::parse($start_hour)->addMinutes($args['step']) < Carbon::parse($end_hour));
        }
        
        ConsultantDefinitionDetail::insert($data);       
        $result=ConsultantDefinitionDetail::whereNotIn('id',$all_of_consultant_data->pluck('id'))->get();        
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
}
