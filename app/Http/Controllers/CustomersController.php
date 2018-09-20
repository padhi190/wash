<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreCustomersRequest;
use App\Http\Requests\StoreCustomerFullRequest;
use App\Http\Requests\UpdateCustomersRequest;
use Yajra\Datatables\Datatables;

class CustomersController extends Controller
{
    /**
     * Display a listing of Customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('customer_access')) {
            return abort(401);
        }
        // $customers = Customer::orderBy('join_date', 'desc')->with('vehicles','branch')->get();

        return view('customers.index');
    }

    public function loadCustomersData()
    {
        $query = Customer::select('id','branch_id','name','phone','email');
        $template = 'actionsTemplate2';
        return Datatables::of($query)
                ->editColumn('actions', function ($row) use ($template) {
                $gateKey  = 'customer_';
                $routeKey = 'customers';

                return view($template, compact('row', 'gateKey', 'routeKey'));
                })
                ->rawColumns(['actions'])
                ->make(true);
    }

    /**
     * Show the form for creating new Customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('customer_create')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
        ];

        return view('customers.create', $relations);
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @param  \App\Http\Requests\StoreCustomersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomersRequest $request)
    {
        if (! Gate::allows('customer_create')) {
            return abort(401);
        }
        $customer = Customer::create($request->all());

        if (! Gate::allows('vehicle_create')) {
            return redirect()->route('customers.index');
        }        

        $relations = [
            'customers' => \App\Customer::get()->pluck('name', 'id')->prepend('Please select', ''),
            'customer_id' => $customer->id
        ];

        return view('vehicles.create', $relations);
    }


    /**
     * Show the form for editing Customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('customer_edit')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
        ];

        $customer = Customer::findOrFail($id);

        return view('customers.edit', compact('customer') + $relations);
    }

    /**
     * Update Customer in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomersRequest $request, $id)
    {
        if (! Gate::allows('customer_edit')) {
            return abort(401);
        }
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customers.index');
    }


    /**
     * Display Customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('customer_view')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'vehicles' => \App\Vehicle::where('customer_id', $id)->get(),
        ];

        $customer = Customer::findOrFail($id);

        return view('customers.show', compact('customer') + $relations);
    }


    /**
     * Remove Customer from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('customer_delete')) {
            return abort(401);
        }
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index');
    }

    /**
     * Delete all selected Customer at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('customer_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Customer::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function createFull()
    {
        if (! Gate::allows('customer_create')) {
            return abort(401);
        }
        $relations = [
            'customer_id' => null,
            'vehicles' => \App\Vehicle::get()->pluck('full_vehicle', 'id')->prepend('Please select', ''),
            'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id'),
            'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => \App\Account::get()->pluck('name', 'id'),
            'last_bon' => \App\Branch::where('id', session('branch_id'))->first()->last_bon,
            'prices' => config('pricelist'),
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', '')
        ];

        return view('customers.createfull', $relations);

    }

    public function storeFull(StoreCustomerFullRequest $request)
    {
        if (! Gate::allows('customer_create')) {
            return abort(401);
        }

        // dd($request->customer_id);
        // $vehicle = Vehicle::create($request->all());
        $customer = new Customer;
        $customer->name          = $request->name;
        $customer->sex           = $request->sex;
        $customer->phone         = $request->phone;
        $customer->email         = $request->email;
        $customer->save();

        if (! Gate::allows('vehicle_create')) {
            return redirect()->route('customers.index');
        }

        $vehicle   = new \App\Vehicle;
        $vehicle->license_plate = $request->license_plate;
        $vehicle->type          = $request->type;
        $vehicle->brand         = $request->brand;
        $vehicle->model         = $request->model;
        $vehicle->color         = $request->color;
        $vehicle->size          = $request->size;
        $customer->vehicles()->save($vehicle);

        if (! Gate::allows('income_create')) {
            return redirect()->route('vehicles.index');
        }

        $sales = new \App\Income;
        $sales->entry_date          = $request->entry_date;
        $sales->qty                 = $request->qty;
        $sales->nobon               = $request->nobon;
        $sales->amount              = $request->amount;
        $sales->branch_id           = $request->branch_id;
        $sales->income_category_id  = $request->income_category_id;
        $sales->product_id          = $request->product_id;
        $sales->payment_type_id     = $request->payment_type_id;
        $sales->fnb_amount          = $request->fnb_amount;
        $sales->wax_amount          = $request->wax_amount;

        $vehicle->sales()->save($sales);
        

        $branch = \App\Branch::findOrFail(session('branch_id'));
        $branch->update(['last_bon' => $request->nobon]);

        // return redirect()->route('incomes.index');
        $message = 'Customer ' . ucwords($customer->name) . ' ,Plat No. ' .  strtoupper($vehicle->license_plate) . ' & Bon no. ' . $request->nobon . ' berhasil ditambahkan!';
        $request->session()->flash('alert-success', $message);
        // $request->session()->flash('print-bon', '');
        return redirect()->route('incomes.create');

        // $relations = [
        //     'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
        //     'vehicles' => \App\Vehicle::get()->pluck('full_vehicle', 'id')->prepend('Please select', ''),
        //     'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id'),
        //     'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
        //     'payment_types' => \App\Account::get()->pluck('name', 'id'),
        //     'last_bon' => \App\Branch::where('id', session('branch_id'))->first()->last_bon,
        //     'vehicle_id' => null,
        //     'prices' => config('pricelist')
        // ];

        // return view('incomes.create', $relations);
    }

}
