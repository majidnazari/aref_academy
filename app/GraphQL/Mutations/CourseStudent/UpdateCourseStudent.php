<?php

namespace App\GraphQL\Mutations\CourseStudent;

use App\Models\CourseStudent;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;
use Illuminate\Support\Facades\DB;
use Log;

final class UpdateCourseStudent
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
        // $type = DB::select( DB::raw("SHOW COLUMNS FROM `course_students` WHERE Field = 'student_status' ") )[0]->Type;
        // preg_match('/^enum\((.*)\)$/', $type, $matches);
        // $enum = array();
        // foreach( explode(',', $matches[1]) as $value )
        // {
        //   $v = trim( $value, "'" );
        //   $enum = array_add($enum, $v, $v);
        // }
        // Log::info(" enums is : " .  $enum);

        $user_id=auth()->guard('api')->user()->id;

        $args["user_id_creator"]=$user_id;
        $CourseStudente=CourseStudent::find($args['id']);
        ///$args['course_id']=$CourseStudente->course_id;
        
        if(!$CourseStudente)
        {
                return Error::createLocatedError("COURSESTUDENT-UPDATE-RECORD_NOT_FOUND");
        }       
        //$res=(in_array($args['student_status'],["refused_pending","fired_pending"]));
        //Log::info("student status is :" .  (in_array($args['student_status'],["refused_pending","fired_pending"])==false));
         if((auth()->guard('api')->user()->group->type=="acceptor") && (in_array($args['student_status'],["refused_pending","fired_pending"])==false))
         {
            return Error::createLocatedError("COURSESTUDENT-UPDATE-ACTION_FORBIDEN");
         }
         if(isset($args['financial_status']) ){ 
            $CourseStudente['financial_status_updated_at']=Carbon::now();         
        }
        $CourseStudente_result= $CourseStudente->fill($args);
        if(isset($args['student_status'])){
           
            $CourseStudente['user_id_student_status']=$user_id;            
        }
        if(isset($args['financial_status'])){
            
            $CourseStudente['user_id_financial']=$user_id;                     
        }
        if(isset($args['manager_status'])){
           
            $CourseStudente['user_id_manager']=$user_id;            
        }
        
        $CourseStudente_result->save();       
       
        return $CourseStudente_result;
        
    }
}
