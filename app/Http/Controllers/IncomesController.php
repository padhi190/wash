<?php

namespace App\Http\Controllers;

use App\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreIncomesRequest;
use App\Http\Requests\UpdateIncomesRequest;
use Carbon\Carbon;

class IncomesController extends Controller
{
    /**
     * Display a listing of Income
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('income_access')) {
            return abort(401);
        }

        $to = Carbon::now();
        $from = clone $to;
        $from->subDays(14);
        $from->hour=5;
        $from->minute=0;
        $incomes = Income::with('income_category','vehicle','payment_type')->orderBy('entry_date','desc')
                    ->whereBetween('entry_date', [$from, $to])
                    ->where('branch_id', session('branch_id'))
                    ->get();

        return view('incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating new Income.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadVehiclesData(Request $request)
    {
        if ($request->has('q')) {
            $data = \App\Vehicle::where('license_plate', 'LIKE', '%'.request('q').'%')->with('customer')->get();
            return response()->json($data);
        }
    }
    public function create()
    {
        if (! Gate::allows('income_create')) {
            return abort(401);
        }
        $minutes = 60*24;
        $minutes_fast = 60;
        $branches = Cache::remember('branches', $minutes, function () {
            return \App\Branch::get();
        });

        $payment_types = Cache::remember('payment_types', $minutes, function () {
            return \App\Account::get();
        });

        $income_categories = Cache::remember('income_categories', $minutes, function () {
            return \App\IncomeCategory::get();
        });

        $products = Cache::remember('products', $minutes, function () {
            return \App\Product::get();
        });

        // $vehicles = \App\Vehicle::with('customer')->get();
        // $vehicles = Cache::remember('vehicles', $minutes, function() {
        //     return \App\Vehicle::with('customer')->get();
        // });
            

        // $vehiclesAndCustomer = $vehicles->mapWithKeys(function($item,$key){
            
        //     return [$item['id'] => $item['customer']['name'] . ': ' .$item['full_vehicle']];
        // });

        // dd($vehiclesAndCustomer);

        // $customers = \App\Customer::with('latestVehicle')->get();

        // $customers = Cache::remember('customers', $minutes, function(){
        //     return \App\Customer::with('latestVehicle')->get();
        // });
        
        
        // $customersAndCar = $customers->mapWithKeys(function($item,$key){
            
        //     return [$item['id'] => $item['name'] . ': ' .$item['latestVehicle']['full_vehicle']];
        // });

        $last_sales = Income::orderBy('created_at','desc')->where('branch_id', session('branch_id'))->first();


        

        $relations = [
            // 'customers' => $customersAndCar->all(),
            'customer_id' => null,
            'branches' => $branches,
            // 'vehicles' => $vehiclesAndCustomer->all(),
            'income_categories' => $income_categories->pluck('name','id'),
            'products' => $products->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => $payment_types->pluck('name', 'id'),
            'last_bon' => \App\Branch::where('id', session('branch_id'))->first()->last_bon,
            'vehicle_id' => null,
            'prices' => config('pricelist'.session('branch_id')),
            'last_sales' => $last_sales,
        ];
        // dd($relations);

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
        // dd($request->all());
        $income = Income::create($request->all());

        //update last_bon used
        $branch = \App\Branch::findOrFail(session('branch_id'));
        $branch->update(['last_bon' => $request->nobon]);

        // return redirect()->route('incomes.index');
        $request->session()->flash('alert-success', 'Bon no. ' . $request->nobon . ' berhasil ditambahkan!');
        // $request->session()->flash('print-bon', '');
        return redirect()->route('incomes.create');
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

        // $vehicles = \App\Vehicle::with('customer')->get();

        // $vehiclesAndCustomer = $vehicles->mapWithKeys(function($item,$key){
            
        //     return [$item['id'] => $item['customer']['name'] . ': ' .$item['full_vehicle']];
        // });

        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            // 'vehicles' => $vehiclesAndCustomer->all(),
            'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id'),
            'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => \App\Account::get()->pluck('name', 'id'),
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
