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

        foreach ($args['days'] as $day) {
            $dayOfWeek = Carbon::parse('next ' . $day)->toDateString();
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
}
