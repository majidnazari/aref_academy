<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\GroupGate;
use Illuminate\Support\Facades\Hash;

class GroupGateTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_GroupGateFetchAll()
    {  
        //$groupgate=self::groupgateData();
        $groupgate=GroupGate::factory()->make();
        //dd($groupgate->toArray());
        $response_create = $this->post(route('GroupGate.store'),$groupgate->toArray()); 
        //dd($response_create->decodeResponseJson());        
        $response_getAll = $this->get(route('GroupGate.index')); 
        //dd($response_create->decodeResponseJson());   
        //dd($groupgate["description"]);   
       
       $response_getAll->assertSee($groupgate["user_id"]);
       $response_getAll->assertSee($groupgate["group_id"]);
       $response_getAll->assertSee($groupgate["gate_id"]);
       $response_getAll->assertSee($groupgate["name"]);
       
    }
    public function test_GroupGateStore()
    {
        //$groupgate=self::groupgateData();
        $groupgate=GroupGate::factory()->make();
       //dd($groupgate);
        $response = $this->post(route('GroupGate.store'), $groupgate->toArray()  );  
        //dd($response->decoderesponsejson());    
        //$groupgates = GroupGate::factory()->count(3)->make();       
        $this->assertGreaterThan(0,GroupGate::all()->count());        
       // $this->assertDatabaseCount('groupgates', 1);
       $this->assertDatabaseHas('group_gates', [
        'user_id' => $groupgate["user_id"],       
        'group_id' => $groupgate["group_id"],       
        'name' => $groupgate["name"],       
        ]);
        $groupgate_response = GroupGate::
        where('user_id', $groupgate["user_id"])
        ->where('name', $groupgate["name"])
        ->where('gate_id', $groupgate["gate_id"])
        ->where('group_id', $groupgate["group_id"])
        ->first();
        $this->assertNotNull($groupgate_response);        
    }
    public function test_GroupGateUpdate()
    {           
        //$newGroupGate=self::groupgateData();
        $groupgate=GroupGate::factory()->make();
        $responseCreate = $this->post(route('GroupGate.store'), $groupgate->toArray()  );
        $anotherGroupGate=self::groupgateData();
        //dd($responseCreate);
        
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        $responseUpdate = $this->put(route('GroupGate.update', $responseCreate['id']),$anotherGroupGate); 
        $groupgateFounded = GroupGate::
        where('user_id', $anotherGroupGate["user_id"])
        ->where('group_id', $anotherGroupGate["group_id"])
        ->where('gate_id', $anotherGroupGate["gate_id"])
        ->where('name', $anotherGroupGate["name"])
        ->first();
        //dd($responseUpdate->decodeResponseJson());
       // dd($responseCreate->decodeResponseJson(),$anotherGroupGate,$responseUpdate->decodeResponseJson(),$groupgateFounded);
        //dd($anotherGroupGate);
        $this->assertNotNull($groupgateFounded);
        // $this->assertAuthenticatedAs($groupgate);
    }
    public function test_GroupGateDelete()
    { 
        //$groupgate=self::groupgateData(); 
        //$groupgate=self::groupgateData(); 
        $groupgate=GroupGate::factory()->make();
        $response = $this->post(route('GroupGate.store'), $groupgate->toArray() );          
        $responseDelete = $this->delete(route('GroupGate.destroy', $response["id"]));        
        $GroupGateFound= GroupGate::withTrashed()->find($response["id"]);  
       //dd($GroupGateFound);
        $this->assertSoftDeleted($GroupGateFound);      
    }
    public  function  groupgateData()
    {        
       // $name= $this->faker->name();
        $description= $this->faker->text();     

        $groupgate=[
            "user_id" =>$this->faker->randomDigit,
            "group_id" =>$this->faker->randomDigit,
            "gate_id" =>$this->faker->randomDigit,                                    
            'name' => $this->faker->firstName(),                         
        ];
        return $groupgate;
    }
}
