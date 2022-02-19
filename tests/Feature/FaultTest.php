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
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_faultFetchAll()
    {  
        //$fault=self::faultData();
        $fault=Fault::factory()->make();//faultData();
        $response_create = $this->post(route('Fault.store'),$fault->toArray());         
        $response_getAll = $this->get(route('Fault.index'));           
       $response_getAll->assertSee($fault["description"]);
       
    }
    public function test_faultStore()
    {      
        $fault=Fault::factory()->make();
        $response = $this->post(route('Fault.store'), $fault->toArray() );            
        $this->assertGreaterThan(0,Fault::all()->count());
        $this->assertDatabaseHas('faults', [
        'description' => $fault["description"],       
        ]);
        $fault_response = Fault::where('description', $fault["description"])->first();
         $this->assertNotNull($fault_response);        
    }
    public function test_faultUpdate()
    {           
        //$newFault=self::faultData();
        $fault=Fault::factory()->make();
        $responseCreate = $this->post(route('Fault.store'), $fault->toArray() );
        $anotherFault=self::faultData();      
        $responseUpdate = $this->put(route('Fault.update', $responseCreate['id']),$anotherFault); 
        $faultFounded = Fault::where('description', $anotherFault["description"])->first();
       
        $this->assertNotNull($faultFounded);       
    }
    public function test_faultDelete()
    { 
        //$fault=self::faultData(); 
        $fault=Fault::factory()->make();
        $response = $this->post(route('Fault.store'), $fault->toArray());          
        $responseDelete = $this->delete(route('Fault.destroy', $response["id"]));        
        $FaultFound= Fault::withTrashed()->find($response["id"]);       
        $this->assertSoftDeleted($FaultFound);      
    }
    public  function  faultData()
    {   
        $description= $this->faker->name();     

        $fault=[
            'description' => $description,                         
        ];
        return $fault;
    }
}
