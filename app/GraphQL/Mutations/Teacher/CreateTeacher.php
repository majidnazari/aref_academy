<?php

namespace App\GraphQL\Mutations\Teacher;

use App\Models\Teacher;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class CreateTeacher
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
        //$user_id=Auth::user();
        $teacher_date=[
            'user_id_creator' => 1,
            'mobile' => $args['mobile'],
            'address' => $args['address'],
            'first_name' => $args['first_name'],
            'last_name' => $args['last_name'],
        ];
        $teacher_resut=Teacher::create($teacher_date);
        return $teacher_resut;

        // if($teacher_resut)
        // {
        //     $group_user_data=[
        //         'user_id_creator' => 1,
        //         'user_id' => $user_resut->id,
        //         'group_id' => $args['group_id'],
        //         'key' =>''
                
        //     ];
        //   if( !$group_user_result= GroupUser::create($group_user_data))
        //   {
        //     return [
        //         'status'  => 'Error',
        //         'message' => __('cannot create group user'),
        //     ];
        //   }
        //   return $user_resut;
          
        // }
        // return [
        //     'status'  => 'Error',
        //     'message' => __('cannot create user'),
        // ];
            
       
    }
}
