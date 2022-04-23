<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_userFetchAll()
    {    
        // $arrayValues = ['admin', 'acceptor', 'financial','manager'];
        // $email= $this->faker->unique()->safeEmail();
        // $mobile=$this->faker->regexify('09[0-9]{9}');
        // $user=[
        //     'first_name' => $this->faker->firstName,//"majid",
        //     'last_name' => $this->faker->lastName,//"hamidey",
        //     'mobile' =>  $mobile,
        //     'type' => $arrayValues[rand(0,3)],
        //     'email' => $email,
        //     //'email_verified_at' => now(),
        //     'password' => '12345', // password
        //     //'remember_token' => Str::random(10),
        // ];
        $user=self::userData();       
        $response_create = $this->post(route('User.store'), $user);    
          
        $response_getAll = $this->get(route('User.index')); 
      
       $response_getAll->assertSee($user["email"]);
       $response_getAll->assertSee($user["mobile"]);
    }
    public function test_userStore()
    {        
        // $arrayValues = ['admin', 'acceptor', 'financial','manager'];
        // $email= $this->faker->unique()->safeEmail();
        // $mobile=$this->faker->regexify('09[0-9]{9}');
        // $user=[
        //     'first_name' => $this->faker->firstName,//"majid",
        //     'last_name' => $this->faker->lastName,//"hamidey",
        //     'mobile' =>  $mobile,
        //     'type' => $arrayValues[rand(0,3)],
        //     'email' => $email,
        //     //'email_verified_at' => now(),
        //     'password' => '12345', // password
        //     //'remember_token' => Str::random(10),
        // ];
        $user=self::userData();
      
        $response = $this->post(route('User.store'), $user);  
           
        $this->assertGreaterThan(0,User::all()->count());        
      
       $this->assertDatabaseHas('users', [
        'mobile' => $user["mobile"],
        'email' => $user["email"]
        ]);
        $user_response = User::where('email', $user["email"])->where('mobile', $user["mobile"])->first();
         $this->assertNotNull($user_response);        
    }
    public function test_userUpdate()
    {   
        //$userExistId=User::where('id', '>', 0)->firstOrFail();    
       // $userExistId=User::where('id','>' ,0)->firstOrFail();      
        //$arrayValues = ['admin', 'acceptor', 'financial','manager'];
        // $email= $this->faker->unique()->safeEmail();
        // $mobile=$this->faker->regexify('09[0-9]{9}');
        // $user=[
        //     'first_name' => $this->faker->firstName,//"majid",
        //     'last_name' => $this->faker->lastName,//"hamidey",
        //     'mobile' =>  $user["mobile"],
        //     'type' => $arrayValues[rand(0,3)],
        //     'email' => $user["email"],           
        //     'password' => '12345', // password            
        // ];
        $user=self::userData();
       
        $response = $this->post(route('User.store'), $user);
        $anotherUser=self::userData();
      
        $response = $this->put(route('User.update', $response['id']),$anotherUser);       
        
        $user = User::where('email', $anotherUser["email"])->where('mobile', $anotherUser["mobile"])->first();
        $this->assertNotNull($user);
       
    }
    public function test_userDelete()
    { 
        $user=self::userData();
       
        $response = $this->post(route('User.store'), $user);  
         
        $responseDelete = $this->delete(route('User.destroy', $response["id"]));        
        $UserFound= User::withTrashed()->find($response["id"]);  
       
        $this->assertSoftDeleted($UserFound);      
    }
    public  function  userData()
    {
        $arrayValues = ['admin', 'acceptor', 'financial','manager'];
        $email= $this->faker->unique()->safeEmail();
        $mobile=$this->faker->regexify('09[0-9]{9}');
        $user=[
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'mobile' =>  $mobile,
            'type' => $arrayValues[rand(0,3)],
            'email' => $email,           
            'password' => '12345',          
        ];
        return $user;
    }
}
