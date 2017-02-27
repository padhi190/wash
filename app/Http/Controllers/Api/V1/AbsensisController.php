<?php

namespace App\Http\Controllers\Api\V1;

use App\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAbsensisRequest;
use App\Http\Requests\UpdateAbsensisRequest;
use Yajra\Datatables\Datatables;

class AbsensisController extends Controller
{
    public function index()
    {
        return Absensi::all();
    }

    public function show($id)
    {
        return Absensi::findOrFail($id);
    }

    public function update(UpdateAbsensisRequest $request, $id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->update($request->all());

        return $absensi;
    }

    public function store(StoreAbsensisRequest $request)
    {
        $absensi = Absensi::create($request->all());

        return $absensi;
    }

    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();
        return '';
    }
}
