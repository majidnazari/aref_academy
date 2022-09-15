<?php

namespace Tests\Feature;

use App\Models\StudentWarning;
use App\Models\StudentWarningHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentWarningHistoryTest extends TestCase
{
    use WithFaker;
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getAllStudentWarningHistory()
    {
        $count=rand(1,3);
        $student_warning_history_model = StudentWarningHistory::factory($count)->create();
      
        $this->assertGreaterThanOrEqual($count,StudentWarningHistory::all()->count());

    }

    public function test_createStudentWarningHistory()
    {
        $student_warning_history_model=StudentWarningHistory::factory()->make()->toArray();
        StudentWarningHistory::create($student_warning_history_model);
        $this->assertDatabaseHas('student_warning_histories',$student_warning_history_model);
    }
    public function test_updateStudentWarningHistory()
    {
        $student_warning_history_model=StudentWarningHistory::factory()->make()->toArray();
        StudentWarningHistory::create($student_warning_history_model);
        $student_warning_history_model_new=StudentWarningHistory::factory()->make()->toArray();
        $found_student_warning_history_updated=StudentWarningHistory::where($student_warning_history_model)->update($student_warning_history_model_new);

        $this->assertDatabaseHas('student_warning_histories',$student_warning_history_model_new);
    }
    public function test_deleteStudentWarningHistory()
    {
        $student_warning_history_model=StudentWarningHistory::factory()->make()->toArray();
        $student_warning_history_created=StudentWarningHistory::create($student_warning_history_model);
        $student_warning_history_created->delete();
        $this->assertSoftDeleted($student_warning_history_created);
       
        //$this->assertDatabaseMissing('student_warning_histories', $student_warning_model);      
    }
    public function test_createStudentWarningAndCreateStudentWarningHistory()
    {
        $student_warning_history_model=StudentWarningHistory::factory()->make()->toArray();
        $student_warning_history_created=StudentWarningHistory::create($student_warning_history_model);
        
        $student_warning_model=StudentWarning::factory()->make()->toArray();
        $student_warning_model['student_warning_history_id']=$student_warning_history_created->id;

        $student_warning_created=StudentWarning::create($student_warning_model);

        $this->assertDatabaseHas('student_warnings',$student_warning_model);
        $this->assertDatabaseHas('student_warning_histories',$student_warning_history_model);
    }
    public function test_update_student_wrning_histories_delete_student_warning(){
        $student_warning_history_model=StudentWarningHistory::factory()->make()->toArray();
        $student_id=$student_warning_history_model['student_id'];
        $student_warning_history_created=StudentWarningHistory::create($student_warning_history_model);
        
        $student_warning_model=StudentWarning::factory()->make()->toArray();
        $student_warning_model['student_warning_history_id']=$student_warning_history_created->id;
        $student_warning_created=StudentWarning::create($student_warning_model);

        $this->assertDatabaseHas('student_warnings',$student_warning_model);

        // $found_student_warning=StudentWarning::where('student_id',$student_warning_created)->first();
        //$this->assertTrue($found_student_warning!==null);
        $found_student_warning_history=StudentWarningHistory::where('id',$student_warning_model['student_warning_history_id'])
        ->first();

        // $this->assertDatabaseHas("student_warning_histories",$found_student_warning_history);


        $found_student_warning_history->response="done";
        $found_student_warning_history->update();
        $found_student_warning_history->save();

        $this->assertDatabaseHas("student_warning_histories",[
            "user_id_creator" => $found_student_warning_history->user_id_creator,
            "user_id_updator" => $found_student_warning_history->user_id_updator,
            "student_id" => $found_student_warning_history->student_id,
            "course_id" => $found_student_warning_history->course_id,
            "comment" => $found_student_warning_history->comment,
            "response" => "done"
        ]
        );

        $student_warning_created->delete();

        $this->assertDatabaseMissing('student_warnings',$student_warning_model);



    }

}
