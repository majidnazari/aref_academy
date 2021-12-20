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
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_GroupFetchAll()
    {  
        //$group=self::groupData();
        $group=Group::factory()->make();
        //dd($group->toArray());
        $response_create = $this->post(route('group.store'),$group->toArray()); 
        //dd($response_create->decodeResponseJson());        
        $response_getAll = $this->get(route('group.index')); 
        //dd($response_create->decodeResponseJson());   
        //dd($group["description"]);   
      
       $response_getAll->assertSee($group["user_id"]);
       $response_getAll->assertSee($group["name"]);
       
    }
    public function test_GroupStore()
    {
        //$group=self::groupData();
        $group=Group::factory()->make();
      // dd($group["mobile"]);
        $response = $this->post(route('group.store'), $group->toArray());  
       // dd($response["id"]);    
        //$groups = Group::factory()->count(3)->make();       
        $this->assertGreaterThan(0,Group::all()->count());        
       // $this->assertDatabaseCount('groups', 1);
       $this->assertDatabaseHas('groups', [
        'user_id' => $group["user_id"], 
        'name' => $group["name"],       
        ]);
        $group_response = Group::
        where('user_id', $group["user_id"])
        ->where('name', $group["name"])        
        ->first();
         $this->assertNotNull($group_response);        
    }
    public function test_GroupUpdate()
    {           
        //$newGroup=self::groupData();
        $group=Group::factory()->make();
        $responseCreate = $this->post(route('group.store'), $group->toArray()  );
        $anotherGroup=self::groupData();
        //dd($responseCreate);
        
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        $responseUpdate = $this->put(route('group.update', $responseCreate['id']),$anotherGroup); 
        $groupFounded = Group::
        where('user_id', $anotherGroup["user_id"])
        ->where('name', $anotherGroup["name"])      
        ->first();
        //dd($responseUpdate->decodeResponseJson());
       // dd($responseCreate->decodeResponseJson(),$anotherGroup,$responseUpdate->decodeResponseJson(),$groupFounded);
        //dd($anotherGroup);
        $this->assertNotNull($groupFounded);
        // $this->assertAuthenticatedAs($group);
    }
    public function test_GroupDelete()
    { 
        //$group=self::groupData(); 
        //$group=self::groupData(); 
        $group=Group::factory()->make();
        $response = $this->post(route('group.store'), $group->toArray() );          
        $responseDelete = $this->delete(route('group.destroy', $response["id"]));        
        $GroupFound= Group::withTrashed()->find($response["id"]);  
       //dd($GroupFound);
        $this->assertSoftDeleted($GroupFound);      
    }
    public  function  groupData()
    {        
       // $name= $this->faker->name();
        $description= $this->faker->text();     

        $group=[
            "user_id" =>$this->faker->randomDigit,                                   
            'name' => $this->faker->name(),                         
        ];
        return $group;
    }
}
