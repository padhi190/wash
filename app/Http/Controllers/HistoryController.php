<?php

namespace App\Http\Controllers;

use App\Income;
use App\Expense;
use App\Http\Requests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class HistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function income()
    {
        if (! Gate::allows('income_access')) {
            return abort(401);
        }

        // $to = Carbon::now();
        // $from = clone $to;
        // $from->subDays(1);
        // $from->hour=5;
        // $from->minute=0;
        // $incomes = Income::with('income_category','vehicle','payment_type')->orderBy('entry_date','desc')
        //             // ->whereBetween('entry_date', [$from, $to])
        //             ->where('branch_id', session('branch_id'))
        //             ->get();
        $ajaxurl = 'loadFullIncomesData';
        $title = 'Full';
        return view('incomes.index', compact('ajaxurl', 'title'));   
    }

    public function loadFullIncomesData()
    {
        
        $query = Income::query();
        $query->where('branch_id', session('branch_id'))->with('income_category', 'vehicle','payment_type');
        $query->select('incomes.*');
        $template = 'actionsTemplate';

        $datatables = Datatables::of($query);
        $datatables->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
        $datatables->editColumn('entry_date', function($q){
            return $q->entry_date ?  with(new Carbon($q->entry_date))->format('m/d/Y') : '';
            });
        $datatables->editColumn('entry_time', function($q){
            return $q->entry_date ?  with(new Carbon($q->entry_date))->format('H:i') : '';
            });

        $datatables->editColumn('total_amount_number', function($query){
                  return $query->total_amount;  
                });
        $datatables->editColumn('total_amount', function($query){
                  return 'Rp '. number_format($query->total_amount);  
                });
        $datatables->editColumn('income_category_name', function($q){
                  return $q->income_category->name.$q->additional_sales;  
                });
        $datatables->editColumn('full_vehicle', function($q){
                    return $q->vehicle->full_vehicle;
                });
        $datatables->editColumn('actions', function ($row) use ($template) {
                $gateKey  = 'income_';
                $routeKey = 'incomes';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
        $datatables->rawColumns(['actions']);

        return $datatables->make(true);
    }

    public function expense()
    {
         if (! Gate::allows('expense_access')) {
            return abort(401);
        }
        // $to = Carbon::now();
        // $from = clone $to;
        // $from->subDays(7);
        // $from->hour=5;
        // $from->minute=0;
        // $expenses = Expense::with('expense_category','employee','from')->orderBy('entry_date', 'desc')
        //             ->whereBetween('entry_date', [$from, $to])
        //             ->where('branch_id', session('branch_id'))
        //             ->get();
        $ajaxurl = 'loadFullExpensesData';
        $title = 'Full';
        return view('expenses.index', compact('ajaxurl', 'title'));
    }

    public function loadFullExpensesData()
    {
        // $to = Carbon::now();
        // $from = clone $to;
        // $from->subDays(14);
        // $from->hour=5;
        // $from->minute=0;

        $query = Expense::query();
        $query->where('branch_id', session('branch_id'));
        $query->with('from','expense_category');
        $query->select('expenses.*');
        $template = 'actionsTemplate3';

        $datatables = Datatables::of($query);
        $datatables->setRowAttr([
                'data-entry-id' => '{{$id}}',
            ]);
        $datatables->editColumn('amount_rp', function($q){
            return 'Rp. ' . number_format($q->amount);
        });
         $datatables->editColumn('entry_date', function($q){
            return $q->entry_date ?  with(new Carbon($q->entry_date))->format('m/d/Y') : '';
            });
        $datatables->editColumn('actions', function ($row) use ($template) {
                $gateKey  = 'expense_';
                $routeKey = 'expenses';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
        $datatables->rawColumns(['actions']);
        return $datatables->make(true);
    }

}
