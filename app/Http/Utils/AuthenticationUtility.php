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
        $user->email = $email;
        $user->password = $password;
        $response = Http::post(env('REMOTE_SERVER') . "login", [
            'email' => "$email",
            'password' => "$password"
        ]);
        return $response->json();
    }
}
