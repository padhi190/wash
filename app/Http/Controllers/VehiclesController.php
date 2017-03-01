<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreVehiclesRequest;
use App\Http\Requests\UpdateVehiclesRequest;

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
        $vehicles = Vehicle::all();

        return view('vehicles.index', compact('vehicles'));
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
            'customers' => \App\Customer::get()->pluck('name', 'id')->prepend('Please select', ''),
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

        return redirect()->route('vehicles.index');
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

}
