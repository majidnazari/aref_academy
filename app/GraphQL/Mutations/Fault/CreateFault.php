<?php

namespace App\GraphQL\Mutations\Fault;

use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Fault;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Joselfonseca\LighthouseGraphQLPassport\Events\PasswordUpdated;
use Joselfonseca\LighthouseGraphQLPassport\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Error\Error;

final class CreateFault
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
        $user_id=auth()->guard('api')->user()->id;
        $fault_date=[
            'user_id_creator' => $user_id,
            "description" => $args['description'] 
        ];
        $is_exist= Fault::where($fault_date)       
        ->first();
        if($is_exist)
         {
                 return Error::createLocatedError("FAULT-CREATE-RECORD_IS_EXIST");
         }
        $fault_result=Fault::create($fault_date);
        return $fault_result;
          
        //  $ops=explode(' ',"5 2 C D +");
       
        //  $sulotion=new Sulotion($ops);
        //  $output=$sulotion->CalPoints($ops);
        //  return  $output;   
    }

    
}
// class Sulotion{

//     function CalPoints($ops)
//     {
//         $arr_tmp=[];
//         $i=0;
//         $total=0;
//         foreach($ops as $op)
//         {
//             switch ($op){
                
//                 case "C":  
//                     //return $i;
//                     //return $arr_tmp[$i-1];
//                     $key=$i-1; 
//                     array_splice($arr_tmp,$key, 1);                  
//                     //$arr_tmp[$i-1]=0;
//                     $i--;
//                    // return $arr_tmp[$i-1];
//                     break;
//                 case "D":
//                     //return $i;
//                     //return $arr_tmp[$i-1]*2;
//                     $arr_tmp[$i]=$arr_tmp[$i-1]*2;
//                     $i++;
//                     break;
//                 case "+":

//                     $arr_tmp[$i]=$arr_tmp[$i-1]+$arr_tmp[$i-2];
//                     $i++;
//                     break;
//                 default:    
//                     $arr_tmp[$i]=$op;
//                     $i++;
                   

//             }
           

//         }        
//         foreach($arr_tmp as $arr)
//         {
//             $total+=$arr;
//         }
//         return $total;
//     }
// }
