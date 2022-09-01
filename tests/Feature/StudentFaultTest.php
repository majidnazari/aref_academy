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
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_studentFaultFetchAll()
    // {  
        
    //     $studentfault=StudentFault::factory()->make();
      
    //     $response_create = $this->post(route('StudentFault.store'),$studentfault->toArray()); 
              
    //     $response_getAll = $this->get(route('StudentFault.index')); 
           
    //    $response_getAll->assertSee($studentfault["user_id"]);
    //    $response_getAll->assertSee($studentfault["student_id"]);
    //    $response_getAll->assertSee($studentfault["fault_id"]);
       
    // }
    // public function test_createStudentFault()
    // {       
    //     $studentfault_new=StudentFault::factory()->make()->toArray();
    //     $student=StudentFault::create($studentfault_new);

    //     $this->assertDatabaseHas('student_faults',$studentfault_new);     
               
    // }
    // public function test_updateStudentFault()
    // {           
       
    //     $studentfault_new=StudentFault::factory()->make()->toArray();
    //     $student=StudentFault::create($studentfault_new);

    //     $studentfault_new_one=StudentFault::factory()->make()->toArray();
        

    //     $this->assertDatabaseHas('student_faults',$studentfault_new);
        
    // }
    // public function test_studentFaultDelete()
    // { 
        
    //     $studentfault=StudentFault::factory()->make();
    //     $response = $this->post(route('StudentFault.store'), $studentfault->toArray() );          
    //     $responseDelete = $this->delete(route('StudentFault.destroy', $response["id"]));        
    //     $StudentFaultFound= StudentFault::withTrashed()->find($response["id"]);  
       
    //     $this->assertSoftDeleted($StudentFaultFound);      
    // }
    // public  function  studentfaultData()
    // {        
      
    //     $user_id=$this->faker->randomDigit;
    //     $student_id=$this->faker->randomDigit;
    //     $fault_id=$this->faker->randomDigit;

    //     $studentfault=[           
    //         'user_id' => $user_id,			
	// 		'student_id' => $student_id,			
	// 		'fault_id' => $fault_id,
    //     ];
    //     return $studentfault;
    // }
}
