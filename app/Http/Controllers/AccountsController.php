<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreAccountsRequest;
use App\Http\Requests\UpdateAccountsRequest;
use Yajra\Datatables\Datatables;

class AccountsController extends Controller
{
    /**
     * Display a listing of Account.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('account_access')) {
            return abort(401);
        }
        $accounts = Account::all();

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Show the form for creating new Account.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('account_create')) {
            return abort(401);
        }
        return view('accounts.create');
    }

    /**
     * Store a newly created Account in storage.
     *
     * @param  \App\Http\Requests\StoreAccountsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountsRequest $request)
    {
        if (! Gate::allows('account_create')) {
            return abort(401);
        }
        $account = Account::create($request->all());

        return redirect()->route('accounts.index');
    }


    /**
     * Show the form for editing Account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('account_edit')) {
            return abort(401);
        }
        $account = Account::findOrFail($id);

        return view('accounts.edit', compact('account'));
    }

    /**
     * Update Account in storage.
     *
     * @param  \App\Http\Requests\UpdateAccountsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountsRequest $request, $id)
    {
        if (! Gate::allows('account_edit')) {
            return abort(401);
        }
        $account = Account::findOrFail($id);
        $account->update($request->all());

        return redirect()->route('accounts.index');
    }


    /**
     * Display Account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('account_view')) {
            return abort(401);
        }
        $relations = [
            'transfers' => \App\Transfer::where('dari_id', $id)->get(),
            'transfers' => \App\Transfer::where('ke_id', $id)->get(),
            'expenses' => \App\Expense::where('from_id', $id)->get(),
            'incomes' => \App\Income::where('payment_type_id', $id)->get(),
        ];

        $account = Account::findOrFail($id);

        return view('accounts.show', compact('account') + $relations);
    }


    /**
     * Remove Account from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('account_delete')) {
            return abort(401);
        }
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->route('accounts.index');
    }

    /**
     * Delete all selected Account at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('account_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Account::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
