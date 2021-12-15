<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\Fault;
use Illuminate\Support\Facades\Hash;

class FaultTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_FaultFetchAll()
    {  
        //$fault=self::faultData();
        $fault=Fault::factory()->make();//faultData();
        $response_create = $this->post(route('Fault.store'),$fault->toArray());         
        $response_getAll = $this->get(route('Fault.index')); 
        //dd($response_create->decodeResponseJson());   
        //dd($fault["description"]);    
       $response_getAll->assertSee($fault["description"]);
       
    }
    public function test_FaultStore()
    {
        //$fault=self::faultData();
      // dd($fault["mobile"]);
        $fault=Fault::factory()->make();
        $response = $this->post(route('Fault.store'), $fault->toArray() );  
       // dd($response["id"]);    
        //$faults = Fault::factory()->count(3)->make();       
        $this->assertGreaterThan(0,Fault::all()->count());        
       // $this->assertDatabaseCount('faults', 1);
       $this->assertDatabaseHas('faults', [
        'description' => $fault["description"],       
        ]);
        $fault_response = Fault::where('description', $fault["description"])->first();
         $this->assertNotNull($fault_response);        
    }
    public function test_FaultUpdate()
    {           
        //$newFault=self::faultData();
        $fault=Fault::factory()->make();
        $responseCreate = $this->post(route('Fault.store'), $fault->toArray() );
        $anotherFault=self::faultData();
        //dd($responseCreate);
        
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        $responseUpdate = $this->put(route('Fault.update', $responseCreate['id']),$anotherFault); 
        $faultFounded = Fault::where('description', $anotherFault["description"])->first();
        //dd($responseUpdate->decodeResponseJson());
       // dd($responseCreate->decodeResponseJson(),$anotherFault,$responseUpdate->decodeResponseJson(),$faultFounded);
        //dd($anotherFault);
        $this->assertNotNull($faultFounded);
        // $this->assertAuthenticatedAs($fault);
    }
    public function test_FaultDelete()
    { 
        //$fault=self::faultData(); 
        $fault=Fault::factory()->make();
        $response = $this->post(route('Fault.store'), $fault->toArray());          
        $responseDelete = $this->delete(route('Fault.destroy', $response["id"]));        
        $FaultFound= Fault::withTrashed()->find($response["id"]);  
       //dd($FaultFound);
        $this->assertSoftDeleted($FaultFound);      
    }
    public  function  faultData()
    {        
       // $name= $this->faker->name();
        $description= $this->faker->name();     

        $fault=[
            'description' => $description,                         
        ];
        return $fault;
    }
}
