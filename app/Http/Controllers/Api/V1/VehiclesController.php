<?php

namespace App\Http\Controllers\Api\V1;

use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehiclesRequest;
use App\Http\Requests\UpdateVehiclesRequest;

class VehiclesController extends Controller
{
    public function index()
    {
        return Vehicle::all();
    }

    public function show($id)
    {
        return Vehicle::findOrFail($id);
    }

    public function update(UpdateVehiclesRequest $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());

        return $vehicle;
    }

    public function store(StoreVehiclesRequest $request)
    {
        $vehicle = Vehicle::create($request->all());

        return $vehicle;
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return '';
    }
}
