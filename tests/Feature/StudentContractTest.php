<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\StudentContact;
use Illuminate\Support\Facades\Hash;

class StudentContactTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_studentContactFetchAll()
    // { 
    //     $studentcontact=StudentContact::factory()->make();       
    //     $response_create = $this->post(route('StudentContact.store'),$studentcontact->toArray()); 
             
    //     $response_getAll = $this->get(route('StudentContact.index')); 
          
    //    $response_getAll->assertSee($studentcontact["description"]);
    //    $response_getAll->assertSee($studentcontact["user_id"]);
    //    $response_getAll->assertSee($studentcontact["name"]);
       
    // }
    // public function test_studentContactStore()
    // {
       
    //     $studentcontact=StudentContact::factory()->make();
      
    //     $response = $this->post(route('StudentContact.store'), $studentcontact->toArray());  
            
    //     $this->assertGreaterThan(0,StudentContact::all()->count());        
      
    //    $this->assertDatabaseHas('student_contacts', [
    //     'user_id' => $studentcontact["user_id"],       
    //     'student_id' => $studentcontact["student_id"],       
    //     'absence_presence_id' => $studentcontact["absence_presence_id"],       
    //     'who_answered' => $studentcontact["who_answered"],       
    //     'description' => $studentcontact["description"],       
    //     'is_called_successfull' => $studentcontact["is_called_successfull"]    
              
    //     ]);
    //     $studentcontact_response = StudentContact::
    //     where('user_id', $studentcontact["user_id"])
    //     ->where('student_id', $studentcontact["student_id"])
    //     ->where('absence_presence_id', $studentcontact["absence_presence_id"])
    //     ->where('who_answered', $studentcontact["who_answered"])
    //     ->where('description', $studentcontact["description"])
    //     ->where('is_called_successfull', $studentcontact["is_called_successfull"])
    //     ->first();
    //      $this->assertNotNull($studentcontact_response);        
    // }
    // public function test_studentContactUpdate()
    // {           
    //     //$newStudentContact=self::studentcontactData();
    //     $studentcontact=StudentContact::factory()->make();
    //     $responseCreate = $this->post(route('StudentContact.store'), $studentcontact->toArray()  );
    //     $anotherStudentContact=self::studentcontactData();
      
    //     $responseUpdate = $this->put(route('StudentContact.update', $responseCreate['id']),$anotherStudentContact); 
      
    //     $studentcontact_response = StudentContact::
    //     where('user_id', $anotherStudentContact["user_id"])
    //     ->where('student_id', $anotherStudentContact["student_id"])
    //     ->where('absence_presence_id', $anotherStudentContact["absence_presence_id"])
    //     ->where('who_answered', $anotherStudentContact["who_answered"])
    //     ->where('description', $anotherStudentContact["description"])
    //     ->where('is_called_successfull', $anotherStudentContact["is_called_successfull"])
    //     ->first();
       
    //     $this->assertNotNull($studentcontact_response);
       
    // }
    // public function test_studentContactDelete()
    // {        
    //     $studentcontact=StudentContact::factory()->make();
    //     $response = $this->post(route('StudentContact.store'), $studentcontact->toArray() );          
    //     $responseDelete = $this->delete(route('StudentContact.destroy', $response["id"]));        
    //     $StudentContactFound= StudentContact::withTrashed()->find($response["id"]);  
      
    //     $this->assertSoftDeleted($StudentContactFound);      
    // }
    // public  function  studentcontactData()
    // {        
      
    //     $user_id=$this->faker->randomDigit;
    //     $student_id=$this->faker->randomDigit;
    //     $absence_presence_id=$this->faker->randomDigit;
    //     $who_answered=$this->faker->randomElement(["father","mother","other"]);
    //     $description= $this->faker->text(); 
    //     $is_called_successfull= $this->faker->boolean();          

    //     $studentcontact=[           
    //         'user_id' => $user_id,			
	// 		'student_id' => $student_id,			
	// 		'absence_presence_id' => $absence_presence_id,			
	// 		'who_answered' => $who_answered,			
	// 		'description' => $description,			
	// 		'is_called_successfull' => $is_called_successfull,	                         
    //     ];
    //     return $studentcontact;
    // }
}
