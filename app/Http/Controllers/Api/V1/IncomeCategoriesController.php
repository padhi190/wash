<?php

namespace App\Http\Controllers\Api\V1;

use App\IncomeCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncomeCategoriesRequest;
use App\Http\Requests\UpdateIncomeCategoriesRequest;

class IncomeCategoriesController extends Controller
{
    public function index()
    {
        return IncomeCategory::all();
    }

    public function show($id)
    {
        return IncomeCategory::findOrFail($id);
    }

    public function update(UpdateIncomeCategoriesRequest $request, $id)
    {
        $income_category = IncomeCategory::findOrFail($id);
        $income_category->update($request->all());

        return $income_category;
    }

    public function store(StoreIncomeCategoriesRequest $request)
    {
        $income_category = IncomeCategory::create($request->all());

        return $income_category;
    }

    public function destroy($id)
    {
        $income_category = IncomeCategory::findOrFail($id);
        $income_category->delete();
        return '';
    }
}
