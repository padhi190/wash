<?php

namespace App\Http\Controllers;

use App\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreIncomesRequest;
use App\Http\Requests\UpdateIncomesRequest;

class IncomesController extends Controller
{
    /**
     * Display a listing of Income.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('income_access')) {
            return abort(401);
        }
        $incomes = Income::orderBy('entry_date','desc')->where('branch_id', session('branch_id'))->get();

        return view('incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating new Income.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('income_create')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'vehicles' => \App\Vehicle::get()->pluck('license_plate', 'id')->prepend('Please select', ''),
            'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id')->prepend('Please select', ''),
            'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
            'vehicle_id' => null
        ];

        return view('incomes.create', $relations);
    }

    /**
     * Store a newly created Income in storage.
     *
     * @param  \App\Http\Requests\StoreIncomesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIncomesRequest $request)
    {
        if (! Gate::allows('income_create')) {
            return abort(401);
        }
        $income = Income::create($request->all());

        return redirect()->route('incomes.index');
    }


    /**
     * Show the form for editing Income.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('income_edit')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'vehicles' => \App\Vehicle::get()->pluck('license_plate', 'id')->prepend('Please select', ''),
            'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id')->prepend('Please select', ''),
            'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $income = Income::findOrFail($id);

        return view('incomes.edit', compact('income') + $relations);
    }

    /**
     * Update Income in storage.
     *
     * @param  \App\Http\Requests\UpdateIncomesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIncomesRequest $request, $id)
    {
        if (! Gate::allows('income_edit')) {
            return abort(401);
        }
        $income = Income::findOrFail($id);
        $income->update($request->all());

        return redirect()->route('incomes.index');
    }


    /**
     * Display Income.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('income_view')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'vehicles' => \App\Vehicle::get()->pluck('license_plate', 'id')->prepend('Please select', ''),
            'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id')->prepend('Please select', ''),
            'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $income = Income::findOrFail($id);

        return view('incomes.show', compact('income') + $relations);
    }


    /**
     * Remove Income from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('income_delete')) {
            return abort(401);
        }
        $income = Income::findOrFail($id);
        $income->delete();

        return redirect()->route('incomes.index');
    }

    /**
     * Delete all selected Income at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('income_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Income::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
