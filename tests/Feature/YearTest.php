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
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_getOneYear()
    // {       
    //     $year_model = Year::factory()->make()->toArray();
    //     Year::create($year_model);
        
    //     // $findyear = year::where('id', $year_created->id)->first();
    //     // $year_tmp = $findyear->toArray();        

    //     $this->assertDatabaseHas('years', $year_model);
        
    // }
    public function test_getAllYears()
    {
        $count=rand(2,5);
        $year_created = year::factory($count)->create();
        //dd(count($year_created));
        //$this->ass
        //$this->assertCount($count, $year_created);
        $this->assertGreaterThanOrEqual($count,year::all()->count());

    }
    public function test_createYear()
    {       
        $year=Year::factory()->make()->toArray();
        Year::create($year);
        $this->assertDatabaseHas('years',$year);
       
        // $getAllYears->assertSee($year['active']);       
        //$response = $this->post(route('Year.store'), $year->toArray() );               
        //$this->assertGreaterThan(0,Year::all()->count());
        //$this->assertNotNull($year_response);        
    }
    public function test_updateYear()
    {  
        $year=Year::factory()->make()->toArray();
        Year::create($year);
        $find_year=Year::where($year)->first();
        //dd($find_year->id);
        $new_year=Year::factory()->make()->toArray();
        $find_year->update($new_year);
        $this->assertDatabaseHas('years',$new_year);
        //$responseCreate = $this->post(route('Year.store'), $year->toArray() );
        //$anotherYear=self::yearData();
        
        // $responseUpdate = $this->put(route('Year.update', $responseCreate['id']),$anotherYear); 
        // $yearFounded = Year::where('name', $anotherYear["name"])->where('active', $anotherYear["active"])->first();
     
        // $this->assertNotNull($yearFounded);       
    }
    public function test_deleteYear()
    { 
        $year=Year::factory()->make()->toArray();
        Year::create($year);
        $find_year=Year::where($year)->first();
        if($find_year)
        {
            $find_year->delete();
        }
        $YearFound= Year::withTrashed()->find($find_year->id);
        $this->assertSoftDeleted($YearFound); 


        // $year=Year::factory()->make();
        // $response = $this->post(route('Year.store'), $year->toArray() );          
        // $responseDelete = $this->delete(route('Year.destroy', $response["id"]));        
        // $YearFound= Year::withTrashed()->find($response["id"]);
        // $this->assertSoftDeleted($YearFound);      
    }
    public  function  yearData()
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
