<?php

namespace App\Http\Controllers\Api\V1;

use App\ExpenseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseCategoriesRequest;
use App\Http\Requests\UpdateExpenseCategoriesRequest;

class ExpenseCategoriesController extends Controller
{
    public function index()
    {
        return ExpenseCategory::all();
    }

    public function show($id)
    {
        return ExpenseCategory::findOrFail($id);
    }

    public function update(UpdateExpenseCategoriesRequest $request, $id)
    {
        $expense_category = ExpenseCategory::findOrFail($id);
        $expense_category->update($request->all());

        return $expense_category;
    }

    public function store(StoreExpenseCategoriesRequest $request)
    {
        $expense_category = ExpenseCategory::create($request->all());

        return $expense_category;
    }

    public function destroy($id)
    {
        $expense_category = ExpenseCategory::findOrFail($id);
        $expense_category->delete();
        return '';
    }
}
