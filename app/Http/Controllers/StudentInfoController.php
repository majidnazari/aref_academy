<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentInfoRequest;
use App\Http\Requests\UpdateStudentInfoRequest;
use App\Models\StudentInfo;

class StudentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentInfoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function show(StudentInfo $studentInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentInfo $studentInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentInfoRequest  $request
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentInfoRequest $request, StudentInfo $studentInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentInfo  $studentInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentInfo $studentInfo)
    {
        //
    }
}
