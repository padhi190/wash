<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Income;
use App\SurveyTemplate;
use Illuminate\Http\Request;

class SurveyController extends Controller
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
    public function create($branch_id, $income_id)
    {
        // dd(url('survey.create/{{$branch_id}}/{{$income_id}}'));
        // dd(route('survey.create', ['branch_id' => $branch_id, 'income_id' => $income_id]));
        $bon = Income::where('id',$income_id)->where('branch_id',$branch_id)->first();

        $survey_exist = Survey::where('income_id', $bon->id)->where('branch_id', $branch_id)->count();
        $survey_template = SurveyTemplate::find('1');
        if($survey_exist)
        {
            echo "Anda sudah mengisi survey. Terima Kasih.";
        }
        else
        {

            // dd($bon);
            return view('surveys.create', compact('bon','survey_template'));
            
        }

        
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
        $income = Income::where('id',$request->income_id)->where('branch_id',$request->branch_id)->count();
        if($income)
            $survey = Survey::create($request->all());
        echo "Terima Kasih";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Survey $survey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        //
    }
}
