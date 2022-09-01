<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }
    // public function test_registerUser()
    // {
    //     $user=User::where("mobile","09372120890")->where('email',"majidnazarister@gmail.com")->first();
    //     if($user)
    //     {
    //         //$user->assertStatus(200);
    //         $this->assertTrue(true);
    //         return ($user);
    //     }
    //     $pass=bcrypt("12345");
    //     $data=[
    //         'first_name' => "majid",
    //         'last_name' => "nazari",
    //         'type' => "admin",
    //         'mobile' => "09372120890",        	
    //         'email' => "majidnazarister@gmail.com",
    //         'password' => $pass
    //     ];
       
    //     $user = User::create($data);
    //     $this->assertTrue(true);
    // }
}
