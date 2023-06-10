<?php

namespace App\Repositories;

use App\Http\Requests\CourseSessionCreateRequest;
use App\Http\Requests\CourseSessionEditRequest;
use App\Http\Requests\CourseSessionAddListOfDaysRequest;
use App\Http\Resources\CourseSessionResource;
use App\Http\Resources\CourseSessionErrorResource;
use App\Models\CourseSession;
use App\Repositories\Interfaces\CourseSessionRepositoryInterface as userInterface;

/**
 * Class CourseSessionRepository.
 */
class CourseSessionRepository  implements userInterface
{
    public function getAll()
    {
        return  CourseSessionResource::collection(CourseSession::all());
    }

    public function getCourseSession($id)
    {
        $data = CourseSession::find($id);
        if (isset($data))
            return new CourseSessionResource($data);
        else {
            return new CourseSessionErrorResource("not found to fetch.");
        }
    }

    public function addCourseSession(CourseSessionCreateRequest $request)
    {
        $data = self::courseSessionData($request);
        $response = CourseSession::create($data);
        return new CourseSessionResource($response);
    }

    public function updateCourseSession(CourseSessionEditRequest $request, CourseSession $CourseSession)
    {
        $data = self::courseSessionData($request);
        $courseUpdated = $CourseSession->update($data);
        if (!$courseUpdated) {
            return new CourseSessionErrorResource("not found to update.");   // not found to delete it is soft delete or id is not found
        }
        return new CourseSessionResource($CourseSession);
    }
    public function deleteCourseSession(CourseSession $CourseSession)
    {
        $isDelete = $CourseSession->delete();
        if (!$isDelete) {
            return new CourseSessionErrorResource("not found to delete.");   // not found to delete it is soft delete or id is not found
        }
        return new CourseSessionResource($CourseSession);
    }


    public function getNameOfTheDate($date)
    {
        $timestamp = strtotime($date);
        $day = date('l', $timestamp);
        return $day;
    }
    public function addListOfDays(CourseSessionAddListOfDaysRequest $request)
    {
        $date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $days = $request->input('days');
        while (strtotime($date) <= strtotime($to_date)) {
            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
            if (in_array($this->getNameOfTheDate($date), $days)) {
                $data = [
                    "start_date" => $date,
                    "start_time" => $request->input("from_time"),
                    "end_time" => $request->input("to_time"),
                    "name" => $request->input("name"),
                    "user_id" => $request->input("user_id"),
                    "course_id" => $request->input("course_id"),
                ];
                $CourseSessionResponse = CourseSession::create($data);
            }
        }
        if (!$CourseSessionResponse) {
            return new CourseSessionErrorResource("not found to AddListOfDays.");   // not found to delete it is soft delete or id is not found
        }
        return new CourseSessionResource($CourseSessionResponse);
    }

    public function courseSessionData($request)
    {
        $data = [
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ];
        return     $data;
    }
}
