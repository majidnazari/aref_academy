<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;



use App\Http\Utils\AutheticationUtility;

class ApiController extends Controller
{
    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('first_name','last_name','type','mobile', 'email', 'password');
        $validator = Validator::make($data, [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5|max:50',
            'mobile' => "required|string|size:11",
            'type' => "required"
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
        	'first_name' => $request->first_name,
        	'last_name' => $request->last_name,
        	'type' => $request->type,
        	'mobile' => $request->mobile,        	
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
 
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:5|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        //Request is validated
        //Crean token
        // try {
        //     if(!$user)
        //     {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Login fields are invalid.',
        //         ], 401);
        //     }
        //     if (! $token = JWTAuth::attempt($credentials)) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Login credentials are invalid.',
        //         ], 400);
        //     }
            
        // } catch (JWTException $e) {
    	// return $credentials;
        //     return response()->json([
        //         	'success' => false,
        //         	'message' => 'Could not create token.',
        //         ], 500);
        // }
        
        try { 
                $authUtil = new AutheticationUtility();       
                $user_tmp = $authUtil->getUser($request->email, $request->password);   
                $factory = \JWTFactory::customClaims($user_tmp);
                $payload = $factory->make();
                $token = JWTAuth::encode($payload);
                $tmp=explode('"',$token);
                //dd($token["-value"]);
                // dd($tmp[0]);
                // verify the credentials and create a token for the user
                if (!$tmp[0]) { 
                    return response()->json(['error' => 'invalid_token'], 401);
                } 
            } catch (JWTException $e) { 
                // something went wrong 
                return response()->json(['error' => 'could_not_create_token'], 500); 
            } 
 	
 		//Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $tmp[0],
        ],200);
    }
 
    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }
}