<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\Group;
use Illuminate\Support\Facades\Hash;

class GroupTest extends TestCase
{
    // use WithFaker;
    // use RefreshDatabase;
    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function test_groupFetchAll()
    // {         
    //     $group=Group::factory()->make();        
    //     $response_create = $this->post(route('group.store'),$group->toArray()); 
              
    //     $response_getAll = $this->get(route('group.index')); 
       
    //    $response_getAll->assertSee($group["user_id"]);
    //    $response_getAll->assertSee($group["name"]);
       
    // }
    // public function test_groupStore()
    // {       
    //     $group=Group::factory()->make();     
    //     $response = $this->post(route('group.store'), $group->toArray()); 
              
    //     $this->assertGreaterThan(0,Group::all()->count());        
     
    //    $this->assertDatabaseHas('groups', [
    //     'user_id' => $group["user_id"], 
    //     'name' => $group["name"],       
    //     ]);
    //     $group_response = Group::
    //     where('user_id', $group["user_id"])
    //     ->where('name', $group["name"])        
    //     ->first();
    //      $this->assertNotNull($group_response);        
    // }
    // public function test_groupUpdate()
    // {  
    //     $group=Group::factory()->make();
    //     $responseCreate = $this->post(route('group.store'), $group->toArray()  );
    //     $anotherGroup=self::groupData();
      
    //     $responseUpdate = $this->put(route('group.update', $responseCreate['id']),$anotherGroup); 
    //     $groupFounded = Group::
    //     where('user_id', $anotherGroup["user_id"])
    //     ->where('name', $anotherGroup["name"])      
    //     ->first();
       
    //     $this->assertNotNull($groupFounded);
      
    // }
    // public function test_groupDelete()
    // {         
    //     $group=Group::factory()->make();
    //     $response = $this->post(route('group.store'), $group->toArray() );          
    //     $responseDelete = $this->delete(route('group.destroy', $response["id"]));        
    //     $GroupFound= Group::withTrashed()->find($response["id"]);  
      
    //     $this->assertSoftDeleted($GroupFound);      
    // }
    // public  function  groupData()
    // {  
    //     $description= $this->faker->text();     

    //     $group=[
    //         "user_id" =>$this->faker->randomDigit,                                   
    //         'name' => $this->faker->name(),                         
    //     ];
    //     return $group;
    // }
}
