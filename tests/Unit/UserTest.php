<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Repositories\UserRepository as UserRepo;
//use App\Repositories\Interfaces\UserRepositoryInterface as userInterface;

class UserTest extends TestCase 
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // private $repository;
    // public function __construct(UserRepo $repository)
    // {
    //     $this->repository = $repository;
    // }   
	
   
    public function test_example()
    {
        $this->assertTrue(true);
    }
    public function UserCreate()
    {
       // $user=factory(User::class)->create();
       $req= [
        "mobile" => "09372120890",
        "first_name" => "majid",
        "last_name" => "nazar",
        "email" => "majid@gmail.com",
        "password" => bcrypt("123456"),
        "type" => "admin"//, "manager","financial","acceptor"]),         
       ];
        //$data= $this->repository->AddUser($req);
        $data=User::create($req);
        return $this->assertCount(1,$data,"the record doesn't created");
    }
}
