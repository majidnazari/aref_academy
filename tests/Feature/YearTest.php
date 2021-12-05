<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\Year;
use Illuminate\Support\Facades\Hash;

class YearTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_YearFetchAll()
    {  
        $year=self::YearData();
        $response_create = $this->post(route('Year.store'), $year );         
        $response_getAll = $this->get(route('Year.index')); 
       
       $response_getAll->assertSee($year["name"]);
       $response_getAll->assertSee($year["active"]);
    }
    public function test_YearStore()
    {
        $year=self::YearData();
      // dd($year["mobile"]);
        $response = $this->post(route('Year.store'), $year );  
       // dd($response["id"]);    
        //$years = Year::factory()->count(3)->make();       
        $this->assertGreaterThan(0,Year::all()->count());        
       // $this->assertDatabaseCount('years', 1);
       $this->assertDatabaseHas('years', [
        'name' => $year["name"],
        'active' => $year["active"]
        ]);
        $year_response = Year::where('name', $year["name"])->where('active', $year["active"])->first();
         $this->assertNotNull($year_response);        
    }
    public function test_YearUpdate()
    {           
        $newYear=self::YearData();
        $responseCreate = $this->post(route('Year.store'), $newYear );
        $anotherYear=self::YearData();
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        $responseUpdate = $this->put(route('Year.update', $responseCreate['id']),$anotherYear); 
        $yearFounded = Year::where('name', $anotherYear["name"])->where('active', $anotherYear["active"])->first();
       // dd($anotherYear,$yearFounded);
        $this->assertNotNull($yearFounded);
        // $this->assertAuthenticatedAs($year);
    }
    public function test_YearDelete()
    { 
        $year=self::YearData(); 
        $response = $this->post(route('Year.store'), $year );          
        $responseDelete = $this->delete(route('Year.destroy', $response["id"]));        
        $YearFound= Year::withTrashed()->find($response["id"]);  
       //dd($YearFound);
        $this->assertSoftDeleted($YearFound);      
    }
    public  function  YearData()
    {        
        $name= $this->faker->name();
        $active=$this->faker->boolean();
        $year=[
            'name' => $name,
            'active' => $active,              
        ];
        return $year;
    }
}
