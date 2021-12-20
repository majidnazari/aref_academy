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
    public function test_StudentContactFetchAll()
    {  
        //$studentcontact=self::studentcontactData();
        $studentcontact=StudentContact::factory()->make();
       // dd($studentcontact->toArray());
        $response_create = $this->post(route('StudentContact.store'),$studentcontact->toArray()); 
        //dd($response_create->decodeResponseJson());        
        $response_getAll = $this->get(route('StudentContact.index')); 
        //dd($response_create->decodeResponseJson());   
        //dd($studentcontact["description"]);    
       $response_getAll->assertSee($studentcontact["description"]);
       $response_getAll->assertSee($studentcontact["user_id"]);
       $response_getAll->assertSee($studentcontact["name"]);
       
    }
    public function test_StudentContactStore()
    {
        //$studentcontact=self::studentcontactData();
        $studentcontact=StudentContact::factory()->make();
      // dd($studentcontact["mobile"]);
        $response = $this->post(route('StudentContact.store'), $studentcontact->toArray());  
        //dd($response["id"]);    
        //$studentcontacts = StudentContact::factory()->count(3)->make();       
        $this->assertGreaterThan(0,StudentContact::all()->count());        
       // $this->assertDatabaseCount('studentcontacts', 1);
       $this->assertDatabaseHas('student_contacts', [
        'user_id' => $studentcontact["user_id"],       
        'student_id' => $studentcontact["student_id"],       
        'absence_presence_id' => $studentcontact["absence_presence_id"],       
        'who_answered' => $studentcontact["who_answered"],       
        'description' => $studentcontact["description"],       
        'is_called_successfull' => $studentcontact["is_called_successfull"]    
              
        ]);
        $studentcontact_response = StudentContact::
        where('user_id', $studentcontact["user_id"])
        ->where('student_id', $studentcontact["student_id"])
        ->where('absence_presence_id', $studentcontact["absence_presence_id"])
        ->where('who_answered', $studentcontact["who_answered"])
        ->where('description', $studentcontact["description"])
        ->where('is_called_successfull', $studentcontact["is_called_successfull"])
        ->first();
         $this->assertNotNull($studentcontact_response);        
    }
    public function test_StudentContactUpdate()
    {           
        //$newStudentContact=self::studentcontactData();
        $studentcontact=StudentContact::factory()->make();
        $responseCreate = $this->post(route('StudentContact.store'), $studentcontact->toArray()  );
        $anotherStudentContact=self::studentcontactData();
        //dd($responseCreate->decodeResponseJson());
        //dd($anotherStudentContact);
       // $email= $this->faker->unique()->safeEmail();
        //$mobile=$this->faker->regexify('09[0-9]{9}');
        $responseUpdate = $this->put(route('StudentContact.update', $responseCreate['id']),$anotherStudentContact); 
       // dd($responseUpdate->decoderesponseJson());
        $studentcontact_response = StudentContact::
        where('user_id', $anotherStudentContact["user_id"])
        ->where('student_id', $anotherStudentContact["student_id"])
        ->where('absence_presence_id', $anotherStudentContact["absence_presence_id"])
        ->where('who_answered', $anotherStudentContact["who_answered"])
        ->where('description', $anotherStudentContact["description"])
        ->where('is_called_successfull', $anotherStudentContact["is_called_successfull"])
        ->first();
        //dd($responseUpdate->decodeResponseJson());
       // dd($responseCreate->decodeResponseJson(),$anotherStudentContact,$responseUpdate->decodeResponseJson(),$studentcontactFounded);
        //dd($anotherStudentContact);
        $this->assertNotNull($studentcontact_response);
        // $this->assertAuthenticatedAs($studentcontact);
    }
    public function test_StudentContactDelete()
    { 
        //$studentcontact=self::studentcontactData(); 
        //$studentcontact=self::studentcontactData(); 
        $studentcontact=StudentContact::factory()->make();
        $response = $this->post(route('StudentContact.store'), $studentcontact->toArray() );          
        $responseDelete = $this->delete(route('StudentContact.destroy', $response["id"]));        
        $StudentContactFound= StudentContact::withTrashed()->find($response["id"]);  
       //dd($StudentContactFound);
        $this->assertSoftDeleted($StudentContactFound);      
    }
    public  function  studentcontactData()
    {        
       // $name= $this->faker->name();
        $user_id=$this->faker->randomDigit;
        $student_id=$this->faker->randomDigit;
        $absence_presence_id=$this->faker->randomDigit;
        $who_answered=$this->faker->randomElement(["father","mother","other"]);
        $description= $this->faker->text(); 
        $is_called_successfull= $this->faker->boolean();          

        $studentcontact=[           
            'user_id' => $user_id,			
			'student_id' => $student_id,			
			'absence_presence_id' => $absence_presence_id,			
			'who_answered' => $who_answered,			
			'description' => $description,			
			'is_called_successfull' => $is_called_successfull,	                         
        ];
        return $studentcontact;
    }
}
