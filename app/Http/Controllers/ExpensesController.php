<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreExpensesRequest;
use App\Http\Requests\UpdateExpensesRequest;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;


class ExpensesController extends Controller
{
    /**
     * Display a listing of Expense.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $ajaxurl = 'loadExpensesData';
        $title = 'Last 14 Days';
        return view('expenses.index', compact('ajaxurl', 'title'));
    }

    public function loadExpensesData(Request $request)
    {
        $arrStart = explode("-", $request->input('startdate'));
        $arrEnd = explode("-", $request->input('enddate'));
        $startdate = Carbon::create($arrStart[2],$arrStart[1], $arrStart[0], 0, 0, 0);
        $enddate = Carbon::create($arrEnd[2],$arrEnd[1], $arrEnd[0], 23, 59, 0);
        
        $to = $enddate;
        $from = $startdate;
        // $to = Carbon::now();
        // $from = clone $to;
        // $from->subDays(14);
        // $from->hour=5;
        // $from->minute=0;

        $query = Expense::query();
        $query->whereBetween('entry_date',[$from, $to])->where('branch_id', session('branch_id'));
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
        $datatables->editColumn('actions', function ($row) use ($template) {
                $gateKey  = 'expense_';
                $routeKey = 'expenses';

                return view($template, compact('row', 'gateKey', 'routeKey'));
            });
        $datatables->rawColumns(['actions']);
        return $datatables->make(true);
    }

    /**
     * Show the form for creating new Expense.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('expense_create')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'expense_categories' => \App\ExpenseCategory::get()->pluck('name', 'id')->prepend('Please select', ''),
            'employees' => \App\Employee::get()->pluck('name', 'id')->prepend('Please select', ''),
            'froms' => \App\Account::get()->pluck('name', 'id'),
        ];

        return view('expenses.create', $relations);
    }

    /**
     * Store a newly created Expense in storage.
     *
     * @param  \App\Http\Requests\StoreExpensesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpensesRequest $request)
    {
        if (! Gate::allows('expense_create')) {
            return abort(401);
        }
        $expense = Expense::create($request->all());

        $request->session()->flash('alert-success', 'Bon no. ' . $expense->id . ' berhasil ditambahkan!');
        $request->session()->flash('print-bon',array($expense->id, $expense->entry_date, $expense->expense_category->name , $expense->amount, $expense->signature));

        return redirect()->route('expenses.index');
    }


    /**
     * Show the form for editing Expense.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('expense_edit')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'expense_categories' => \App\ExpenseCategory::get()->pluck('name', 'id')->prepend('Please select', ''),
            'employees' => \App\Employee::get()->pluck('name', 'id')->prepend('Please select', ''),
            'froms' => \App\Account::get()->pluck('name', 'id'),
        ];

        $expense = Expense::findOrFail($id);

        return view('expenses.edit', compact('expense') + $relations);
    }

    /**
     * Update Expense in storage.
     *
     * @param  \App\Http\Requests\UpdateExpensesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpensesRequest $request, $id)
    {
        if (! Gate::allows('expense_edit')) {
            return abort(401);
        }
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());

        return redirect()->route('expenses.index');
    }


    /**
     * Display Expense.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('expense_view')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'expense_categories' => \App\ExpenseCategory::get()->pluck('name', 'id')->prepend('Please select', ''),
            'employees' => \App\Employee::get()->pluck('name', 'id')->prepend('Please select', ''),
            'froms' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $expense = Expense::findOrFail($id);

        return view('expenses.show', compact('expense') + $relations);
    }


    /**
     * Remove Expense from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('expense_delete')) {
            return abort(401);
        }
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index');
    }

    /**
     * Delete all selected Expense at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('expense_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Expense::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function loadTrashedExpensesData()
    {

        $query = Expense::query();
        $query->onlyTrashed();
        $query->where('branch_id', session('branch_id'));
        $query->with('from','expense_category');
        $query->select('expenses.*');
        $template = 'actionsTemplateTrashed';

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

    public function trashed()
    {
        if (! Gate::allows('expense_access')) {
            return abort(401);
        }
        // $vehicles = Vehicle::orderBy('id', 'desc')->with('sales','customer')->get();
        $ajaxurl = 'loadTrashedExpensesData';
        $title = 'Trashed';
        return view('expenses.index', compact('ajaxurl','title'));
    }

    public function restore($id)
    {
        if (! Gate::allows('expense_delete')) {
            return abort(401);
        }
        $expense = Expense::onlyTrashed();
        $expense->find($id);
        $expense->restore();

        return redirect()->route('expenses.trashed');
    }

    public function permanentdestroy($id)
    {
        if (! Gate::allows('expense_delete')) {
            return abort(401);
        }
        $expense = Expense::onlyTrashed();
        $expense->find($id);
        $expense->forceDelete();

        return redirect()->route('expenses.trashed');
    }

    public function permanentdestroyall()
    {
        if (! Gate::allows('expense_delete')) {
            return abort(401);
        }
        $expense = Expense::onlyTrashed();
        $expense->forceDelete();

        return redirect()->route('expenses.trashed');
    }

}
