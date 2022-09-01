<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\Fault;
use Illuminate\Support\Facades\Hash;

class FaultTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_getOneFault()
    // {       
    //     $Fault_model = Fault::factory()->make()->toArray();
    //     Fault::create($Fault_model);            

    //     $this->assertDatabaseHas('faults', $Fault_model);
        
    // }
    public function test_getAllFaults()
    {
        $count=rand(1,3);
        $Fault_created = Fault::factory($count)->create();
      
        $this->assertGreaterThanOrEqual($count,Fault::all()->count());

    }
    public function test_createFault()
    {       
        $Fault=Fault::factory()->make()->toArray();
        Fault::create($Fault);
        $this->assertDatabaseHas('faults',$Fault);             
    }
    public function test_updateFault()
    {  
        $Fault=Fault::factory()->make()->toArray();
        Fault::create($Fault);
        $new_Fault=Fault::factory()->make()->toArray();
        $find_Fault=Fault::where($Fault)->update($new_Fault);
        //dd($find_Fault->id);
        
        //$find_Fault->update($new_Fault);
        $this->assertDatabaseHas('faults',$new_Fault);        
    }
    public function test_deleteFault()
    { 
        $Fault=Fault::factory()->make()->toArray();
        $find_Fault= Fault::create($Fault);
        Fault::where($Fault)->delete();
        // if($find_Fault)
        // {
        //     $find_Fault->delete();
        // }
        $FaultFound= Fault::withTrashed()->find($find_Fault->id);
        $this->assertSoftDeleted($FaultFound); 
     
    }
    public  function  FaultData()
    {        
        $name= $this->faker->name();
        $active=$this->faker->boolean();
        $Fault=[
            'user_id_creator' => $name,
            'active' => $active,              
        ];
        return $Fault;
    }
}
