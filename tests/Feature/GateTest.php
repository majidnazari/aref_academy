<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\Gate;
use Illuminate\Support\Facades\Hash;

class GateTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_gateFetchAll()
    // {  
    //     //$gate=self::gateData();
    //     $gate=Gate::factory()->make();       
    //     $response_create = $this->post(route('gate.store'),$gate->toArray());                 
    //     $response_getAll = $this->get(route('gate.index'));           
    //    $response_getAll->assertSee($gate["description"]);
    //    $response_getAll->assertSee($gate["user_id"]);
    //    $response_getAll->assertSee($gate["name"]);
       
    // }
    // public function test_gateStore()
    // {
    //     //$gate=self::gateData();
    //     $gate=Gate::factory()->make();     
    //     $response = $this->post(route('gate.store'), $gate->toArray()  ); 
    //     $this->assertGreaterThan(0,Gate::all()->count()); 
    //    $this->assertDatabaseHas('gates', [
    //     'user_id' => $gate["user_id"],       
    //     'description' => $gate["description"],       
    //     'name' => $gate["name"],       
    //     ]);
    //     $gate_response = Gate::
    //     where('user_id', $gate["user_id"])
    //     ->where('name', $gate["name"])
    //     ->where('description', $gate["description"])
    //     ->first();
    //      $this->assertNotNull($gate_response);        
    // }
    // public function test_gateUpdate()
    // {           
    //     //$newGate=self::gateData();
    //     $gate=Gate::factory()->make();
    //     $responseCreate = $this->post(route('gate.store'), $gate->toArray()  );
    //     $anotherGate=self::gateData();        
    //     $responseUpdate = $this->put(route('gate.update', $responseCreate['id']),$anotherGate); 
    //     $gateFounded = Gate::
    //     where('user_id', $anotherGate["user_id"])
    //     ->where('name', $anotherGate["name"])
    //     ->where('description', $anotherGate["description"])
    //     ->first();       
    //     $this->assertNotNull($gateFounded);
       
    // }
    // public function test_gateDelete()
    // {        
    //     $gate=Gate::factory()->make();
    //     $response = $this->post(route('gate.store'), $gate->toArray() );          
    //     $responseDelete = $this->delete(route('gate.destroy', $response["id"]));        
    //     $GateFound= Gate::withTrashed()->find($response["id"]);  
      
    //     $this->assertSoftDeleted($GateFound);     
    // }
    // public  function  gateData()
    // {        
    //    // $name= $this->faker->name();
    //     $description= $this->faker->text();     

    //     $gate=[
    //         "user_id" =>$this->faker->randomDigit,
    //         'description' => $description,                         
    //         'name' => $this->faker->name(),                         
    //     ];
    //     return $gate;
    // }
}
