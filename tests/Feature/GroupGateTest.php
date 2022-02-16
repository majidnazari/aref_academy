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
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
<<<<<<< HEAD
     */
    public function test_groupGateFetchAll()
    {  
        //$groupgate=self::groupgateData();
        $groupgate=GroupGate::factory()->make();       
        $response_create = $this->post(route('GroupGate.store'),$groupgate->toArray());
              
        $response_getAll = $this->get(route('GroupGate.index')); 
       
       
       $response_getAll->assertSee($groupgate["user_id"]);
       $response_getAll->assertSee($groupgate["group_id"]);
       $response_getAll->assertSee($groupgate["gate_id"]);
       $response_getAll->assertSee($groupgate["name"]);
       
    }
    public function test_groupGateStore()
    {
        //$groupgate=self::groupgateData();
        $groupgate=GroupGate::factory()->make();      
        $response = $this->post(route('GroupGate.store'), $groupgate->toArray()  ); 
          
        $this->assertGreaterThan(0,GroupGate::all()->count());
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
    public function test_groupGateUpdate()
    {           
        //$newGroupGate=self::groupgateData();
        $groupgate=GroupGate::factory()->make();
        $responseCreate = $this->post(route('GroupGate.store'), $groupgate->toArray()  );
        $anotherGroupGate=self::groupgateData();      
        $responseUpdate = $this->put(route('GroupGate.update', $responseCreate['id']),$anotherGroupGate); 
        $groupgateFounded = GroupGate::
        where('user_id', $anotherGroupGate["user_id"])
        ->where('group_id', $anotherGroupGate["group_id"])
        ->where('gate_id', $anotherGroupGate["gate_id"])
        ->where('name', $anotherGroupGate["name"])
        ->first();
        
        $this->assertNotNull($groupgateFounded);
       
    }
    public function test_groupGateDelete()
    { 
        
        $groupgate=GroupGate::factory()->make();
        $response = $this->post(route('GroupGate.store'), $groupgate->toArray() );          
        $responseDelete = $this->delete(route('GroupGate.destroy', $response["id"]));        
        $GroupGateFound= GroupGate::withTrashed()->find($response["id"]);  
      
        $this->assertSoftDeleted($GroupGateFound);      
    }
    public  function  groupgateData()
    {       
       
        $description= $this->faker->text();     

        $groupgate=[
            "user_id" =>$this->faker->randomDigit,
            "group_id" =>$this->faker->randomDigit,
            "gate_id" =>$this->faker->randomDigit,                                    
            'name' => $this->faker->firstName(),                         
        ];
        return $groupgate;
=======
     */  
    public function test_AddrelationManyToManyTest()
    {
        $count=3;
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
        Gate::truncate();
        Group::truncate();       
        $gate=Gate::factory()->count($count)->create();       
       // dd($gate[]["name"]); 
        $group=Group::factory()->count(1)->create();
       // dd($group[0]["name"]);        
        //dd($group[0]->id);//$group=Group::find(1);
        $gate_ids=Gate::select('id')->where('id','>',0)->inRandomOrder()->limit(3)->get();//$this->faker->randomElement(Gate::pluck('id'));
        //dd($gate_ids->toArray());
        // $ids=array();
        // foreach($gate_ids as $gate_id)
        // {
        //     $ids[]=$gate_id->id;
        // }
        //dd($ids);
        $gates=Gate::whereIn('id', $gate_ids)->get();
        //dd($group->toArray());
        //dd($gates->toArray());
        $groupgate=array();
        $id=1;
        $user_creator_id=$this->faker->randomDigit;
        foreach($gates as $gate)
        {            
            $groupgate[$id]["user_id_created"]=$user_creator_id;
            $groupgate[$id]["user_id"]= $user;
            $groupgate[$id]["gate_id"]=$gate->id;
            $groupgate[$id]["group_id"]=$group[0]->id;
           // $groupgate[$id]["name"]="gg";
            $groupgate[$id]["created_at"]=now();
            $groupgate[$id]["updated_at"]=now();
            $id++;            
        }
        // dd($groupgate);
       // $groupgate=Gate::find(2)->groups()->attach($group,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
       // $groupgate=Group::find(1)->gates()->dettach($gates,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
       // $groupgate=Group::find(1)->gates()->attach($gates,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
        $groupgate=Group::find($group[0]->id)->gates()->sync($groupgate,true);            
        //dd($groupgate);
        $groupgates=GroupGate::where('user_id',$group[0]->id)->get();
        //dd($groupgates->toArray());
        $groupgateFounded = GroupGate::
        where('user_id_created', $user_creator_id)
        ->where('user_id',  $user)
        ->where('group_id', $group[0]->id)
        ->whereIn('gate_id', $gate_ids)      
        ->get();
        
        $this->assertCount($count, $groupgateFounded);
    }
    public function test_DeleterelationManyToManyTest()
    {
        $count=3;
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
        Gate::truncate();
        Group::truncate();       
        $gate=Gate::factory()->count($count)->create(); 
        $group=Group::factory()->count(1)->create();       
        $gate_ids=Gate::select('id')->where('id','>',0)->inRandomOrder()->limit(3)->get();//$this->faker->randomElement(Gate::pluck('id'));
        $gates=Gate::whereIn('id', $gate_ids)->get();        
        $groupgate=array();
        $id=1;
        $user_creator_id=$this->faker->randomDigit;
        foreach($gates as $gate)
        {            
            $groupgate[$id]["user_id_created"]=$user_creator_id;
            $groupgate[$id]["user_id"]= $user;
            $groupgate[$id]["gate_id"]=$gate->id;
            $groupgate[$id]["group_id"]=$group[0]->id;
           // $groupgate[$id]["name"]="gg";
            $groupgate[$id]["created_at"]=now();
            $groupgate[$id]["updated_at"]=now();
            $id++;            
        }
        // dd($groupgate);
       // $groupgate=Gate::find(2)->groups()->attach($group,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
       // $groupgate=Group::find(1)->gates()->dettach($gates,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
       // $groupgate=Group::find(1)->gates()->attach($gates,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
        $groupgate=Group::find($group[0]->id)->gates()->sync($groupgate);  
        $groupgate_detached=Group::find($group[0]->id)->gates()->detach($gate_ids);  
        //dd($groupgate_detached);    
        
        $this->assertTrue($count===$groupgate_detached);
    }
    public function test_GetrelationManyToManyTest()
    {
        $count=3;
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
        Gate::truncate();
        Group::truncate();       
        $gate=Gate::factory()->count($count)->create(); 
        $group=Group::factory()->count(1)->create();       
        $gate_ids=Gate::select('id')->where('id','>',0)->inRandomOrder()->limit(3)->get();//$this->faker->randomElement(Gate::pluck('id'));
        $gates=Gate::whereIn('id', $gate_ids)->get();        
        $groupgate=array();
        $id=1;
        $user_creator_id=$this->faker->randomDigit;
        foreach($gates as $gate)
        {            
            $groupgate[$id]["user_id_created"]=$user_creator_id;
            $groupgate[$id]["user_id"]= $user;
            $groupgate[$id]["gate_id"]=$gate->id;
            $groupgate[$id]["group_id"]=$group[0]->id;
           // $groupgate[$id]["name"]="gg";
            $groupgate[$id]["created_at"]=now();
            $groupgate[$id]["updated_at"]=now();
            $id++;            
        }
        // dd($groupgate);
       // $groupgate=Gate::find(2)->groups()->attach($group,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
       // $groupgate=Group::find(1)->gates()->dettach($gates,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
       // $groupgate=Group::find(1)->gates()->attach($gates,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
        $groupgate=Group::find($group[0]->id)->gates()->sync($groupgate);  
        $gate=Group::find($group[0]->id)->gates()->first();
        $group=Gate::find($gate_ids[0]->id)->groups()->first();
        //dd(get_class($group));
        $this->assertInstanceOf(Gate::class,$gate);
        $this->assertInstanceOf(Group::class,$group);        
      
    }
    public function test_PivotrelationManyToManyTest()
    {
        $count=3;
        $user=$this->faker->randomElement(User::pluck('id'));// User::factory()->create();
        if($user===null)
        {
            $user= User::factory()->create();
            $user=$user->id;
        }
        Gate::truncate();
        Group::truncate();       
        $gate=Gate::factory()->count($count)->create(); 
        $group=Group::factory()->count(1)->create();       
        $gate_ids=Gate::select('id')->where('id','>',0)->inRandomOrder()->limit(3)->get();//$this->faker->randomElement(Gate::pluck('id'));
        $gates=Gate::whereIn('id', $gate_ids)->get();        
        $groupgate=array();
        $id=1;
        ///$user_creator_id=$this->faker->randomDigit;
        foreach($gates as $gate)
        {            
            $groupgate[$id]["user_id_created"]=$this->faker->randomDigit;
            $groupgate[$id]["user_id"]= $user;
            $groupgate[$id]["gate_id"]=$gate->id;
            $groupgate[$id]["group_id"]=$group[0]->id;
           // $groupgate[$id]["name"]="gg";
            $groupgate[$id]["created_at"]=now();
            $groupgate[$id]["updated_at"]=now();
            $id++;            
        }
        // dd($groupgate);
       // $groupgate=Gate::find(2)->groups()->attach($group,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
       // $groupgate=Group::find(1)->gates()->dettach($gates,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
       // $groupgate=Group::find(1)->gates()->attach($gates,["user_id_created"=>$user_creator_id,"user_id"=>1,"name"=>"test"]);
        $groupgate=Group::find($group[0]->id)->gates()->sync($groupgate);  
        $gate=Group::find($group[0]->id)->gates()->first();
        
        //dd($gate->toArray());
        $group=Gate::find($gate_ids[0]->id)->groups()->first();
        //dd(get_class($group));
        $this->assertNotNull($gate->pivot->user_id_created);
        $this->assertNotNull($group->pivot->user_id_created);        
      
>>>>>>> 78523a893b679506d9b6d76897f85d8fbdbefd3d
    }
}
