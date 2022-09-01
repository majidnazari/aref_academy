<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Azmoon;


class AzmoonTest extends TestCase
{   
    // use WithFaker;
    // //use RefreshDatabase;
    // protected static $token=null;   

    // public function  loginUser()
    // {
    //     // $baseUrl = Config::get('app.url') . '/api/login';
    //     // $email = Config::get('api.apiEmail');
    //     // $password = Config::get('api.apiPassword');

    //     $baseUrl="localhost:8000/api/login";
    //     $email="majidnazarister@gmail.com";
    //     $password="12345";

    //     $response = $this->post(route("login"), [
    //         'email' => $email,
    //         'password' => $password
    //     ]);
    //     self::$token=$response["token"];
    //     $this->assertNotNull($response["token"]);
       
    // }
    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function test_getAllAzmoon()
    // {  
    //     if(self::$token===null)
    //     {
    //         $this->loginUser();
    //     }   
        
    //    // $this->withHeader('Authorization', 'Bearer ' . $this->token);
    //     $headers['Authorization'] = 'Bearer ' . self::$token;
    //     $azmoon=Azmoon::factory()->make();             
    //     $response_create = $this->post(route('Azmoon.store'),$azmoon->toArray(),$headers);
          
    //     $response_getAll = $this->get(route('Azmoon.index'),$headers); 
      
    //    $response_getAll->assertSee($azmoon["score"]);
    //    $response_getAll->assertSee($azmoon["user_id"]);
    //    $response_getAll->assertSee($azmoon["course_session_id"]);
    //    $response_getAll->assertSee($azmoon["isSMSsend"]);
    //    $response_getAll->assertSee($azmoon["course_id"]);
   
    // }
    // public function test_createAzmoon()
    // {  
    //     if(self::$token===null)
    //     {
    //         $this->loginUser();
    //     }  
    //     $headers['Authorization'] = 'Bearer ' . self::$token;  

    //     $azmoon=Azmoon::factory()->make(); 
    //     $response = $this->post(route('Azmoon.store'), $azmoon->toArray(),$headers);  
            
    //     $this->assertGreaterThan(0,Azmoon::all()->count());        
      
    //    $this->assertDatabaseHas('azmoons', [
    //     'user_id' => $azmoon["user_id"],
    //     'course_id' => $azmoon["course_id"],
    //     'course_session_id' => $azmoon["course_session_id"],
    //     'isSMSsend' => $azmoon["isSMSsend"],              
    //     'score' => $azmoon["score"],  
       
    //     ]);           
    // }
    // public function test_updateAzmoon()
    // { 
    //     if(self::$token===null)
    //     {
    //         $this->loginUser();
    //     }  
    //     $headers['Authorization'] = 'Bearer ' . self::$token;   
    //     $azmoon=Azmoon::factory()->make();
    //     $responseCreate = $this->post(route('Azmoon.store'), $azmoon->toArray(),$headers);
    //     $anotherAzmoon=self::azmoonData();

    //     $responseUpdate = $this->put(route('Azmoon.update', $responseCreate['id']),$anotherAzmoon,$headers);       
    //     $azmoonFounded = Azmoon::
    //     where('user_id', $anotherAzmoon["user_id"])
    //     ->where('course_id', $anotherAzmoon["course_id"])
    //     ->where('course_session_id', $anotherAzmoon["course_session_id"])
    //     ->where('isSMSsend', $anotherAzmoon["isSMSsend"])
    //     ->where('score', $anotherAzmoon["score"])        
    //     ->first();       
    //     $this->assertNotNull($azmoonFounded);
       
    // }
    // public function test_deleteAzmoon()
    // { 
    //     if(self::$token===null)
    //     {
    //         $this->loginUser();
    //     }        
    //      $this->withHeader('Authorization', 'Bearer ' .self::$token);
    //     $azmoon=Azmoon::factory()->make(); 
    //     $response = $this->post(route('Azmoon.store'), $azmoon->toArray());          
    //     $responseDelete = $this->delete( route('Azmoon.destroy', $response["id"])); 
           
    //     $AzmoonFound= Azmoon::withTrashed()->find($response["id"]);  
      
    //     $this->assertSoftDeleted($AzmoonFound);      
    // }    

    // public  function  azmoonData()
    // {   
    //     $user_id= $this->faker->randomDigit;
    //     $course_id= $this->faker->randomDigit;        
    //     $course_session_id= $this->faker->randomDigit;        
    //     $isSMSsend=$this->faker->boolean;
    //     $score=$this->faker->randomFloat(2, 10, 100);//randomFloat($decimals, $min, $max);
        
    //     $azmoon=[
    //         'user_id' => $user_id,
    //         'course_id' => $course_id,
    //         'course_session_id' => $course_session_id,
    //         'isSMSsend' => $isSMSsend,              
    //         'score' => $score,             
                        
    //     ];
    //     return $azmoon;
    // }

}
