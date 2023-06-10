<?php

namespace App\Http\Controllers;

use App\Http\Utils\AutheticationUtility;
use Validator;
use Illuminate\Http\Request;
use JWTAuth;
use Throwable;

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
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $input = $request->only('email', 'password');
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            $error = $validator->messages()->toJson();
            return response()->json(['success' => false, 'error' => $error]);
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $authUtil = new AutheticationUtility();
        try {
            $user = $authUtil->getUser($request->email, $request->password);
            if (!$token = JWTAuth::attempt($credentials)) {

                return response()->json(['success' => false, 'error' => 'Wrong email or password.'], 401);
            }
        } catch (Throwable $e) {

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
