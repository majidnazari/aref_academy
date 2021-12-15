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
    public function test_GateFetchAll()
    {  
        //$gate=self::gateData();
        $gate=Gate::factory()->make();
        //dd($gate->toArray());
        $response_create = $this->post(route('gate.store'),$gate->toArray()); 
        //dd($response_create->decodeResponseJson());        
        $response_getAll = $this->get(route('gate.index')); 
        //dd($response_create->decodeResponseJson());   
        //dd($gate["description"]);    
       $response_getAll->assertSee($gate["description"]);
       $response_getAll->assertSee($gate["user_id"]);
       $response_getAll->assertSee($gate["name"]);
       
    }
    public function test_GateStore()
    {
        //$gate=self::gateData();
        $gate=Gate::factory()->make();
      // dd($gate["mobile"]);
        $response = $this->post(route('gate.store'), $gate->toArray()  );  
       // dd($response["id"]);    
        //$gates = Gate::factory()->count(3)->make();       
        $this->assertGreaterThan(0,Gate::all()->count());        
       // $this->assertDatabaseCount('gates', 1);
       $this->assertDatabaseHas('gates', [
        'user_id' => $gate["user_id"],       
        'description' => $gate["description"],       
        'name' => $gate["name"],       
        ]);
        $gate_response = Gate::
        where('user_id', $gate["user_id"])
        ->where('name', $gate["name"])
        ->where('description', $gate["description"])
        ->first();
         $this->assertNotNull($gate_response);        
    }
    public function test_GateUpdate()
    {           
        //$newGate=self::gateData();
        $gate=Gate::factory()->make();
        $responseCreate = $this->post(route('gate.store'), $gate->toArray()  );
        $anotherGate=self::gateData();
        //dd($responseCreate);
        
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        $responseUpdate = $this->put(route('gate.update', $responseCreate['id']),$anotherGate); 
        $gateFounded = Gate::
        where('user_id', $anotherGate["user_id"])
        ->where('name', $anotherGate["name"])
        ->where('description', $anotherGate["description"])
        ->first();
        //dd($responseUpdate->decodeResponseJson());
       // dd($responseCreate->decodeResponseJson(),$anotherGate,$responseUpdate->decodeResponseJson(),$gateFounded);
        //dd($anotherGate);
        $this->assertNotNull($gateFounded);
        // $this->assertAuthenticatedAs($gate);
    }
    public function test_GateDelete()
    { 
        //$gate=self::gateData(); 
        //$gate=self::gateData(); 
        $gate=Gate::factory()->make();
        $response = $this->post(route('gate.store'), $gate->toArray() );          
        $responseDelete = $this->delete(route('gate.destroy', $response["id"]));        
        $GateFound= Gate::withTrashed()->find($response["id"]);  
       //dd($GateFound);
        $this->assertSoftDeleted($GateFound);      
    }
    public  function  gateData()
    {        
       // $name= $this->faker->name();
        $description= $this->faker->text();     

        $gate=[
            "user_id" =>$this->faker->randomDigit,
            'description' => $description,                         
            'name' => $this->faker->name(),                         
        ];
        return $gate;
    }
}
