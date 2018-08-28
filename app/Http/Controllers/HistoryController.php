<?php

namespace App\Http\Controllers;

use App\Income;
use App\Expense;
use App\Http\Requests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $incomes = Income::with('income_category','vehicle','payment_type')->orderBy('entry_date','desc')
                    // ->whereBetween('entry_date', [$from, $to])
                    ->where('branch_id', session('branch_id'))
                    ->get();

        return view('incomes.index', compact('incomes'));   
    }

    public function expense()
    {
        if (! Gate::allows('expense_access')) {
            return abort(401);
        }

        // $to = Carbon::now();
        // $from = clone $to;
        // $from->subDays(1);
        // $from->hour=5;
        // $from->minute=0;
        $expenses = Expense::with('expense_category','employee','from')->orderBy('entry_date','desc')
                    // ->whereBetween('entry_date', [$from, $to])
                    ->where('branch_id', session('branch_id'))
                    ->get();

        return view('expenses.index', compact('expenses'));   
    }

}
