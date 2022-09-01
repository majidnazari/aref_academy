<?php

namespace Tests\Unit;

use App\AuthFacade\CheckAuth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Repositories\UserRepository as UserRepo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\GraphQL\Mutations\User\ResetOtherUserPassword;
use App\Models\User;

//use App\Repositories\Interfaces\UserRepositoryInterface as userInterface;

class UserUnitTest extends TestCase 
{    
    //use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
     //private $repository;

    //  public function test_registerNewPassword()
    //  {
    //     $now=Carbon::now();
    //     $user= new User;
    //     $user->email="09351212120";
    //     $user->password=Hash::make("09351212120");
    //     $user->first_name="test";
    //     $user->last_name="test";
    //     $user->group_id=1;
    //     $user->branch_id=1;
    //     $user->created_at=$now;
    //     $user->updated_at=$now;


    //     // $user_tmp=[
    //     //     "email" => "09351212120",
    //     //     "password" => Hash::make("09351212120"),
    //     //     "first_name" => "test",
    //     //     "last_name" => "test",
    //     //     "group_id" => 1,            
    //     //     "created_at" => $now,
    //     //     "updated_at" =>$now
    //     // ];


    //     $newPassword="15995123";
    //     $email="09351212120";
    //     $ROP= new ResetOtherUserPassword;
    //     //$test=new CheckAuthth;
    //     //return $ROP->registerNewPassword($user,$newPassword, $email);
    //         $result= $ROP->registerNewPassword($user,$newPassword, $email);
    //         //return Hash::check($newPassword,$result->password);
    //    //$this->assertTrue(Hash::check("12345678",'$2a$12$wgKFkwHNtDQDUPQIaSwCweJZ4i7RrXH0aZkoBUgjZFcq5Cus3ZM5C'));
    //    $this->assertTrue(Hash::check($newPassword,$result->password));
    //    //$this->assertTrue($result->delete());
    //  }
    
    // public function test_UserCreate()
    // {  
    //     $user = User::factory()->create([
    //         "first_name" => "abbass"
    
    // ]);
    //     $response = $this->post(route('login'), [
    //         'email' => $user->email,
    //         'password' => 'password'
    //     ]);
    //     $response->assertRedirect(route('index'));
    //     $this->assertAuthenticatedAs($user);
    //     //$this->assertTrue(true);
    //     //$response = $this->get('/users');
    //    // $this->assertTrue($response);  
    //     //  $this->post('api/users', [
    //     //     'first_name' => 'John',
    //     //     'last_name' => 'Doe',
    //     //     'email' => 'johndoe@email.com',
    //     //     'password' => 'secret',
    //     //     'password_confirmation' => 'secret',
    //     //     'type' => "admin"
    //     // ]) ;
    //     // // ->assertRedirect('/home');
    //     // $this->assertDatabaseHas('users', ['first_name' => 'John']);
    //     // $data=[
    //     //     'password' =>"12345",
    //     //     'email' => "majid@gmail.com",
    //     //     'mobile' => "09372120890",
    //     //     'first_name' => "majid",
    //     //     'last_name' => "nazari",
    //     //     'type' => "admin"
    //     //    ];
    //     //    $response= User::create($data);
    //     // return $this->assertCount(1,$data,"the record doesn't created");
    // }
}
