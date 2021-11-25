<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Repositories\UserRepository as UserRepo;
use Illuminate\Database\Eloquent\Factories\Factory;
//use App\Repositories\Interfaces\UserRepositoryInterface as userInterface;

class UserTest extends TestCase 
{
    //use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
     //private $repository;
    
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
