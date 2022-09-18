<?php

namespace Tests\Feature;

use BasicModule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\TestCase;
use App\Models\AbsencePresence;
use App\Models\User;
use App\Providers\BasicMethodServiceProvider;
use Illuminate\Support\Facades\Hash;
use Log;

class tmpTest  extends TestCase
{
    // use WithFaker;
    // //use RefreshDatabase;
    // protected static $token=null;  
    // public function  LoginUser()
    // {
    //     // $baseUrl = Config::get('app.url') . '/api/login';
    //     // $email = Config::get('api.apiEmail');
    //     // $password = Config::get('api.apiPassword');

    //     $baseUrl="localhost:8000/api/login";
    //     $email="majidnazarister@gmail.com";
    //     $password="12345";

    //     $response = $this->post(route("login"), [
    //         'email' => $email,
    //         'password' => $password
    //     ]);
    //   if(!isset( $response["token"]))
    //   {
    //       return "please register at first.";
    //   }
    //   return $response["token"];
    //    // self::$token=$response["token"];
    //    // $this->assertNotNull($response["token"]);
       
    // }
    // //use User;
    // //use Fault;
    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */
    // public function test_absencePresenceFetchAll()
    // {  
    //     self::$token=self::$token!==null ? self::$token : $this->LoginUser() ;          
    //     $this->withHeader('Authorization', 'Bearer ' .self::$token);  

    //     //$data=self::AbsencePresenceData();   
    //     $data= AbsencePresence::factory()->make();  
       
    //     $AbsencePresenceResultStore=$this->post(route('AbsencePresence.store'),$data->toArray());
    //     $AbsencePresenceResultIndex=$this->get(route('AbsencePresence.index'));       
    //      $AbsencePresenceResultIndex->assertSee(isset($data["user_id"]));     
    // }
    // public function test_absencePresenceStore()
    // {
    //     self::$token=self::$token!==null ? self::$token : $this->LoginUser() ;          
    //     $this->withHeader('Authorization', 'Bearer ' .self::$token);  

    //     $data= AbsencePresence::factory()->make();      
    //      $response = $this->post(route('AbsencePresence.store'), $data->toArray() );
    //      $this->assertGreaterThan(0,AbsencePresence::all()->count());        
    //    // $this->assertDatabaseCount('years', 1);
    //    $this->assertDatabaseHas('absence_presences', [
    //     'user_id' => $data["user_id"],
    //     'course_session_id' => $data["course_session_id"],
    //     'teacher_id' => $data["teacher_id"],
    //     'status' => $data["status"],
    //     ]);
    //     $absencePresence_response = AbsencePresence::where('user_id', $data["user_id"])
    //     ->where('course_session_id', $data["course_session_id"])
    //     ->where('teacher_id', $data["teacher_id"])
    //     ->where('status', $data["status"])
    //     ->first();
    //      $this->assertNotNull($absencePresence_response);      
     
    // }
    // public function test_absencePresenceUpdate()
    // {
    //     self::$token=self::$token!==null ? self::$token : $this->LoginUser() ;          
    //     $this->withHeader('Authorization', 'Bearer ' .self::$token);  

    //    // $newAbsencePresence=self::absencePresenceData();
    //     $data= AbsencePresence::factory()->make(); 
    //     $responseCreate = $this->post(route('AbsencePresence.store'), $data->toArray());
    //     $anotherAbsencePresence=self::absencePresenceData();
      
    //     $responseUpdate = $this->put(route('AbsencePresence.update', $responseCreate['id']),$anotherAbsencePresence);
    //     $absencepresenceFounded =AbsencePresence::where('user_id', $anotherAbsencePresence["user_id"])
    //     ->where('status', $anotherAbsencePresence["status"])
    //     ->where('course_session_id', $anotherAbsencePresence["course_session_id"])
    //     ->where('teacher_id', $anotherAbsencePresence["teacher_id"])       
    //     ->first();
        
    //     $this->assertNotNull($absencepresenceFounded);
       
    // }
    // public function test_absencePresenceDelete()
    // {
    //     self::$token=self::$token!==null ? self::$token : $this->LoginUser() ;          
    //     $this->withHeader('Authorization', 'Bearer ' .self::$token);  
        
    //     $data= AbsencePresence::factory()->make();
    //     //$absencepresence=self::AbsencePresenceData();
    //     $response = $this->post(route('AbsencePresence.store'), $data->toArray() );
    //     $responseDelete = $this->delete(route('AbsencePresence.destroy', $response["id"]));
    //     $AbsencePresenceFound= AbsencePresence::withTrashed()->find($response["id"]);
     
    //     $this->assertSoftDeleted($AbsencePresenceFound);
    // }
    // public  function  absencePresenceData()
    // {

    //     $user_id=$this->faker->randomDigit;//$this->faker->randomDigit;
    //     $course_session_id= $this->faker->randomDigit;
    //     $teacher_id=$this->faker->randomDigit;
    //     $status=['dellay','absent','present'];

    //     $absencepresence=[
    //         'user_id' => $user_id,
    //         'teacher_id' => $teacher_id,
    //         'course_session_id' => $course_session_id,
    //         'status' => $status[rand(0,2)]
    //     ];
    //     return $absencepresence;
    // }

    // public function test_t1() 
    // {
    //     Log::info(BasicModule::test());
    //     $value=2;
    //     $this->assertTrue($value>1);
    // }
    
}
