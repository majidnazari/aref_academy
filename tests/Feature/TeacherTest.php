<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    use WithFaker;
    use refreshdatabase;
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
    public function test_teacherFetchAll()
    {  
        $teacher=$this->teacherData();       
        $response_create = $this->post(route('User.store'), $teacher);    
          
       $response_getAll = $this->get(route('User.index'));       
       $response_getAll->assertSee($teacher["first_name"]);
       $response_getAll->assertSee($teacher["last_name"]);
       $response_getAll->assertSee($teacher["mobile"]);
       $response_getAll->assertSee($teacher["address"]);
    }

    public  function  teacherData()
    {
        $arrayValues = ['admin', 'acceptor', 'financial','manager'];
        $email= $this->faker->unique()->safeEmail();
        $mobile=$this->faker->regexify('09[0-9]{9}');
        $user=[
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'mobile' =>  $mobile,
            'address' => $this->faker->address
            //'type' => $arrayValues[rand(0,3)],           
            //'email' => $email,  
        ];
        return $user;
    }
}
