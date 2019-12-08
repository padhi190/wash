<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Income;
use App\SurveyTemplate;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Http\Requests\StoreSurvey;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

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
        $ajaxurl = 'loadSurveyData';
        $survey_template_id = \App\SurveyTemplate::get()->pluck('template_name', 'id')->prepend('Please select', '');
        return view('surveys.index', compact('ajaxurl', 'survey_template_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($branch_id, $income_id)
    {
        $income_id = base_convert($income_id, 16, 10);
        // dd(url('survey.create/{{$branch_id}}/{{$income_id}}'));
        // dd(route('survey.create', ['branch_id' => $branch_id, 'income_id' => $income_id]));
        $bon = Income::where('id',$income_id)->where('branch_id',$branch_id)->first();
        
        if(is_null($bon)){
            $message = 'Data Tidak Ditemukan';
            return view('surveys.message',compact('message'));
        }

        $survey_exist = Survey::where('income_id', $bon->id)->where('branch_id', $branch_id)->count();
        $branch = \App\Branch::find($branch_id);
        $survey_template = $branch->survey_template;
        if($survey_exist)
        {
            $message = "Anda sudah mengisi survey. Terima Kasih.";
            return view('surveys.message', compact('message'));
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
    public function store(StoreSurvey $request)
    {
        //
        $survey_exist = Survey::where('income_id', $request->income_id)->where('branch_id', $request->branch_id)->count();
        if($survey_exist)
        {
            $message = 'Ulasan Anda sudah kami terima';
            return view('surveys.message', compact('message'));
        }
        $income = Income::where('id',$request->income_id)->where('branch_id',$request->branch_id)->count();
        $branch = \App\Branch::find($request->branch_id);
        if($income)
        {
            $survey = Survey::create($request->all());
            $phone = $survey->income->vehicle->customer->phone;
            Helper::sendVOUCHER($survey->income, $branch);
        }
        $message = "Terima Kasih atas feedback Anda";
        return view('surveys.message', compact('message'));
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

    public function loadSurveyData(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);
        
        $to = $enddate;
        $from = $startdate;
        $survey_template_id = $request->input('survey_template_id');
        // $to = Carbon::now();
        // $from = clone $to;
        // $from->subDays(14);
        // $from->hour=5;
        // $from->minute=0;

        $query = Survey::query();
        $query->whereBetween('created_at',[$from, $to])->where('branch_id', session('branch_id'))->where('template_id', $survey_template_id);
        $query->with('income');
        $query->select('surveys.*');
        $template = 'actionsTemplate2';

        $datatables = Datatables::of($query);
        $datatables->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
        $datatables->editColumn('amount', function($query){
                  return number_format($query->income->total_amount);  
                });
        // $datatables->editColumn('amount_rp', function($q){
        //     return 'Rp. ' . number_format($q->amount);
        // });
        // $datatables->editColumn('actions', function ($row) use ($template) {
        //         $gateKey  = 'expense_';
        //         $routeKey = 'expenses';

        //         return view($template, compact('row', 'gateKey', 'routeKey'));
        //     });
        // $datatables->rawColumns(['actions']);
        return $datatables->make(true);
    }

}
