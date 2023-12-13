<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConsultantReportRequest;
use App\Http\Requests\UpdateConsultantReportRequest;
use App\Models\ConsultantReport;

class ConsultantReportController extends Controller
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
     * @param  \App\Http\Requests\StoreConsultantReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConsultantReportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConsultantReport  $consultantReport
     * @return \Illuminate\Http\Response
     */
    public function show(ConsultantReport $consultantReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConsultantReport  $consultantReport
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsultantReport $consultantReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateConsultantReportRequest  $request
     * @param  \App\Models\ConsultantReport  $consultantReport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConsultantReportRequest $request, ConsultantReport $consultantReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConsultantReport  $consultantReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsultantReport $consultantReport)
    {
        //
    }
}
