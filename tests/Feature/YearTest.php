<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->assertGreaterThanOrEqual($count,year::all()->count());

    }
    public function test_createYear()
    {       
        $year=Year::factory()->make()->toArray();
        Year::create($year);
        $this->assertDatabaseHas('years',$year);            
    }
    public function test_updateYear()
    {  
        $year=Year::factory()->make()->toArray();
        Year::create($year);
        $find_year=Year::where($year)->first();       
        $new_year=Year::factory()->make()->toArray();
        $find_year->update($new_year);
        $this->assertDatabaseHas('years',$new_year);       
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
