<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreVehiclesRequest;
use App\Http\Requests\StoreVehicleFullRequest;
use App\Http\Requests\UpdateVehiclesRequest;
use Yajra\Datatables\Datatables;

class VehiclesController extends Controller
{
    /**
     * Display a listing of Vehicle.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('vehicle_access')) {
            return abort(401);
        }
        // $vehicles = Vehicle::orderBy('id', 'desc')->with('sales','customer')->get();
        $ajaxurl = 'loadVehiclesDataTables';
        $title = '';
        return view('vehicles.index', compact('ajaxurl','title'));
    }

    /**
     * Show the form for creating new Vehicle.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('vehicle_create')) {
            return abort(401);
        }
        $relations = [
            'customers' => \App\Customer::get()->pluck('first_vehicle', 'id')->prepend('Please select', ''),
            'customer_id' => null
        ];

        return view('vehicles.create', $relations);

    }

    /**
     * Store a newly created Vehicle in storage.
     *
     * @param  \App\Http\Requests\StoreVehiclesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehiclesRequest $request)
    {
        if (! Gate::allows('vehicle_create')) {
            return abort(401);
        }
        $vehicle = Vehicle::create($request->all());

        if (! Gate::allows('income_create')) {
            return redirect()->route('vehicles.index');
        }

        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'vehicles' => \App\Vehicle::get()->pluck('full_vehicle', 'id')->prepend('Please select', ''),
            'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id'),
            'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => \App\Account::get()->pluck('name', 'id'),
            'last_bon' => \App\Branch::where('id', session('branch_id'))->first()->last_bon,
            'vehicle_id' => $vehicle->id,
            'prices' => config('pricelist')
        ];

        return view('incomes.create', $relations);
    }


    /**
     * Show the form for editing Vehicle.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('vehicle_edit')) {
            return abort(401);
        }
        $relations = [
            'customers' => \App\Customer::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.edit', compact('vehicle') + $relations);
    }

    /**
     * Update Vehicle in storage.
     *
     * @param  \App\Http\Requests\UpdateVehiclesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehiclesRequest $request, $id)
    {
        if (! Gate::allows('vehicle_edit')) {
            return abort(401);
        }
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());

        return redirect()->route('vehicles.index');
    }


    /**
     * Display Vehicle.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('vehicle_view')) {
            return abort(401);
        }
        $relations = [
            'customers' => \App\Customer::get()->pluck('name', 'id')->prepend('Please select', ''),
            'incomes' => \App\Income::where('vehicle_id', $id)->where('branch_id', session('branch_id'))->orderBy('entry_date','desc')->get(),
            'tasks' => \App\Task::where('kendaraan_id', $id)->where('branch_id', session('branch_id'))->orderBy('due_date','desc')->get(),
        ];

        $vehicle = Vehicle::findOrFail($id);

        return view('vehicles.show', compact('vehicle') + $relations);
    }


    /**
     * Remove Vehicle from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('vehicle_delete')) {
            return abort(401);
        }
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('vehicles.index');
    }

    public function permanentdestroy($id)
    {
        if (! Gate::allows('vehicle_delete')) {
            return abort(401);
        }
        $vehicle = Vehicle::onlyTrashed();
        $vehicle->find($id);
        $vehicle->forceDelete();

        return redirect()->route('vehicles.trashed');
    }

    public function permanentdestroyall()
    {
        if (! Gate::allows('vehicle_delete')) {
            return abort(401);
        }
        $vehicle = Vehicle::onlyTrashed();
        $vehicle->forceDelete();

        return redirect()->route('vehicles.trashed');
    }

     public function restore($id)
    {
        if (! Gate::allows('vehicle_delete')) {
            return abort(401);
        }
        $vehicle = Vehicle::onlyTrashed();
        $vehicle->find($id);
        $vehicle->restore();

        return redirect()->route('vehicles.trashed');
    }

    /**
     * Delete all selected Vehicle at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('vehicle_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Vehicle::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function createIncome($id) {
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'vehicles' => \App\Vehicle::get()->pluck('full_vehicle', 'id')->prepend('Please select', ''),
            'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id'),
            'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => \App\Account::get()->pluck('name', 'id'),
            'last_bon' => \App\Branch::where('id', session('branch_id'))->first()->last_bon,
            'prices' => config('pricelist'),
            'vehicle_id' => $id
        ];

        return view('incomes.create', $relations);
    }

    public function createFull()
    {
        if (! Gate::allows('vehicle_create')) {
            return abort(401);
        }
        $relations = [
            'customers' => \App\Customer::get()->pluck('first_vehicle', 'id')->prepend('Please select', ''),
            'customer_id' => null,
            'vehicles' => \App\Vehicle::get()->pluck('full_vehicle', 'id')->prepend('Please select', ''),
            'income_categories' => \App\IncomeCategory::get()->pluck('name', 'id'),
            'products' => \App\Product::get()->pluck('name', 'id')->prepend('Please select', ''),
            'payment_types' => \App\Account::get()->pluck('name', 'id'),
            'last_bon' => \App\Branch::where('id', session('branch_id'))->first()->last_bon,
            'prices' => config('pricelist')
        ];

        return view('vehicles.createfull', $relations);

    }

    public function storeFull(StoreVehicleFullRequest $request)
    {
        if (! Gate::allows('vehicle_create')) {
            return abort(401);
        }

        // dd($request->customer_id);
        // $vehicle = Vehicle::create($request->all());
        $vehicle = new Vehicle;
        $vehicle->customer_id   = $request->customer_id;
        $vehicle->license_plate = $request->license_plate;
        $vehicle->type          = $request->type;
        $vehicle->brand         = $request->brand;
        $vehicle->model         = $request->model;
        $vehicle->color         = $request->color;
        $vehicle->size          = $request->size;
        $vehicle->save();

        if (! Gate::allows('income_create')) {
            return redirect()->route('vehicles.index');
        }

        $sales = new \App\Income;
        $sales->vehicle_id          = $vehicle->id;
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
        $message = 'Plat No. ' .  strtoupper($vehicle->license_plate) . ' & Bon no. ' . $request->nobon . ' berhasil ditambahkan!';
        $request->session()->flash('alert-success', $message);
        // $request->session()->flash('print-bon', '');
        return redirect()->route('incomes.create');

    }

    public function loadVehiclesDataTables()
    {
        $query    = Vehicle::query();
        $query->with('customer','sales');
        $query->select('vehicles.*');
        $template = 'actionsTemplate2';
        $datatables = Datatables::of($query);
        $datatables->setRowAttr([
                'data-entry-id' => '{{$id}}',
        ]);
        $datatables->editColumn('customer.name', function($q){
                    return $q->customer->name;
                });
        $datatables->editColumn('type', function($q){
                    return $q->full_vehicle;
        });
        $datatables->editColumn('actions', function ($row) use ($template) {
            $gateKey  = 'vehicle_';
            $routeKey = 'vehicles';

            return view($template, compact('row', 'gateKey', 'routeKey'));
        });
        $datatables->rawColumns(['actions']);
        $datatables->addColumn('test_url', function($q) {
            // return $q->id;
                return route('loadVehiclesSalesData', $q->id);
        });
        return $datatables->make(true);
    
 
   
    }

    public function loadTrashedVehiclesDataTables()
    {
        $query    = Vehicle::query();
        $query->onlyTrashed();
        $query->with('customer','sales');
        $query->select('vehicles.*');
        $template = 'actionsTemplateTrashed';
        $datatables = Datatables::of($query);
        $datatables->setRowAttr([
                'data-entry-id' => '{{$id}}',
        ]);
        $datatables->editColumn('customer.name', function($q){
                    return $q->customer->name;
                });
        $datatables->editColumn('type', function($q){
                    return $q->full_vehicle;
        });
        $datatables->editColumn('actions', function ($row) use ($template) {
            $gateKey  = 'vehicle_';
            $routeKey = 'vehicles';

            return view($template, compact('row', 'gateKey', 'routeKey'));
        });
        $datatables->rawColumns(['actions']);
        $datatables->addColumn('test_url', function($q) {
            // return $q->id;
                return route('loadVehiclesSalesData', $q->id);
        });
        return $datatables->make(true);
    
 
   
    }

    public function loadVehiclesSalesData($id)
    {
        $sales = Vehicle::findOrFail($id)->sales;
        
        return Datatables::of($sales)->make(true);
       
    }

    public function trashed()
    {
        if (! Gate::allows('vehicle_access')) {
            return abort(401);
        }
        // $vehicles = Vehicle::orderBy('id', 'desc')->with('sales','customer')->get();
        $ajaxurl = 'loadTrashedVehiclesDataTables';
        $title = '- Trashed';
        return view('vehicles.index', compact('ajaxurl','title'));
    }



}
