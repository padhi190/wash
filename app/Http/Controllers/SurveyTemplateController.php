<?php

namespace App\Http\Controllers;

use App\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyTemplateController extends Controller
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
        return view('surveytemplates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $surveytemplate = SurveyTemplate::create($request->all());
        return view('surveytemplates.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(SurveyTemplate $surveyTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(SurveyTemplate $surveyTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SurveyTemplate $surveyTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(SurveyTemplate $surveyTemplate)
    {
        //
    }
}
