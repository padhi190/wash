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
        $surveytemplates = SurveyTemplate::all();
        return view('surveytemplates.index', compact('surveytemplates'));
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
        return redirect()->route('surveytemplate.index');
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
    public function edit($id)
    {
        //
        $surveytemplate = SurveyTemplate::findOrFail($id);

        return view('surveytemplates.edit', compact('surveytemplate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $surveytemplate = SurveyTemplate::findOrFail($id);
        $surveytemplate->update($request->all());

        return redirect()->route('surveytemplate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SurveyTemplate  $surveyTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $surveytemplate = surveytemplate::findOrFail($id);
        $surveytemplate->delete();

        return redirect()->route('surveytemplate.index');
    }
}
