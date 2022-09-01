<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\GroupGate;
use App\Models\Group;
use App\Models\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GroupGateTest extends TestCase
{
    // use WithFaker;
    // use RefreshDatabase;
    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void

    //  */
    // public function test_groupGateFetchAll()
    // {  
    //     //$groupgate=self::groupgateData();
    //     $groupgate=GroupGate::factory()->make(); 
       
    //     $response_create = $this->post(route('GroupGate.store'),$groupgate->toArray());
               
    //     $response_getAll = $this->get(route('GroupGate.index')); 
       
       
    //    $response_getAll->assertSee($groupgate["user_id"]);
    //    $response_getAll->assertSee($groupgate["group_id"]);
    //    $response_getAll->assertSee($groupgate["gate_id"]);
    //    $response_getAll->assertSee($groupgate["user_id_created"]);
       
    // }
    // public function test_groupGateStore()
    // {
    //     //$groupgate=self::groupgateData();
    //     $groupgate=GroupGate::factory()->make();      
    //     $response = $this->post(route('GroupGate.store'), $groupgate->toArray()  ); 
          
    //     $this->assertGreaterThan(0,GroupGate::all()->count());
    //    $this->assertDatabaseHas('group_gates', [
    //     'user_id' => $groupgate["user_id"],       
    //     'group_id' => $groupgate["group_id"],       
    //     'user_id_created' => $groupgate["user_id_created"],       
    //     ]);
    //     $groupgate_response = GroupGate::
    //     where('user_id', $groupgate["user_id"])
    //     ->where('user_id_created', $groupgate["user_id_created"])
    //     ->where('gate_id', $groupgate["gate_id"])
    //     ->where('group_id', $groupgate["group_id"])
    //     ->first();
    //     $this->assertNotNull($groupgate_response);        
    // }
    // public function test_groupGateUpdate()
    // {           
    //     //$newGroupGate=self::groupgateData();
    //     $groupgate=GroupGate::factory()->make();
    //     $responseCreate = $this->post(route('GroupGate.store'), $groupgate->toArray()  );
    //     $anotherGroupGate=self::groupgateData();      
    //     $responseUpdate = $this->put(route('GroupGate.update', $responseCreate['id']),$anotherGroupGate); 
    //     $groupgateFounded = GroupGate::
    //     where('user_id', $anotherGroupGate["user_id"])
    //     ->where('group_id', $anotherGroupGate["group_id"])
    //     ->where('gate_id', $anotherGroupGate["gate_id"])
    //     ->where('user_id_created', $anotherGroupGate["user_id_created"])
    //     ->first();
        
    //     $this->assertNotNull($groupgateFounded);
       
    // }
    // public function test_groupGateDelete()
    // { 
        
    //     $groupgate=GroupGate::factory()->make();
    //     $response = $this->post(route('GroupGate.store'), $groupgate->toArray() );          
    //     $responseDelete = $this->delete(route('GroupGate.destroy', $response["id"]));        
    //     $GroupGateFound= GroupGate::withTrashed()->find($response["id"]);  
      
    //     $this->assertSoftDeleted($GroupGateFound);      
    // }
    // public  function  groupgateData()
    // {       
       
    //     $description= $this->faker->text();     

    //     $groupgate=[
    //         "user_id" =>$this->faker->randomDigit,
    //         "group_id" =>$this->faker->randomDigit,
    //         "gate_id" =>$this->faker->randomDigit,                                    
    //         'user_id_created' => $this->faker->randomDigit//$this->faker->firstName(),                         
    //     ];
    //     return $groupgate;
    // }
}
