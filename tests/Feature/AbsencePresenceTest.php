<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\AbsencePresence;
use Illuminate\Support\Facades\Hash;

class AbsencePresenceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getOneAbsencePresence()
    {       
        $AbsencePresence_model = AbsencePresence::factory()->make()->toArray();
        AbsencePresence::create($AbsencePresence_model);            

        $this->assertDatabaseHas('absencepresences', $AbsencePresence_model);
        
    }
    public function test_getAllAbsencePresences()
    {
        $count=rand(2,4);
        $AbsencePresence_created = AbsencePresence::factory($count)->create();
      
        $this->assertGreaterThanOrEqual($count,AbsencePresence::all()->count());

    }
    public function test_createAbsencePresence()
    {       
        $AbsencePresence=AbsencePresence::factory()->make()->toArray();
        AbsencePresence::create($AbsencePresence);
        $this->assertDatabaseHas('absencepresences',$AbsencePresence);             
    }
    public function test_updateAbsencePresence()
    {  
        $AbsencePresence=AbsencePresence::factory()->make()->toArray();
        AbsencePresence::create($AbsencePresence);
        $new_AbsencePresence=AbsencePresence::factory()->make()->toArray();
        $find_AbsencePresence=AbsencePresence::where($AbsencePresence)->update($new_AbsencePresence);
        //dd($find_AbsencePresence->id);
        
        //$find_AbsencePresence->update($new_AbsencePresence);
        $this->assertDatabaseHas('absencepresences',$new_AbsencePresence);        
    }
    public function test_deleteAbsencePresence()
    { 
        $AbsencePresence=AbsencePresence::factory()->make()->toArray();
        $find_AbsencePresence= AbsencePresence::create($AbsencePresence);
        AbsencePresence::where($AbsencePresence)->delete();
        // if($find_AbsencePresence)
        // {
        //     $find_AbsencePresence->delete();
        // }
        $AbsencePresenceFound= AbsencePresence::withTrashed()->find($find_AbsencePresence->id);
        $this->assertSoftDeleted($AbsencePresenceFound); 
     
    }
    public  function  AbsencePresenceData()
    {        
        $name= $this->faker->name();
        $user_id= $this->faker->randomDigit;
        $years_id= $this->faker->randomDigit;
        $teachers_id=$this->faker->randomDigit;
       
        $typeSample=['public','private'];        
        $lessonSample= ['Mathematics','Physics','Biology'];

        $type=$typeSample[rand(0,1)];
        $lesson= $lessonSample[rand(0,2)];
        $AbsencePresence=[
            'user_id' => $user_id,
            'teacher_id' => $teachers_id,
            'year_id' => $years_id,
            'type' => $type,              
            'lesson' => $lesson,              
            'name' => $name,              
        ];
        return $AbsencePresence;
    }
}
