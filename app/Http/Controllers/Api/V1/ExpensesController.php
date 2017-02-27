<?php

namespace App\Http\Controllers\Api\V1;

use App\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpensesRequest;
use App\Http\Requests\UpdateExpensesRequest;
use Yajra\Datatables\Datatables;

class ExpensesController extends Controller
{
    public function index()
    {
        return Expense::all();
    }

    public function show($id)
    {
        return Expense::findOrFail($id);
    }

    public function update(UpdateExpensesRequest $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());

        return $expense;
    }

    public function store(StoreExpensesRequest $request)
    {
        $expense = Expense::create($request->all());

        return $expense;
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return '';
    }
}
