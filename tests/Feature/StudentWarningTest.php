<?php

namespace Tests\Feature;

use App\Models\StudentWarning;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentWarningTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getAllStudentWarning()
    {
        $count=rand(1,3);
        $student_warning_model = StudentWarning::factory($count)->create();
      
        $this->assertGreaterThanOrEqual($count,StudentWarning::all()->count());

    }

    public function test_createStudentWarning1()
    {
        $student_warning_model=StudentWarning::factory()->make()->toArray();
       // BasicModule
        StudentWarning::create($student_warning_model);
        $this->assertDatabaseHas('student_warnings',$student_warning_model);
    }
    public function test_updateStudentWarning()
    {
        $student_warning_model=StudentWarning::factory()->make()->toArray();
        StudentWarning::create($student_warning_model);
        $student_warning_model_new=StudentWarning::factory()->make()->toArray();
        $founded_student_warning_updated=StudentWarning::where($student_warning_model)->update($student_warning_model_new);

        $this->assertDatabaseHas('student_warnings',$student_warning_model_new);
    }
    public function test_deleteStudentWarning()
    {
        $student_warning_model=StudentWarning::factory()->make()->toArray();
        $student_warning_created=StudentWarning::create($student_warning_model);
        $student_warning_created->delete();
        //$founded_student_warning_updated=StudentWarning::where($student_warning_model)->delete();
        //$this->assertSoftDeleted($student_warning_created);
        //$this->assertTrue(StudentWarning::where($student_warning_created)->exists());
        $this->assertDatabaseMissing('student_warnings', $student_warning_model);
       //if
        // if(!StudentWarning::where($student_warning_created)->first())
        // {
        //     $this->assertTrue(true);
        // }

    }
}
