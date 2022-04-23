<?php

namespace App\Http\Utils;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class AuthenticationUtility
{
    public  function getUser(string  $email, string $password)
    {
        $user = new User();
        $user->email=$email;
        $user->password=$password;
        //$pass='$2a$12$e0sQIx0XYwAqKDHWLgsNC.qi7NSO18.3kz0s5lTBbGU34AKgrRfWe';//bcrypt($password);
        //dd($pass);
        
        // $response = Http::get('localhost:8002/api/login');
        // dd($response->getBody()); 
        //dd(env('REMOTE_SERVER'));
        $response = Http::post(env('REMOTE_SERVER')."login", [
            'email' => "$email",
            'password' => "$password"
        ]);
        ///dd($response->body());
       // dd($response->json());
        return $response->json();
        //return $user;
    }
}
