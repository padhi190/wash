<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreExpensesRequest;
use App\Http\Requests\UpdateExpensesRequest;
use Yajra\Datatables\Datatables;

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
        $expenses = Expense::orderBy('entry_date', 'desc')->where('branch_id', session('branch_id'))->get();

        return view('expenses.index', compact('expenses'));
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
            'froms' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
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
            'froms' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
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

}
