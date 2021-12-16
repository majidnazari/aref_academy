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
    public function test_AzmoonFetchAll()
    {  
        //$azmoon=self::azmoonData(); 
        $azmoon=Azmoon::factory()->make();
        //dd($azmoon->toArray());      
        $response_create = $this->post(route('Azmoon.store'),$azmoon->toArray());
        //dd($response_create->decodeResponseJson());         
        $response_getAll = $this->get(route('Azmoon.index')); 
        //dd($response_create);
       
       $response_getAll->assertSee($azmoon["score"]);
       $response_getAll->assertSee($azmoon["user_id"]);
       $response_getAll->assertSee($azmoon["course_session_id"]);
       $response_getAll->assertSee($azmoon["isSMSsend"]);
       $response_getAll->assertSee($azmoon["course_id"]);
   
    }
    public function test_AzmoonStore()
    {        
        $azmoon=Azmoon::factory()->make();
        //$azmoon=self::azmoonData();
        //dd($azmoon->toArray());
        $response = $this->post(route('Azmoon.store'), $azmoon->toArray());  
       // dd($response->decodeResponseJson());    
        //$azmoons = Azmoon::factory()->count(3)->make();       
        $this->assertGreaterThan(0,Azmoon::all()->count());        
       // $this->assertDatabaseCount('azmoons', 1);
       $this->assertDatabaseHas('azmoons', [
        'user_id' => $azmoon["user_id"],
        'course_id' => $azmoon["course_id"],
        'course_session_id' => $azmoon["course_session_id"],
        'isSMSsend' => $azmoon["isSMSsend"],              
        'score' => $azmoon["score"],  
       
        ]);           
    }
    public function test_AzmoonUpdate()
    {           
        //$newAzmoon=self::azmoonData();
        $azmoon=Azmoon::factory()->make();
        $responseCreate = $this->post(route('Azmoon.store'), $azmoon->toArray());
        $anotherAzmoon=self::azmoonData();
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        //dd($anotherAzmoon);

        $responseUpdate = $this->put(route('Azmoon.update', $responseCreate['id']),$anotherAzmoon); 
        //dd($responseUpdate->decodeResponseJson());
        $azmoonFounded = Azmoon::
        where('user_id', $anotherAzmoon["user_id"])
        ->where('course_id', $anotherAzmoon["course_id"])
        ->where('course_session_id', $anotherAzmoon["course_session_id"])
        ->where('isSMSsend', $anotherAzmoon["isSMSsend"])
        ->where('score', $anotherAzmoon["score"])
        //->where('user_id', $anotherAzmoon["user_id"])
        ->first();
        //dd($azmoonFounded);
       // dd($anotherAzmoon,$azmoonFounded);
        $this->assertNotNull($azmoonFounded);
        // $this->assertAuthenticatedAs($azmoon);
    }
    public function test_AzmoonDelete()
    { 
        //$azmoon=self::azmoonData();
        $azmoon=Azmoon::factory()->make(); 
        $response = $this->post(route('Azmoon.store'), $azmoon->toArray() );          
        $responseDelete = $this->delete(route('Azmoon.destroy', $response["id"]));        
        $AzmoonFound= Azmoon::withTrashed()->find($response["id"]);  
       //dd($AzmoonFound);
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
