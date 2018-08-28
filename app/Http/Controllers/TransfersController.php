<?php

namespace App\Http\Controllers;

use App\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreTransfersRequest;
use App\Http\Requests\UpdateTransfersRequest;

class TransfersController extends Controller
{
    /**
     * Display a listing of Transfer.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('transfer_access')) {
            return abort(401);
        }
        $transfers = Transfer::with('dari','ke','branch')->orderBy('tanggal', 'desc')->where('branch_id', session('branch_id'))->get();

        return view('transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating new Transfer.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('transfer_create')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'daris' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
            'kes' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        return view('transfers.create', $relations);
    }

    /**
     * Store a newly created Transfer in storage.
     *
     * @param  \App\Http\Requests\StoreTransfersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransfersRequest $request)
    {
        if (! Gate::allows('transfer_create')) {
            return abort(401);
        }
        $transfer = Transfer::create($request->all());

        return redirect()->route('transfers.index');
    }


    /**
     * Show the form for editing Transfer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('transfer_edit')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'daris' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
            'kes' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $transfer = Transfer::findOrFail($id);

        return view('transfers.edit', compact('transfer') + $relations);
    }

    /**
     * Update Transfer in storage.
     *
     * @param  \App\Http\Requests\UpdateTransfersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransfersRequest $request, $id)
    {
        if (! Gate::allows('transfer_edit')) {
            return abort(401);
        }
        $transfer = Transfer::findOrFail($id);
        $transfer->update($request->all());

        return redirect()->route('transfers.index');
    }


    /**
     * Display Transfer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('transfer_view')) {
            return abort(401);
        }
        $relations = [
            'branches' => \App\Branch::get()->pluck('branch_name', 'id')->prepend('Please select', ''),
            'daris' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
            'kes' => \App\Account::get()->pluck('name', 'id')->prepend('Please select', ''),
        ];

        $transfer = Transfer::findOrFail($id);

        return view('transfers.show', compact('transfer') + $relations);
    }


    /**
     * Remove Transfer from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('transfer_delete')) {
            return abort(401);
        }
        $transfer = Transfer::findOrFail($id);
        $transfer->delete();

        return redirect()->route('transfers.index');
    }

    /**
     * Delete all selected Transfer at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('transfer_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Transfer::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function refresh()
    {
        Cache::flush();
        return back();
    }

}
