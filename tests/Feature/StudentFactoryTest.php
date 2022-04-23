<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\StudentFault;
use Illuminate\Support\Facades\Hash;

class StudentFaultTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_studentFaultFetchAll()
    {  
        
        $studentfault=StudentFault::factory()->make();
      
        $response_create = $this->post(route('StudentFault.store'),$studentfault->toArray()); 
              
        $response_getAll = $this->get(route('StudentFault.index')); 
           
       $response_getAll->assertSee($studentfault["user_id"]);
       $response_getAll->assertSee($studentfault["student_id"]);
       $response_getAll->assertSee($studentfault["fault_id"]);
       
    }
    public function test_studentFaultStore()
    {
       
        $studentfault=StudentFault::factory()->make();
     
        $response = $this->post(route('StudentFault.store'), $studentfault->toArray());  
           
        $this->assertGreaterThan(0,StudentFault::all()->count());        
      
       $this->assertDatabaseHas('student_faults', [
        'user_id' => $studentfault["user_id"],       
        'student_id' => $studentfault["student_id"],       
        'fault_id' => $studentfault["fault_id"],
        ]);
        $studentfault_response = StudentFault::
        where('user_id', $studentfault["user_id"])
        ->where('student_id', $studentfault["student_id"])
        ->where('fault_id', $studentfault["fault_id"])        
        ->first();
         $this->assertNotNull($studentfault_response);        
    }
    public function test_studentFaultUpdate()
    {           
       
        $studentfault=StudentFault::factory()->make();
        $responseCreate = $this->post(route('StudentFault.store'), $studentfault->toArray()  );
        $anotherStudentFault=self::studentfaultData();
       
        $responseUpdate = $this->put(route('StudentFault.update', $responseCreate['id']),$anotherStudentFault); 
        $studentfault_response = StudentFault::
        where('user_id', $anotherStudentFault["user_id"])
        ->where('student_id', $anotherStudentFault["student_id"])
        ->where('fault_id', $anotherStudentFault["fault_id"])        
        ->first();
       
        $this->assertNotNull($studentfault_response);
        
    }
    public function test_studentFaultDelete()
    { 
        
        $studentfault=StudentFault::factory()->make();
        $response = $this->post(route('StudentFault.store'), $studentfault->toArray() );          
        $responseDelete = $this->delete(route('StudentFault.destroy', $response["id"]));        
        $StudentFaultFound= StudentFault::withTrashed()->find($response["id"]);  
       
        $this->assertSoftDeleted($StudentFaultFound);      
    }
    public  function  studentfaultData()
    {        
      
        $user_id=$this->faker->randomDigit;
        $student_id=$this->faker->randomDigit;
        $fault_id=$this->faker->randomDigit;

        $studentfault=[           
            'user_id' => $user_id,			
			'student_id' => $student_id,			
			'fault_id' => $fault_id,
        ];
        return $studentfault;
    }
}
