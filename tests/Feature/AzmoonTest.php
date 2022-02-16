<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Azmoon;


class AzmoonTest extends TestCase
{   
    use WithFaker;
   // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_azmoonFetchAll()
    {  
       
        $azmoon=Azmoon::factory()->make();             
        $response_create = $this->post(route('Azmoon.store'),$azmoon->toArray());
               
        $response_getAll = $this->get(route('Azmoon.index')); 
      
       $response_getAll->assertSee($azmoon["score"]);
       $response_getAll->assertSee($azmoon["user_id"]);
       $response_getAll->assertSee($azmoon["course_session_id"]);
       $response_getAll->assertSee($azmoon["isSMSsend"]);
       $response_getAll->assertSee($azmoon["course_id"]);
   
    }
    public function test_azmoonStore()
    {        
        $azmoon=Azmoon::factory()->make();
      
        $response = $this->post(route('Azmoon.store'), $azmoon->toArray());  
            
        $this->assertGreaterThan(0,Azmoon::all()->count());        
      
       $this->assertDatabaseHas('azmoons', [
        'user_id' => $azmoon["user_id"],
        'course_id' => $azmoon["course_id"],
        'course_session_id' => $azmoon["course_session_id"],
        'isSMSsend' => $azmoon["isSMSsend"],              
        'score' => $azmoon["score"],  
       
        ]);           
    }
    public function test_azmoonUpdate()
    {   
        $azmoon=Azmoon::factory()->make();
        $responseCreate = $this->post(route('Azmoon.store'), $azmoon->toArray());
        $anotherAzmoon=self::azmoonData();

        $responseUpdate = $this->put(route('Azmoon.update', $responseCreate['id']),$anotherAzmoon);       
        $azmoonFounded = Azmoon::
        where('user_id', $anotherAzmoon["user_id"])
        ->where('course_id', $anotherAzmoon["course_id"])
        ->where('course_session_id', $anotherAzmoon["course_session_id"])
        ->where('isSMSsend', $anotherAzmoon["isSMSsend"])
        ->where('score', $anotherAzmoon["score"])        
        ->first();       
        $this->assertNotNull($azmoonFounded);
       
    }
    public function test_azmoonDelete()
    { 
        $azmoon=Azmoon::factory()->make(); 
        $response = $this->post(route('Azmoon.store'), $azmoon->toArray() );          
        $responseDelete = $this->delete(route('Azmoon.destroy', $response["id"]));        
        $AzmoonFound= Azmoon::withTrashed()->find($response["id"]);  
      
        $this->assertSoftDeleted($AzmoonFound);      
    }    

    public  function  azmoonData()
    {   
        $user_id= $this->faker->randomDigit;
        $course_id= $this->faker->randomDigit;        
        $course_session_id= $this->faker->randomDigit;        
        $isSMSsend=$this->faker->boolean;
        $score=$this->faker->randomFloat(2, 10, 100);//randomFloat($decimals, $min, $max);
        
        $azmoon=[
            'user_id' => $user_id,
            'course_id' => $course_id,
            'course_session_id' => $course_session_id,
            'isSMSsend' => $isSMSsend,              
            'score' => $score,             
                        
        ];
        return $azmoon;
    }

}
