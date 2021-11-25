<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UseTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_w1()
    {
        // $date=[
        //     "first_name" => "majid",
        // ];
        // $user = User::factory()->create([
        //     'first_name' => "abdol". $this->faker->name(),
        //     //"password" =>  Hash::make("12345"),
        // ]);
        // $response = $this->post(route('login'), [
        //     'email' => $user->email,
        //     'password' => 'password'
        // ]);
        $arrayValues = ['admin', 'acceptor', 'financial','manager'];
        $email= $this->faker->unique()->safeEmail();
        $mobile=$this->faker->regexify('09[0-9]{9}');
        $user=[
            'first_name' => $this->faker->firstName,//"majid",
            'last_name' => $this->faker->firstName,//"hamidey",
            'mobile' =>  $mobile,
            'type' => $arrayValues[rand(0,3)],
            'email' => $email,
            //'email_verified_at' => now(),
            'password' => '12345', // password
            //'remember_token' => Str::random(10),
        ];
        $response = $this->post(route('User.store'), $user );
       // $response->assertRedirect(route('User.index'));
        //$this->assertAuthenticatedAs($user);
        //$users = User::factory()->count(3)->make();
        //$response = $this->get('/');

       // $response->assertStatus(200);
        $this->assertGreaterThan(0,User::all()->count());        
       // $this->assertDatabaseCount('users', 1);
       $this->assertDatabaseHas('users', [
        'mobile' =>  $mobile,
        'email' => $email
        ]);
        $user = User::where('email', $email)->where('mobile', $mobile)->first();
         $this->assertNotNull($user);
        // $this->assertAuthenticatedAs($user);
    }
}
