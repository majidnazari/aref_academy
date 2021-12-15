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
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_UserFetchAll()
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
        //$user=User::factory()->make();
        //dd($user->toArray());
        $response_create = $this->post(route('User.store'), $user);    
        //dd($response_create);     
        $response_getAll = $this->get(route('User.index')); 
       //dd($response_getAll);
       $response_getAll->assertSee($user["email"]);
       $response_getAll->assertSee($user["mobile"]);
    }
    public function test_UserStore()
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
      // dd($user["mobile"]);
      //  $user=User::factory()->make();
        $response = $this->post(route('User.store'), $user);  
       // dd($response["id"]);    
        //$users = User::factory()->count(3)->make();       
        $this->assertGreaterThan(0,User::all()->count());        
       // $this->assertDatabaseCount('users', 1);
       $this->assertDatabaseHas('users', [
        'mobile' => $user["mobile"],
        'email' => $user["email"]
        ]);
        $user_response = User::where('email', $user["email"])->where('mobile', $user["mobile"])->first();
         $this->assertNotNull($user_response);        
    }
    public function test_UserUpdate()
    {   
        //$userExistId=User::where('id', '>', 0)->firstOrFail();    
       // $userExistId=User::where('id','>' ,0)->firstOrFail();
       // dd($userExistId);
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
        //$user=User::factory()->make();
        $response = $this->post(route('User.store'), $user);
        $anotherUser=self::userData();
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        $response = $this->put(route('User.update', $response['id']),$anotherUser);       
        // $this->assertDatabaseHas('users', [
        //     'mobile' =>  $mobile,
        //     'email' => $email
        //     ]);
        $user = User::where('email', $anotherUser["email"])->where('mobile', $anotherUser["mobile"])->first();
        $this->assertNotNull($user);
        // $this->assertAuthenticatedAs($user);
    }
    public function test_UserDelete()
    { 
        $user=self::userData();
       // $user=User::factory()->make(); 
        $response = $this->post(route('User.store'), $user);  
       // $userExistId=User::where('id','>' ,0)->firstOrFail();  
       // dd($response["id"]);     
        $responseDelete = $this->delete(route('User.destroy', $response["id"]));        
        $UserFound= User::withTrashed()->find($response["id"]);  
       //dd($UserFound);
        $this->assertSoftDeleted($UserFound);      
    }
    public  function  userData()
    {
        $arrayValues = ['admin', 'acceptor', 'financial','manager'];
        $email= $this->faker->unique()->safeEmail();
        $mobile=$this->faker->regexify('09[0-9]{9}');
        $user=[
            'first_name' => $this->faker->firstName,//"majid",
            'last_name' => $this->faker->lastName,//"hamidey",
            'mobile' =>  $mobile,
            'type' => $arrayValues[rand(0,3)],
            'email' => $email,           
            'password' => '12345', // password            
        ];
        return $user;
    }
}
