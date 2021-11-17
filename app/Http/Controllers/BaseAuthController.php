<?php

namespace App\Http\Controllers;
//use Illuminate\Contracts\Validation\Validator;
use Validator;
use Illuminate\Http\Request;
use JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BaseAuthController extends Controller
{
    
    /**
 * 
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function login(Request $request)
    {
       //return response()->json("h1",200);
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            $input = $request->only('email', 'password');
            $validator = Validator::make($input, $rules);
           
            if ($validator->fails()) {
                return response()->json("g",200);
                $error = $validator->messages()->toJson();
                return response()->json(['success' => false, 'error' => $error]);
            }
            //return response()->json("g1",200);
            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];
            $user=User::Where([
                'email' => $request->email,
                //'password' => md5($request->password)
            ])->first();

            //return response()->json($user,200);            
            try {
                $checkPass=Hash::check($request->password, $user->password);
                //return response()->json($checkPass,200);
               // return response()->json(JWTAuth::attempt($credentials),200);
                // attempt to verify the credentials and create a token for the user
                //if (!$token = JWTAuth::attempt($credentials)) {
                    if($checkPass){
                        if (!$token = JWTAuth::attempt($credentials)) { 
                                return response()->json("g",200);   
                            return response()->json(['success' => false, 'error' => 'Wrong email or password.'], 401);
                        }
                }
            } catch (JWTException $e) {
                return response()->json("g",200);
                return response()->json(['success' => false, 'error' => 'could_not_create_token'], 500);
            }
           
            return response()->json(['success' => true, 'data' => ['token' => $token]]);
    }

    public function register(Request $request)
    {
        // you registration section .... 
    }
    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $this->validate($request, ['token' => 'required']);
        try {
            JWTAuth::invalidate($request->input('token'));
            return response()->json(['success' => true]);
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'Destory faild'], 500);
        }
    }
}
