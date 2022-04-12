<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Resources\GeneralReource;
use Carbon\Carbon;

class AddCurentDateTimeToResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)// Cross-Origin Resource Sharing (CORS)
    {
        //return $next($request);
        $response = $next($request);      
        //return new GeneralReource($response);
        //Check if the response is JSON
        if (json_last_error() == JSON_ERROR_NONE) {

            return response()->json(["data"=>$response,'currentDateTime' => Carbon::now()->format('Y-m-d H:i:s')],200);
            // $response->setContent(json_encode(array_merge(
            //     $content,
            //     [                    
            //         'currentDateTime' => Carbon::now()->format('Y-m-d H:i:s')
            //     ]
            // )));
        }

        return $response;
    }
}
