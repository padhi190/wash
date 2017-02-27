<?php

namespace App\Http\Controllers;

use App\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreAbsensisRequest;
use App\Http\Requests\UpdateAbsensisRequest;
use Yajra\Datatables\Datatables;

class AbsensisController extends Controller
{
    /**
     * Display a listing of Absensi.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('absensi_access')) {
            return abort(401);
        }
        $absensis = Absensi::all();

        return view('absensis.index', compact('absensis'));
    }

    /**
     * Show the form for creating new Absensi.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('absensi_create')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'karyawans' => \App\Employee::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        return view('absensis.create', $relations);
    }

    /**
     * Store a newly created Absensi in storage.
     *
     * @param  \App\Http\Requests\StoreAbsensisRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAbsensisRequest $request)
    {
        if (! Gate::allows('absensi_create')) {
            return abort(401);
        }
        $absensi = Absensi::create($request->all());

        return redirect()->route('absensis.index');
    }


    /**
     * Show the form for editing Absensi.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('absensi_edit')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'karyawans' => \App\Employee::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $absensi = Absensi::findOrFail($id);

        return view('absensis.edit', compact('absensi') + $relations);
    }

    /**
     * Update Absensi in storage.
     *
     * @param  \App\Http\Requests\UpdateAbsensisRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAbsensisRequest $request, $id)
    {
        if (! Gate::allows('absensi_edit')) {
            return abort(401);
        }
        $absensi = Absensi::findOrFail($id);
        $absensi->update($request->all());

        return redirect()->route('absensis.index');
    }


    /**
     * Display Absensi.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('absensi_view')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'karyawans' => \App\Employee::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $absensi = Absensi::findOrFail($id);

        return view('absensis.show', compact('absensi') + $relations);
    }


    /**
     * Remove Absensi from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('absensi_delete')) {
            return abort(401);
        }
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensis.index');
    }

    /**
     * Delete all selected Absensi at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('absensi_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Absensi::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
